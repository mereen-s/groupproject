<?php
class LabController {
  public function queue(){ view('lab_queue', ['requests'=>LabRequest::pendingAll()]); }
  public function entry(){
    $r = LabRequest::find($_GET['rid'] ?? 0);
    if (!$r) { flash('Request not found.'); redirect('lab'); }
    if ($r['status'] === 'Requested') LabRequest::setStatus($r['request_id'], 'Processing');
    view('lab_entry', ['r'=>$r, 'res'=>LabResult::ensure($r['request_id'])]);
  }
  public function saveEntry(){
    LabResult::save($_POST['rid'], $_POST['specimen'], $_POST['finding'], isset($_POST['critical']), Auth::id());
    flash('Finding entered. Accept it to commit, or reject to re-enter.');
    redirect('lab_entry', '&rid='.$_POST['rid']);
  }
  public function accept(){
    LabResult::accept($_POST['rid']);
    flash('Result accepted and stored. Critical results alert the requesting doctor.');
    redirect('lab');
  }
  public function reject(){
    LabResult::reject($_POST['rid']);
    flash('Result rejected - re-enter the finding.');
    redirect('lab_entry', '&rid='.$_POST['rid']);
  }
}
