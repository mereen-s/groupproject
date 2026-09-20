<?php
class Patient {
  public static function create($d) {
    $db = Db::get();
    $row = $db->query("SELECT MAX(CAST(SUBSTRING(patient_id,2) AS UNSIGNED)) m FROM patient")->fetch();
    $id = 'P'.str_pad(($row['m'] ?? 0) + 1, 5, '0', STR_PAD_LEFT);
    $st = $db->prepare("INSERT INTO patient(patient_id,name,nic,dob,gender,contact) VALUES (?,?,?,?,?,?)");
    $st->execute([$id, $d['name'], $d['nic'], $d['dob'] ?: null, $d['gender'], $d['contact']]);
    Audit::log('PATIENT_REGISTER', $id);
    return $id;
  }
  public static function find($id) {
    $st = Db::get()->prepare("SELECT * FROM patient WHERE patient_id=?");
    $st->execute([$id]); return $st->fetch();
  }
  public static function search($q) {
    $st = Db::get()->prepare(
      "SELECT * FROM patient WHERE patient_id LIKE ? OR name LIKE ? OR nic LIKE ? ORDER BY name LIMIT 15");
    $like = '%'.$q.'%'; $st->execute([$like,$like,$like]); return $st->fetchAll();
  }
}
