<?php $u = Auth::user(); $unread = $u ? Notification::unreadCount($u['id']) : 0; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>CCWLCS</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<header class="app">
  <h1>Hospital Coordination System</h1>
  <span class="spacer"></span>
  <?php if ($u): ?>
    <span><?= e($u['name']) ?> (<?= e($u['role']) ?>)</span>
    <a href="<?= BASE_URL ?>/index.php?page=notifications">&#128276;<?php if($unread): ?> <span class="badge"><?= $unread ?></span><?php endif; ?></a>
    <a class="pill" href="<?= BASE_URL ?>/index.php?page=logout">Logout</a>
  <?php endif; ?>
</header>
<?php if ($u): ?>
<nav class="menu">
  <a href="<?= BASE_URL ?>/index.php?page=dashboard">Dashboard</a>
  <?php if ($u['role']==='Receptionist'): ?><a href="<?= BASE_URL ?>/index.php?page=registration">Registration &amp; Search</a><?php endif; ?>
  <?php if ($u['role']==='ClinicDoctor'): ?><a href="<?= BASE_URL ?>/index.php?page=clinic">Clinic referrals</a><?php endif; ?>
  <?php if ($u['role']==='WardDoctor'): ?><a href="<?= BASE_URL ?>/index.php?page=ward">My ward</a><?php endif; ?>
  <?php if ($u['role']==='WardNurse'): ?><a href="<?= BASE_URL ?>/index.php?page=nurse">Admissions &amp; beds</a><?php endif; ?>
  <?php if ($u['role']==='LabPersonnel'): ?><a href="<?= BASE_URL ?>/index.php?page=lab">Lab queue</a><?php endif; ?>
  <?php if ($u['role']==='RadiologyPersonnel'): ?><a href="<?= BASE_URL ?>/index.php?page=radiology">Radiology queue</a><?php endif; ?>
  <?php if ($u['role']==='Pharmacist'): ?><a href="<?= BASE_URL ?>/index.php?page=pharmacy">Dispensary</a><?php endif; ?>
  <?php if ($u['role']==='Administrator'): ?><a href="<?= BASE_URL ?>/index.php?page=admin_users">Users</a> <a href="<?= BASE_URL ?>/index.php?page=audit">Audit log</a><?php endif; ?>
</nav>
<?php endif; ?>
<main>
<?php if ($m = flash()): ?><div class="flash"><?= e($m) ?></div><?php endif; ?>
