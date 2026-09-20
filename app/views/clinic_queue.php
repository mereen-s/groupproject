<h2>Clinic referrals &mdash; your department</h2>
<table><tr><th>Referred</th><th>Patient</th><th>OPD diagnosis</th><th></th></tr>
<?php foreach ($referrals as $r): ?>
<tr><td><?= e($r['created_at']) ?></td><td><b><?= e($r['patient_id']) ?></b> <?= e($r['patient_name']) ?></td>
    <td><?= e($r['diagnosis']) ?></td>
    <td><a class="btn secondary" href="<?= BASE_URL ?>/index.php?page=clinic_form&pid=<?= e($r['patient_id']) ?>">Open visit</a></td></tr>
<?php endforeach; ?></table>
<p class="note">Or search any patient from the dashboard and open their record.</p>
