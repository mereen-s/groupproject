<?php
class Admission {
  public static function createPending($pid, $deptId, $diagnosis='') {
    $st = Db::get()->prepare("INSERT INTO admission(patient_id,department_id,status,diagnosis) VALUES (?,?, 'Pending', ?)");
    $st->execute([$pid, $deptId, $diagnosis]);
    $id = Db::get()->lastInsertId();
    Audit::log('ADMISSION_ORDER', 'admission:'.$id.' patient:'.$pid);
    return $id;
  }
  public static function find($id) {
    $st = Db::get()->prepare(
     "SELECT a.*, p.name patient_name, p.dob, p.gender, d.name dept_name, b.bed_number
      FROM admission a JOIN patient p ON p.patient_id=a.patient_id
      JOIN department d ON d.department_id=a.department_id
      LEFT JOIN bed b ON b.bed_id=a.bed_id WHERE a.admission_id=?");
    $st->execute([$id]); return $st->fetch();
  }
  public static function pendingForDept($deptId) {
    $st = Db::get()->prepare(
     "SELECT a.*, p.name patient_name FROM admission a JOIN patient p ON p.patient_id=a.patient_id
      WHERE a.department_id=? AND a.status='Pending' ORDER BY a.created_at");
    $st->execute([$deptId]); return $st->fetchAll();
  }
  public static function admittedForDept($deptId) {
    $st = Db::get()->prepare(
     "SELECT a.*, p.name patient_name, b.bed_number FROM admission a
      JOIN patient p ON p.patient_id=a.patient_id LEFT JOIN bed b ON b.bed_id=a.bed_id
      WHERE a.department_id=? AND a.status='Admitted' ORDER BY b.bed_number");
    $st->execute([$deptId]); return $st->fetchAll();
  }
  public static function assignBed($admissionId, $bedId) {
    $db = Db::get();
    $db->prepare("UPDATE admission SET bed_id=?, status='Admitted', admit_date=NOW() WHERE admission_id=?")->execute([$bedId, $admissionId]);
    $db->prepare("UPDATE bed SET status='Occupied' WHERE bed_id=?")->execute([$bedId]);
    Audit::log('BED_ASSIGN', 'admission:'.$admissionId.' bed:'.$bedId);
  }
  public static function discharge($admissionId) {
    $a = self::find($admissionId);
    $db = Db::get();
    $db->prepare("UPDATE admission SET status='Discharged', discharge_date=NOW() WHERE admission_id=?")->execute([$admissionId]);
    if ($a && $a['bed_id']) $db->prepare("UPDATE bed SET status='Free' WHERE bed_id=?")->execute([$a['bed_id']]);
    Audit::log('DISCHARGE', 'admission:'.$admissionId);
  }
}
