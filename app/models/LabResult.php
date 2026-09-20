<?php
class LabResult {
  public static function ensure($requestId) {
    $db = Db::get();
    $st = $db->prepare("SELECT * FROM lab_result WHERE request_id=?");
    $st->execute([$requestId]);
    if ($r = $st->fetch()) return $r;
    $db->prepare("INSERT INTO lab_result(request_id) VALUES (?)")->execute([$requestId]);
    $st->execute([$requestId]); return $st->fetch();
  }
  public static function save($requestId, $specimen, $finding, $critical, $userId) {
    self::ensure($requestId);
    $st = Db::get()->prepare(
     "UPDATE lab_result SET specimen=?, finding=?, critical_flag=?, entered_by=?, entry_time=NOW(), accept_status='Pending' WHERE request_id=?");
    $st->execute([$specimen, $finding, $critical ? 1 : 0, $userId, $requestId]);
    Audit::log('LAB_RESULT_ENTER', 'labreq:'.$requestId);
  }
  public static function accept($requestId) {
    $db = Db::get();
    $db->prepare("UPDATE lab_result SET accept_status='Accepted' WHERE request_id=?")->execute([$requestId]);
    LabRequest::setStatus($requestId, 'Completed');
    Audit::log('LAB_RESULT_ACCEPT', 'labreq:'.$requestId);
    $req = LabRequest::find($requestId);
    $st = $db->prepare("SELECT critical_flag FROM lab_result WHERE request_id=?");
    $st->execute([$requestId]);
    if ($st->fetch()['critical_flag']) {
      Notification::create($req['doctor_id'], $req['patient_id'], 'Lab '.$req['barcode'],
        'CRITICAL lab result for '.$req['patient_name'].' ('.$req['test_name'].')');
    }
  }
  public static function reject($requestId) {
    Db::get()->prepare("UPDATE lab_result SET accept_status='Pending' WHERE request_id=?")->execute([$requestId]);
    Audit::log('LAB_RESULT_REJECT', 'labreq:'.$requestId);
  }
}
