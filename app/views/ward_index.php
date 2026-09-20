<h2>My ward &mdash; admitted patients</h2>
<table><tr><th>Bed</th><th>Patient</th><th>Diagnosis</th><th>Admitted</th><th></th></tr>
<?php foreach ($admitted as $a): ?>
<tr><td><?= e($a['bed_number']) ?></td><td><b><?= e($a['patient_id']) ?></b> <?= e($a['patient_name']) ?></td>
    <td><?= e($a['diagnosis']) ?></td><td><?= e($a['admit_date']) ?></td>
    <td><a class="btn secondary" href="<?= BASE_URL ?>/index.php?page=ward_note&aid=<?= $a['admission_id'] ?>">Daily note</a></td></tr>
<?php endforeach; ?></table>
<p class="note">One Ward Doctor account per department, held by the IMO &mdash; the ward team records under supervision, as with the BHT.</p>
