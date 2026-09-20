<?php
class LabRequest {
  public static function create($pid, $doctorId, $testCode) {
    $db = Db::get();
    $st = $db->prepare("SELECT COUNT(*) c FROM lab_request WHERE patient_id=? AND test_code=?");
    $st->execute([$pid, $testCode]); $no = $st->fetch()['c'] + 1;
    $barcode = sprintf('%s-%s-%03d', $pid, $testCode, $no);
    $st = $db->prepare("INSERT INTO lab_request(patient_id,doctor_id,test_code,request_no,barcode) VALUES (?,?,?,?,?)");
    $st->execute([$pid, $doctorId, $testCode, $no, $barcode]);
    Audit::log('LAB_REQUEST', $barcode);
    return $barcode;
  }
  public static function pendingAll() {
    $st = Db::get()->query(
     "SELECT r.*, t.test_name, p.name patient_name FROM lab_request r
      JOIN test_type t ON t.test_code=r.test_code JOIN patient p ON p.patient_id=r.patient_id
      WHERE r.status <> 'Completed' ORDER BY r.request_datetime");
    return $st->fetchAll();
  }
  public static function find($id) {
    $st = Db::get()->prepare(
     "SELECT r.*, t.test_name, p.name patient_name FROM lab_request r
      JOIN test_type t ON t.test_code=r.test_code JOIN patient p ON p.patient_id=r.patient_id
      WHERE r.request_id=?");
    $st->execute([$id]); return $st->fetch();
  }
  public static function setStatus($id, $status) {
    Db::get()->prepare("UPDATE lab_request SET status=? WHERE request_id=?")->execute([$status, $id]);
    Audit::log('LAB_STATUS_'.$status, 'labreq:'.$id);
  }
  public static function resultsForPatient($pid) {
    $st = Db::get()->prepare(
     "SELECT r.barcode, r.request_datetime, t.test_name, res.finding, res.accept_status, res.critical_flag
      FROM lab_request r JOIN test_type t ON t.test_code=r.test_code
      LEFT JOIN lab_result res ON res.request_id=r.request_id
      WHERE r.patient_id=? ORDER BY r.request_datetime DESC");
    $st->execute([$pid]); return $st->fetchAll();
  }
}
