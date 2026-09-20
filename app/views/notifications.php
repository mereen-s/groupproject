<h2>Notifications &mdash; critical findings first</h2>
<?php foreach ($items as $n): ?>
<div class="card <?= $n['status']==='Unread'?'unread':'' ?>">
  <b><?= $n['status']==='Unread' ? '<span class="critical">CRITICAL</span>' : 'viewed' ?></b>
  &middot; <?= e($n['message']) ?> <span class="note">(<?= e($n['source']) ?> &middot; <?= e($n['created_at']) ?>)</span><br>
  <?php if ($n['status']==='Unread'): ?>
    <a class="btn" href="<?= BASE_URL ?>/index.php?page=notif_open&nid=<?= $n['notification_id'] ?>">Open record</a>
  <?php endif; ?>
</div>
<?php endforeach; ?>
<?php if (!$items): ?><p>No notifications.</p><?php endif; ?>
<p class="note">Alerts persist until viewed &mdash; opening one records that it was seen and jumps to the patient's record.</p>
