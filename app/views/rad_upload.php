<h2>Upload scan &mdash; <?= e($r['barcode']) ?> &middot; <?= e($r['scan_type']) ?> <?= e($r['body_part']) ?></h2>
<p><b><?= e($r['patient_name']) ?></b> &middot; requested <?= e($r['request_datetime']) ?></p>
<form method="post" enctype="multipart/form-data" action="<?= BASE_URL ?>/index.php?page=rad_upload_save">
  <input type="hidden" name="rid" value="<?= $r['rad_request_id'] ?>">
  <label>Scan image (JPEG / PNG, max 5 MB) &mdash; saved as <?= e($r['barcode']) ?>.jpg/.png</label>
  <input type="file" name="scan" accept=".jpg,.jpeg,.png" required>
  <label><input type="checkbox" name="critical" style="width:auto"> Mark as critical finding (alerts the requesting doctor)</label>
  <button>Upload (UC-32)</button>
</form>
<p class="note">The file is stored on the server's disk; only its path goes into the database. X-ray and CT only &mdash; pilot scope.</p>
