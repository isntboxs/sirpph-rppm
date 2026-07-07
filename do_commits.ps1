$git = "C:\Program Files\Git\cmd\git.exe"

# COMMIT 1: Hapus semua file yang statusnya 'deleted'
& $git ls-files --deleted | % { & $git rm --cached $_ }
& $git commit -m "chore: hapus fitur rpph dan portofolio lawas"

# COMMIT 2
& $git add app/Http/Controllers/LaporanRppController.php app/Http/Controllers/ValidasiDataController.php app/Http/Controllers/ValidasiLaporanController.php app/Http/Controllers/ValidasiTemaController.php app/Http/Controllers/ValidasiRppmController.php app/Http/Controllers/RppmController.php
& $git add app/Models/LaporanRpp.php app/Models/LaporanRppFoto.php app/Models/Rppm.php
& $git add database/migrations/2026_07_02_035335_add_status_to_tema_and_rppm_tables.php database/migrations/2026_07_02_120000_add_revisi2_columns.php database/migrations/2026_07_06_092728_drop_legacy_tables.php
& $git add resources/views/pages/laporan_rpp resources/views/pages/validasi_data resources/views/pages/validasi_laporan resources/views/pages/validasi_rpp resources/views/pages/validasi_tema resources/views/pages/rppm/form.blade.php resources/views/pages/validasi_rppm resources/views/pages/rppm/show.blade.php resources/views/pages/rppm/index.blade.php
& $git commit -m "feat: sistem validasi data rppm, tema, dan laporan"

# COMMIT 3
& $git add database/migrations/2026_07_06_023341_add_minggu_ke_to_sub_tema_table.php database/migrations/2026_07_06_035740_add_tahun_ajaran_id_to_tema_table.php
& $git add app/Http/Controllers/TahunAjaranController.php app/Models/SubTema.php app/Models/Tema.php app/Http/Controllers/KelolaTemaController.php resources/views/pages/kelola_tema
& $git commit -m "feat: manajemen struktur data tahun ajaran dan sub tema"

# COMMIT 4
& $git add database/migrations/2026_07_07_022331_create_roles_table.php app/Models/Role.php
& $git add app/Http/Controllers/KelolaPenggunaController.php app/Http/Middleware/RoleMiddleware.php app/Models/User.php resources/views/pages/kelola_pengguna
& $git add database/migrations/2026_04_14_000001_create_users_table.php database/migrations/2026_04_14_000003_create_siswa_table.php database/seeders/DatabaseSeeder.php
& $git commit -m "feat: database role pengguna dan perbaikan kelola admin"

# COMMIT 5
& $git add public/webpush-sw.js config/webpush.php app/Notifications/BaseNotification.php app/Notifications/GeneralNotification.php app/Http/Controllers/NotificationController.php
& $git commit -m "feat: integrasi web push notification"

# COMMIT 6
& $git add app/Http/Controllers/CetakController.php resources/views/pages/rppm/pdf.blade.php public/logo_final.jpg public/logo_baru.png public/logo_baru.jpeg
& $git commit -m "fix: perbaikan layout cetak pdf digital dan logo"

# COMMIT 7 (Sisa semua file)
& $git add .
& $git reset php.ini frontend/ do_commits.ps1
& $git commit -m "ui: update receh tampilan css dan layout web"

# PUSH
& $git push -u origin development/mvc
