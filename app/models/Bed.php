<?php
class Bed {
  public static function forDept($deptId) {
    $st = Db::get()->prepare("SELECT * FROM bed WHERE department_id=? ORDER BY bed_number");
    $st->execute([$deptId]); return $st->fetchAll();
  }
}
