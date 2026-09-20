<?php // Demo data. Run ONCE after install.php: http://localhost/ccwlcs/seed_demo.php then DELETE.
require 'config/config.php'; require 'config/database.php';
$db = Db::get();
if ($db->query("SELECT COUNT(*) c FROM patient WHERE patient_id='P00002'")->fetch()['c'] > 0) die('Demo data already seeded.');
$uid = fn($u) => "(SELECT user_id FROM user WHERE username='$u')";
$bed = fn($d,$n) => "(SELECT bed_id FROM bed WHERE department_id=$d AND bed_number=$n)";
$db->exec("
INSERT INTO patient(patient_id,name,nic,dob,gender,contact,registered_date) VALUES
('P00002','K. Fernando','885623410V','1988-06-02','M','0713456789', NOW() - INTERVAL 4 DAY),
('P00003','S. Jayawardena','926784521V','1992-11-19','F','0779812345', NOW() - INTERVAL 3 DAY),
('P00004','M. Silva','790234567V','1979-01-27','M','0765554321', NOW() - INTERVAL 1 DAY),
('P00005','T. Wickramasinghe','200156702341','2001-08-14','F','0723456780', NOW()),
('P00006','R. Perera','680912345V','1968-04-30','M','0741237890', NOW()),
('P00007','N. Gunasekara','955671234V','1995-09-08','F','0709871234', NOW());

INSERT INTO admission(patient_id,department_id,bed_id,status,diagnosis,admit_date,created_at) VALUES
('P00002',1,{$bed(1,3)},'Admitted','Acute appendicitis - post appendectomy', NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY),
('P00005',2,NULL,'Pending','Community-acquired pneumonia', NULL, NOW());
UPDATE bed SET status='Occupied' WHERE bed_id={$bed(1,3)};

INSERT INTO encounter(patient_id,doctor_id,type,complaint,pain,temp,bp,pulse,exam_note,progress,diagnosis,med_action,plan_note,pathway,referral_department_id,created_at) VALUES
('P00002',{$uid('opd1')},'OPD','Severe right lower abdominal pain',8,38.2,'130/85',96,'Rebound tenderness RIF',NULL,'Acute appendicitis',NULL,'Admit for surgery','Admit',1, NOW() - INTERVAL 4 DAY),
('P00003',{$uid('opd1')},'OPD','Recurring epigastric burning',4,36.9,'120/80',78,'Epigastric tenderness',NULL,'Chronic gastritis',NULL,'Refer to Medicine clinic','Refer',2, NOW() - INTERVAL 1 DAY),
('P00004',{$uid('opd1')},'OPD','Productive cough for one week',2,37.4,'125/82',84,'Coarse crackles left base','Stable','Acute bronchitis','Continue','Antibiotics and review if worse','Treat',NULL, NOW() - INTERVAL 3 HOUR);

INSERT INTO encounter(patient_id,doctor_id,type,complaint,pain,temp,bp,pulse,exam_note,progress,diagnosis,med_action,plan_note,follow_up_date,created_at) VALUES
('P00003',{$uid('clinic_med')},'CLINIC','Symptoms improving on treatment',2,36.8,'118/78',74,'Soft abdomen, mild tenderness','Improving','Chronic gastritis - responding','Continue','Continue PPI, review in two weeks', DATE_ADD(CURDATE(), INTERVAL 14 DAY), NOW() - INTERVAL 5 HOUR);

INSERT INTO encounter(patient_id,doctor_id,type,complaint,pain,temp,bp,pulse,exam_note,progress,diagnosis,med_action,plan_note,admission_id,note_date,created_at) VALUES
('P00002',{$uid('ward_sur')},'WARD','Pain controlled, passed flatus',5,37.8,'128/84',92,'Wound clean, mild erythema','Stable','Day 1 post-appendectomy','Continue','IV antibiotics, monitor wound',1, CURDATE() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),
('P00002',{$uid('ward_sur')},'WARD','Slept well, tolerating fluids',3,37.2,'124/80',84,'Wound clean and dry','Improving','Day 2 post-appendectomy','Continue','Start soft diet, mobilise',1, CURDATE() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),
('P00002',{$uid('ward_sur')},'WARD','No pain at rest, walking',1,36.9,'120/78',76,'Wound healing well','Improving','Day 3 post-appendectomy','Continue','Plan discharge tomorrow with oral antibiotics',1, CURDATE() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY);

INSERT INTO medication_admin(admission_id,nurse_id,drug_dose,route,admin_time) VALUES
(1,{$uid('nurse_sur')},'Cefuroxime 750 mg','IV', NOW() - INTERVAL 3 DAY),
(1,{$uid('nurse_sur')},'Cefuroxime 750 mg','IV', NOW() - INTERVAL 2 DAY),
(1,{$uid('nurse_sur')},'Paracetamol 1 g','oral', NOW() - INTERVAL 1 DAY);

INSERT INTO lab_request(patient_id,doctor_id,test_code,request_no,barcode,status,request_datetime) VALUES
('P00002',{$uid('ward_sur')},'42',1,'P00002-42-001','Completed', NOW() - INTERVAL 3 DAY),
('P00003',{$uid('clinic_med')},'41',1,'P00003-41-001','Processing', NOW() - INTERVAL 6 HOUR),
('P00004',{$uid('opd1')},'44',1,'P00004-44-001','Requested', NOW() - INTERVAL 2 HOUR);

INSERT INTO lab_result(request_id,specimen,finding,entered_by,entry_time,accept_status,critical_flag) VALUES
(1,'Blood','Growth of E. coli after 48 hours - resistant profile, urgent clinical attention advised',{$uid('lab1')}, NOW() - INTERVAL 2 DAY,'Accepted',1),
(2,'Urine','No growth after 24 hours (interim reading)',{$uid('lab1')}, NOW() - INTERVAL 1 HOUR,'Pending',0);

INSERT INTO rad_request(patient_id,doctor_id,scan_type,body_part,request_no,barcode,status,request_datetime) VALUES
('P00002',{$uid('ward_sur')},'X-ray','chest',1,'P00002-51-001','Completed', NOW() - INTERVAL 3 DAY),
('P00005',{$uid('opd1')},'CT','abdomen',1,'P00005-52-001','Requested', NOW() - INTERVAL 1 HOUR);

INSERT INTO rad_image(rad_request_id,file_path,uploaded_by,upload_time,critical_flag) VALUES
(1,'uploads/radiology/P00002-51-001.png',{$uid('rad1')}, NOW() - INTERVAL 3 DAY, 0);

INSERT INTO prescription(patient_id,doctor_id,drug,dose,frequency,duration,status,prescribed_at,dispensed_by,dispensed_at,quantity) VALUES
('P00004',{$uid('opd1')},'Amoxicillin','500 mg','3x daily','5 days','Pending', NOW() - INTERVAL 2 HOUR, NULL, NULL, NULL),
('P00002',{$uid('ward_sur')},'Omeprazole','20 mg','daily','14 days','Pending', NOW() - INTERVAL 1 DAY, NULL, NULL, NULL),
('P00003',{$uid('clinic_med')},'Metformin','500 mg','2x daily','30 days','Dispensed', NOW() - INTERVAL 2 DAY, {$uid('pharm1')}, NOW() - INTERVAL 2 DAY, '60');

INSERT INTO notification(recipient_user_id,patient_id,source,message,status,created_at) VALUES
({$uid('ward_sur')},'P00002','Lab P00002-42-001','CRITICAL lab result for K. Fernando (Blood culture (Microbiology))','Unread', NOW() - INTERVAL 2 DAY),
({$uid('opd1')},'P00003','Lab P00003-41-001','Lab result update for S. Jayawardena (Urine culture)','Viewed', NOW() - INTERVAL 1 DAY);

INSERT INTO audit_log(user_id,action,entity_ref,created_at) VALUES
({$uid('reception1')},'PATIENT_REGISTER','P00002', NOW() - INTERVAL 4 DAY),
({$uid('opd1')},'ENCOUNTER_OPD','patient:P00002', NOW() - INTERVAL 4 DAY),
({$uid('nurse_sur')},'BED_ASSIGN','admission:1 bed:3', NOW() - INTERVAL 4 DAY),
({$uid('lab1')},'LAB_RESULT_ACCEPT','labreq:1', NOW() - INTERVAL 2 DAY),
(NULL,'ALERT_SENT','to ward_sur - P00002-42-001', NOW() - INTERVAL 2 DAY),
({$uid('pharm1')},'DISPENSE','prescription:3', NOW() - INTERVAL 2 DAY);
");
echo 'Demo data seeded: 6 more patients, ward case with daily notes, lab/radiology work, prescriptions, a critical alert. <b>Delete seed_demo.php now.</b> <a href="index.php">Log in</a>';
