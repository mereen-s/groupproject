<?php $f = $f ?? null; ?>
<h3>S &mdash; Subjective</h3>
<div class="row">
  <div style="flex:3"><label>Complaint / how the patient feels</label>
    <input name="complaint" value="<?= e($f['complaint'] ?? '') ?>"></div>
  <div><label>Pain 0&ndash;10</label>
    <input name="pain" type="number" min="0" max="10" value="<?= e($f['pain'] ?? '') ?>"></div>
</div>
<h3>O &mdash; Objective</h3>
<div class="row">
  <div><label>Temp &deg;C</label><input name="temp" value="<?= e($f['temp'] ?? '') ?>"></div>
  <div><label>BP</label><input name="bp" value="<?= e($f['bp'] ?? '') ?>"></div>
  <div><label>Pulse</label><input name="pulse" type="number" value="<?= e($f['pulse'] ?? '') ?>"></div>
  <div style="flex:2"><label>Examination note</label><input name="exam_note" value="<?= e($f['exam_note'] ?? '') ?>"></div>
</div>
<h3>A &mdash; Assessment</h3>
<div class="row">
  <div><label>Progress</label>
    <select name="progress">
      <option value="">&mdash;</option>
      <?php foreach (['Improving','Stable','Deteriorating'] as $o): ?>
        <option <?= (($f['progress'] ?? '')===$o)?'selected':'' ?>><?= $o ?></option>
      <?php endforeach; ?>
    </select></div>
  <div style="flex:3"><label>Diagnosis / impression</label>
    <input name="diagnosis" value="<?= e($f['diagnosis'] ?? '') ?>"></div>
</div>
<h3>P &mdash; Plan</h3>
<div class="row">
  <div><label>Medication</label>
    <select name="med_action">
      <option value="">&mdash;</option>
      <?php foreach (['Continue','Change','Stop'] as $o): ?>
        <option <?= (($f['med_action'] ?? '')===$o)?'selected':'' ?>><?= $o ?></option>
      <?php endforeach; ?>
    </select></div>
  <div style="flex:3"><label>Plan note</label>
    <input name="plan_note" value="<?= e($f['plan_note'] ?? '') ?>"></div>
</div>
