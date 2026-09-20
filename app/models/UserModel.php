<?php
class UserModel {
  public static function all() {
    return Db::get()->query(
     "SELECT u.*, d.name dept_name FROM user u LEFT JOIN department d ON d.department_id=u.department_id ORDER BY u.username")->fetchAll();
  }
  public static function create($username, $password, $fullName, $role, $deptId) {
    $st = Db::get()->prepare("INSERT INTO user(username,password_hash,full_name,role,department_id) VALUES (?,?,?,?,?)");
    $st->execute([$username, password_hash($password, PASSWORD_DEFAULT), $fullName, $role, $deptId ?: null]);
    Audit::log('USER_CREATE', $username);
  }
  public static function update($id, $role, $deptId, $status) {
    $st = Db::get()->prepare("UPDATE user SET role=?, department_id=?, status=? WHERE user_id=?");
    $st->execute([$role, $deptId ?: null, $status, $id]);
    Audit::log('USER_UPDATE', 'user:'.$id);
  }
  public static function departments() {
    return Db::get()->query("SELECT * FROM department ORDER BY department_id")->fetchAll();
  }
  public static function auditLog() {
    return Db::get()->query(
     "SELECT a.*, u.username FROM audit_log a LEFT JOIN user u ON u.user_id=a.user_id ORDER BY a.created_at DESC LIMIT 200")->fetchAll();
  }
}
