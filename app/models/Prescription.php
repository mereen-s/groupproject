<?php
class Prescription {
  public static function create($pid, $doctorId, $drug, $dose, $freq, $dur) {
    $st = Db::get()->prepare("INSERT INTO prescription(patient_id,doctor_id,drug,dose,frequency,duration) VALUES (?,?,?,?,?,?)");
    $st->execute([$pid, $doctorId, $drug, $dose, $freq, $dur]);
    Audit::log('PRESCRIBE', 'patient:'.$pid.' '.$drug);
  }
  public static function pending() {
    return Db::get()->query(
     "SELECT pr.*, p.name patient_name, u.full_name doctor_name FROM prescription pr
      JOIN patient p ON p.patient_id=pr.patient_id JOIN user u ON u.user_id=pr.doctor_id
      WHERE pr.status='Pending' ORDER BY pr.prescribed_at")->fetchAll();
  }
  public static function dispense($id, $pharmacistId, $qty) {
    $st = Db::get()->prepare(
     "UPDATE prescription SET status='Dispensed', dispensed_by=?, dispensed_at=NOW(), quantity=? WHERE prescription_id=?");
    $st->execute([$pharmacistId, $qty, $id]);
    Audit::log('DISPENSE', 'prescription:'.$id);
  }
  public static function forPatient($pid) {
    $st = Db::get()->prepare(
     "SELECT pr.*, u.full_name doctor_name FROM prescription pr JOIN user u ON u.user_id=pr.doctor_id
      WHERE pr.patient_id=? ORDER BY pr.prescribed_at DESC");
    $st->execute([$pid]); return $st->fetchAll();
  }
}
