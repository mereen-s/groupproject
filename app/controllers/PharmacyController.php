<?php
class PharmacyController {
  public function queue(){ view('pharmacy', ['prescriptions'=>Prescription::pending()]); }
  public function dispense(){
    Prescription::dispense($_POST['prescription_id'], Auth::id(), $_POST['quantity']);
    flash('Dispensed and recorded.');
    redirect('pharmacy');
  }
}
