<?php $u = Auth::user(); ?>
<h2>Welcome, <?= e($u['name']) ?></h2>
<p class="note"><?= e($u['role']) ?><?= $u['dept'] ? ' &middot; department-isolated view' : '' ?> &middot; <?= date('l, d F Y') ?></p>

<?php if ($stats): ?>
<div class="stat-grid">
  <?php foreach ($stats as $lbl=>$num): ?>
    <div class="stat <?= (stripos($lbl,'alert')!==false && $num>0) ? 'alert' : '' ?>">
      <div class="num"><?= (int)$num ?></div>
      <div class="lbl"><?= e($lbl) ?></div>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (in_array($u['role'], ['OPDDoctor','ClinicDoctor','WardDoctor','Receptionist'])): ?>
  <h3>Find a patient</h3>
  <input id="dsearch" placeholder="Type name / NIC / patient ID...">
  <div id="dresults"></div>
  <script>document.addEventListener('DOMContentLoaded', function(){
    attachPatientSearch('dsearch','dresults','<?= $u['role']==='Receptionist' ? 'registration' : 'history' ?>');
  });</script>
<?php endif; ?>

<h3>Your module</h3>
<div class="module-links">
<?php
$links = [
 'Receptionist'=>['registration'=>'Patient registration & search'],
 'OPDDoctor'=>['notifications'=>'Notifications'],
 'ClinicDoctor'=>['clinic'=>'Clinic referral queue','notifications'=>'Notifications'],
 'WardDoctor'=>['ward'=>'My ward - daily notes & discharge','notifications'=>'Notifications'],
 'WardNurse'=>['nurse'=>'Admissions, beds & medication'],
 'LabPersonnel'=>['lab'=>'Laboratory request queue'],
 'RadiologyPersonnel'=>['radiology'=>'Radiology request queue'],
 'Pharmacist'=>['pharmacy'=>'Pending prescriptions'],
 'Administrator'=>['admin_users'=>'User accounts','audit'=>'Audit log'],
];
foreach (($links[$u['role']] ?? []) as $pg=>$label) echo '<a class="btn" href="'.BASE_URL.'/index.php?page='.$pg.'">'.e($label).'</a> ';
if ($u['role']==='OPDDoctor') echo '<p class="note" style="width:100%">Search a patient above, open their record, then start a new OPD consultation.</p>';
?>
</div>
