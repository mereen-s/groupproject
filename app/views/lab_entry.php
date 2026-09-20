<h2>Result entry &mdash; <?= e($r['barcode']) ?> &middot; <?= e($r['test_name']) ?></h2>
<p><b><?= e($r['patient_name']) ?></b> &middot; requested <?= e($r['request_datetime']) ?> &middot; status <?= e($r['status']) ?></p>
<form method="post" action="<?= BASE_URL ?>/index.php?page=lab_save">
  <input type="hidden" name="rid" value="<?= $r['request_id'] ?>">
  <div class="row">
    <div><label>Specimen</label><input name="specimen" value="<?= e($res['specimen'] ?? '') ?>"></div>
  </div>
  <label>Finding (descriptive text)</label>
  <textarea name="finding" rows="4"><?= e($res['finding'] ?? '') ?></textarea>
  <label><input type="checkbox" name="critical" style="width:auto" <?= !empty($res['critical_flag'])?'checked':'' ?>> Mark as critical finding (alerts the requesting doctor on accept)</label>
  <button>Save entry (UC-27)</button>
</form>
<?php if (!empty($res['finding']) && $res['accept_status']==='Pending'): ?>
<div class="row">
  <form method="post" action="<?= BASE_URL ?>/index.php?page=lab_accept"><input type="hidden" name="rid" value="<?= $r['request_id'] ?>"><button>Accept (UC-28)</button></form>
  <form method="post" action="<?= BASE_URL ?>/index.php?page=lab_reject"><input type="hidden" name="rid" value="<?= $r['request_id'] ?>"><button class="btn secondary" style="background:#fff;color:#1E5F75">Reject &amp; re-enter</button></form>
</div>
<?php endif; ?>
<p class="note">Nothing is committed to the patient record until Accept &mdash; the manual-entry safeguard.</p>
