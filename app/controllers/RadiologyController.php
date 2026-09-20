<?php
class RadiologyController {
  public function queue(){ view('rad_queue', ['requests'=>RadRequest::pending()]); }
  public function uploadForm(){
    $r = RadRequest::find($_GET['rid'] ?? 0);
    if (!$r) { flash('Request not found.'); redirect('radiology'); }
    view('rad_upload', ['r'=>$r]);
  }
  public function upload(){
    $r = RadRequest::find($_POST['rid'] ?? 0);
    if (!$r) { flash('Request not found.'); redirect('radiology'); }
    if (empty($_FILES['scan']) || $_FILES['scan']['error'] !== UPLOAD_ERR_OK) { flash('Upload failed.'); redirect('rad_upload','&rid='.$r['rad_request_id']); }
    if ($_FILES['scan']['size'] > MAX_UPLOAD_BYTES) { flash('File too large (max 5 MB).'); redirect('rad_upload','&rid='.$r['rad_request_id']); }
    $ext = strtolower(pathinfo($_FILES['scan']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png'])) { flash('Only JPEG/PNG allowed.'); redirect('rad_upload','&rid='.$r['rad_request_id']); }
    $fname = $r['barcode'].'.'.$ext;
    if (!move_uploaded_file($_FILES['scan']['tmp_name'], UPLOAD_DIR.$fname)) { flash('Could not save file.'); redirect('rad_upload','&rid='.$r['rad_request_id']); }
    RadImage::add($r['rad_request_id'], 'uploads/radiology/'.$fname, Auth::id(), isset($_POST['critical']));
    flash('Scan uploaded ('.$fname.'). File stored on disk; path saved in the database.');
    redirect('radiology');
  }
}
