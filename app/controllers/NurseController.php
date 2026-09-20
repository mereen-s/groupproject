<?php
class NurseController {
  public function index(){
    view('nurse', [
      'pending'=>Admission::pendingForDept(Auth::dept()),
      'beds'=>Bed::forDept(Auth::dept()),
      'admitted'=>Admission::admittedForDept(Auth::dept()),
    ]);
  }
  public function assignBed(){
    Admission::assignBed($_POST['aid'], $_POST['bed_id']);
    flash('Bed assigned. Patient admitted.');
    redirect('nurse');
  }
  public function medAdmin(){
    MedicationAdmin::add($_POST['aid'], Auth::id(), $_POST['drug_dose'], $_POST['route']);
    flash('Medication administration recorded.');
    redirect('nurse');
  }
}
