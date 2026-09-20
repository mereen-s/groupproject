<?php
class PatientController {
  public function registration(){ view('registration'); }
  public function register(){
    $id = Patient::create($_POST);
    flash('Patient registered. ID: '.$id);
    redirect('registration');
  }
  public function apiSearch(){
    header('Content-Type: application/json');
    echo json_encode(Patient::search($_GET['q'] ?? ''));
    exit;
  }
  public function history(){
    $p = Patient::find($_GET['pid'] ?? '');
    if (!$p) { flash('Patient not found.'); redirect('dashboard'); }
    view('history', [
      'p'=>$p,
      'encounters'=>Encounter::forPatient($p['patient_id']),
      'labs'=>LabRequest::resultsForPatient($p['patient_id']),
      'rads'=>RadRequest::imagesForPatient($p['patient_id']),
      'prescriptions'=>Prescription::forPatient($p['patient_id']),
      'tests'=>Db::get()->query("SELECT * FROM test_type")->fetchAll(),
    ]);
  }
  public function prescribe(){
    Prescription::create($_POST['pid'], Auth::id(), $_POST['drug'], $_POST['dose'], $_POST['frequency'], $_POST['duration']);
    flash('Prescription sent to dispensary.');
    redirect('history', '&pid='.$_POST['pid']);
  }
  public function requestLab(){
    $b = LabRequest::create($_POST['pid'], Auth::id(), $_POST['test_code']);
    flash('Lab test requested. Barcode: '.$b);
    redirect('history', '&pid='.$_POST['pid']);
  }
  public function requestRad(){
    $b = RadRequest::create($_POST['pid'], Auth::id(), $_POST['scan_type'], $_POST['body_part']);
    flash('Scan requested. Barcode: '.$b);
    redirect('history', '&pid='.$_POST['pid']);
  }
}
