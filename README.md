# CCWLCS — Centralized Clinic, Ward & Laboratory Coordination System (Pilot)
Plain PHP + MySQL + vanilla JS · MVC · XAMPP. No frameworks/libraries (TC-01).

## Setup (XAMPP + VS Code)
1. Copy this folder to C:\xampp\htdocs\ccwlcs
2. Open the folder in VS Code (File > Open Folder).
3. Start Apache and MySQL in XAMPP Control Panel.
4. In phpMyAdmin (http://localhost/phpmyadmin) > Import > choose sql/schema.sql (creates DB, tables, departments, beds, test codes).
5. Visit http://localhost/ccwlcs/install.php ONCE (creates all user accounts + a sample patient). Delete install.php afterwards.
6. Go to http://localhost/ccwlcs/ and log in.

## Accounts (password for all: pass123)
admin · reception1 · opd1 · clinic_sur / clinic_med / clinic_ped · ward_sur / ward_med / ward_ped (Ward Doctor = IMO)
nurse_sur / nurse_med / nurse_ped · lab1 · rad1 · pharm1

## Folder map
index.php            front controller (?page=... routing)
config/              config + PDO connection
app/core/            Auth (sessions+RBAC), Audit, helpers
app/models/          one class per table (prepared statements)
app/controllers/     one per module
app/views/           one per screen (+ layout header/footer)
assets/              css + js (AJAX patient search uses native fetch)
uploads/radiology/   scan images (file on disk, path in DB)
sql/schema.sql       database

## Demo data (optional)
After install.php, visit http://localhost/ccwlcs/seed_demo.php ONCE to load demo patients,
a ward case with daily notes, lab/radiology work, prescriptions and a critical alert.
Delete seed_demo.php afterwards. (Includes a placeholder scan image in uploads/radiology/.)
