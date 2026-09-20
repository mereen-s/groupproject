<h2>Daily Progress Note &mdash; <?= e($a['patient_id']) ?> &middot; <?= e($a['patient_name']) ?> &middot; Bed <?= e($a['bed_number']) ?></h2>
<?php if ($prev && !$f): ?>
  <a class="btn secondary" href="<?= BASE_URL ?>/index.php?page=ward_note&aid=<?= $a['admission_id'] ?>&copy=1">Load yesterday's note</a>
  <span class="note">One tap pre-fills all four sections &mdash; edit only what changed.</span>
<?php endif; ?>
<form method="post" action="<?= BASE_URL ?>/index.php?page=ward_note_save">
  <input type="hidden" name="admission_id" value="<?= $a['admission_id'] ?>">
  <input type="hidden" name="patient_id" value="<?= e($a['patient_id']) ?>">
  <?php include __DIR__.'/_soap_fields.php'; ?>
  <button>Save today's note (UC-18)</button>
  <a class="btn secondary" href="<?= BASE_URL ?>/index.php?page=history&pid=<?= e($a['patient_id']) ?>">Open record (prescribe / request tests)</a>
</form>
<form method="post" action="<?= BASE_URL ?>/index.php?page=discharge" onsubmit="return confirm('Discharge this patient?')">
  <input type="hidden" name="aid" value="<?= $a['admission_id'] ?>">
  <button>Discharge &mdash; create summary (UC-20)</button>
</form>
<p class="note">The full BHT (all daily notes, medications and results) stays in the system; the discharge summary is the patient's copy.</p>
