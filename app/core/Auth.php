<?php
class Auth {
  public static function attempt($username, $password) {
    $st = Db::get()->prepare("SELECT * FROM user WHERE username=? AND status='Active'");
    $st->execute([$username]); $u = $st->fetch();
    if ($u && password_verify($password, $u['password_hash'])) {
      $_SESSION['user'] = ['id'=>$u['user_id'],'name'=>$u['full_name'],'role'=>$u['role'],'dept'=>$u['department_id']];
      Audit::log('LOGIN', 'user:'.$u['user_id']);
      return true;
    }
    return false;
  }
  public static function user(){ return $_SESSION['user'] ?? null; }
  public static function id(){ return $_SESSION['user']['id'] ?? null; }
  public static function role(){ return $_SESSION['user']['role'] ?? null; }
  public static function dept(){ return $_SESSION['user']['dept'] ?? null; }
  public static function check(){ if (!self::user()) redirect('login'); }
  public static function requireRole($roles){
    self::check();
    if (!in_array(self::role(), (array)$roles)) { http_response_code(403); die('Access denied for your role.'); }
  }
  public static function logout(){ Audit::log('LOGOUT','user:'.self::id()); session_destroy(); }
}
