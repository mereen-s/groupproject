<?php
class Audit {
  public static function log($action, $ref='') {
    $uid = $_SESSION['user']['id'] ?? null;
    $st = Db::get()->prepare("INSERT INTO audit_log(user_id, action, entity_ref) VALUES (?,?,?)");
    $st->execute([$uid, $action, $ref]);
  }
}
