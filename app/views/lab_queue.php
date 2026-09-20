<h2>Laboratory &mdash; pending requests</h2>
<table><tr><th>Barcode</th><th>Test</th><th>Patient</th><th>Requested</th><th>Status</th><th></th></tr>
<?php foreach ($requests as $r): ?>
<tr><td><b><?= e($r['barcode']) ?></b></td><td><?= e($r['test_name']) ?></td><td><?= e($r['patient_name']) ?></td>
    <td><?= e($r['request_datetime']) ?></td><td><?= e($r['status']) ?></td>
    <td><a class="btn secondary" href="<?= BASE_URL ?>/index.php?page=lab_entry&rid=<?= $r['request_id'] ?>">Enter result</a></td></tr>
<?php endforeach; ?></table>
<p class="note">Manual-entry sections only (microbiology / histopathology) &mdash; pilot scope.</p>
