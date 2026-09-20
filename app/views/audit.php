<h2>Audit log (read-only, UC-43)</h2>
<table><tr><th>Time</th><th>User</th><th>Action</th><th>Record</th></tr>
<?php foreach ($rows as $r): ?>
<tr><td><?= e($r['created_at']) ?></td><td><?= e($r['username'] ?? 'system') ?></td>
    <td><?= strpos($r['action'],'ALERT')===0 ? '<span class="critical">'.e($r['action']).'</span>' : e($r['action']) ?></td>
    <td><?= e($r['entity_ref']) ?></td></tr>
<?php endforeach; ?></table>
<p class="note">There is deliberately no edit or delete &mdash; every sensitive action is attributed: who, what, when.</p>
