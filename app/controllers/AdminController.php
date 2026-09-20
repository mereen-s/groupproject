<?php
class AdminController {
  public function users(){ view('admin_users', ['users'=>UserModel::all(), 'departments'=>UserModel::departments()]); }
  public function createUser(){
    UserModel::create($_POST['username'], $_POST['password'], $_POST['full_name'], $_POST['role'], $_POST['department_id']);
    flash('Account created.');
    redirect('admin_users');
  }
  public function updateUser(){
    UserModel::update($_POST['user_id'], $_POST['role'], $_POST['department_id'], $_POST['status']);
    flash('Account updated. The user must log in again.');
    redirect('admin_users');
  }
  public function audit(){ view('audit', ['rows'=>UserModel::auditLog()]); }
}
