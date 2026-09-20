<?php
class NotificationController {
  public function index(){ view('notifications', ['items'=>Notification::forUser(Auth::id())]); }
  public function open(){
    $n = Notification::open($_GET['nid'] ?? 0, Auth::id());
    if ($n && $n['patient_id'] && in_array(Auth::role(), ['OPDDoctor','ClinicDoctor','WardDoctor'])) {
      redirect('history', '&pid='.$n['patient_id']);
    }
    redirect('notifications');
  }
}
