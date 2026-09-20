<?php
class WardController {
  public function index(){
    view('ward_index', ['admitted'=>Admission::admittedForDept(Auth::dept())]);
  }
  public function noteForm(){
    $a = Admission::find($_GET['aid'] ?? 0);
    if (!$a || $a['department_id'] != Auth::dept()) { flash('Admission not found in your ward.'); redirect('ward'); }
    $prev = Encounter::lastWardNote($a['admission_id']);
    $prefill = (isset($_GET['copy']) && $prev) ? $prev : null;
    view('ward_note', ['a'=>$a, 'prev'=>$prev, 'f'=>$prefill]);
  }
  public function saveNote(){
    $d = $_POST; $d['doctor_id'] = Auth::id(); $d['type'] = 'WARD'; $d['note_date'] = date('Y-m-d');
    Encounter::create($d);
    flash('Daily note saved.');
    redirect('ward_note', '&aid='.$d['admission_id']);
  }
  public function discharge(){
    $aid = $_POST['aid'];
    $a = Admission::find($aid);
    if (!$a || $a['department_id'] != Auth::dept()) { flash('Not your ward.'); redirect('ward'); }
    Admission::discharge($aid);
    redirect('discharge_print', '&aid='.$aid);
  }
  public function dischargePrint(){
    $a = Admission::find($_GET['aid'] ?? 0);
    if (!$a) { flash('Admission not found.'); redirect('ward'); }
    $notes = Encounter::wardNotes($a['admission_id']);
    $meds  = MedicationAdmin::forAdmission($a['admission_id']);
    $labs  = LabRequest::resultsForPatient($a['patient_id']);
    require __DIR__.'/../views/discharge_print.php';  // standalone printable page
  }
}
