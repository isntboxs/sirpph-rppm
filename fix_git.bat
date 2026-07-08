@echo off
set GIT="C:\Program Files\Git\cmd\git.exe"

REM Configure git
%GIT% config core.longpaths true

REM Reset history back to before our mess, keeping all files in working directory
%GIT% reset 89ba5db

REM COMMIT 1: Hapus file lama di Github (Fitur RPPH dll)
%GIT% rm --cached "app/Http/Controllers/AnalisisAspekController.php" "app/Http/Controllers/DataSiswaController.php" "app/Http/Controllers/KumpulanKegiatanController.php" "app/Http/Controllers/MasterBentukAlatController.php" "app/Http/Controllers/PortofolioSiswaController.php" "app/Http/Controllers/ProsemController.php" "app/Http/Controllers/ValidasiKegiatanController.php" "app/Http/Controllers/ValidasiProsemController.php" "app/Http/Controllers/OrtuPortoController.php" "app/Http/Controllers/OrtuRpphController.php" "app/Http/Controllers/OrtuRppmController.php" "app/Http/Controllers/RpphController.php" "app/Http/Controllers/ValidasiRpphController.php" 2>nul
%GIT% rm --cached "app/Models/AlatBahan.php" "app/Models/AspekPerkembangan.php" "app/Models/BentukKegiatan.php" "app/Models/Kegiatan.php" "app/Models/KomentarPortofolio.php" "app/Models/Portofolio.php" "app/Models/Prosem.php" "app/Models/RppmKegiatan.php" "app/Models/Rpph.php" "app/Models/RpphPenilaian.php" "app/Models/RpphPenilaianPoin.php" 2>nul
%GIT% rm -r --cached "database/migrations/2026_04_28_153631_create_rpph_table.php" "database/migrations/2026_05_12_074199_create_rpph_penilaian_table.php" "database/migrations/2026_05_12_074200_create_rpph_penilaian_poin_table.php" "database/migrations/2026_05_12_130522_add_kelas_id_rpph.php" "database/migrations/2026_05_12_131426_add_sub_sub_tema_to_rpph_table.php" 2>nul
%GIT% rm -r --cached "resources/views/pages/ortu_porto" "resources/views/pages/ortu_rpph" "resources/views/pages/ortu_rppm" "resources/views/pages/validasi_rpph" "resources/views/pages/rpph" 2>nul
%GIT% commit -m "chore: hapus fitur rpph dan portofolio lawas"

REM COMMIT 2
%GIT% add "app/Http/Controllers/LaporanRppController.php" "app/Http/Controllers/ValidasiDataController.php" "app/Http/Controllers/ValidasiLaporanController.php" "app/Http/Controllers/ValidasiTemaController.php" "app/Http/Controllers/ValidasiRppmController.php" "app/Http/Controllers/RppmController.php" "app/Models/LaporanRpp.php" "app/Models/LaporanRppFoto.php" "app/Models/Rppm.php"
%GIT% add "database/migrations/2026_07_02_035335_add_status_to_tema_and_rppm_tables.php" "database/migrations/2026_07_02_120000_add_revisi2_columns.php" "database/migrations/2026_07_06_092728_drop_legacy_tables.php"
%GIT% add "resources/views/pages/laporan_rpp" "resources/views/pages/validasi_data" "resources/views/pages/validasi_laporan" "resources/views/pages/validasi_rpp" "resources/views/pages/validasi_tema" "resources/views/pages/rppm/form.blade.php" "resources/views/pages/validasi_rppm" "resources/views/pages/rppm/show.blade.php" "resources/views/pages/rppm/index.blade.php"
%GIT% commit -m "feat: sistem validasi data rppm, tema, dan laporan"

REM COMMIT 3
%GIT% add "database/migrations/2026_07_06_023341_add_minggu_ke_to_sub_tema_table.php" "database/migrations/2026_07_06_035740_add_tahun_ajaran_id_to_tema_table.php"
%GIT% add "app/Http/Controllers/TahunAjaranController.php" "app/Models/SubTema.php" "app/Models/Tema.php" "app/Http/Controllers/KelolaTemaController.php" "resources/views/pages/kelola_tema"
%GIT% commit -m "feat: manajemen struktur data tahun ajaran dan sub tema"

REM COMMIT 4
%GIT% add "database/migrations/2026_07_07_022331_create_roles_table.php" "app/Models/Role.php"
%GIT% add "app/Http/Controllers/KelolaPenggunaController.php" "app/Http/Middleware/RoleMiddleware.php" "app/Models/User.php" "resources/views/pages/kelola_pengguna"
%GIT% add "database/migrations/2026_04_14_000001_create_users_table.php" "database/migrations/2026_04_14_000003_create_siswa_table.php" "database/seeders/DatabaseSeeder.php"
%GIT% commit -m "feat: database role pengguna dan perbaikan kelola admin"

REM COMMIT 5
%GIT% add "public/webpush-sw.js" "config/webpush.php" "app/Notifications/BaseNotification.php" "app/Notifications/GeneralNotification.php" "app/Http/Controllers/NotificationController.php"
%GIT% commit -m "feat: integrasi web push notification"

REM COMMIT 6
%GIT% add "app/Http/Controllers/CetakController.php" "resources/views/pages/rppm/pdf.blade.php" "public/logo_final.jpg" "public/logo_baru.png" "public/logo_baru.jpeg"
%GIT% commit -m "fix: perbaikan layout cetak pdf digital dan logo"

REM COMMIT 7 (Sisa semua file, keculai node_modules, php.ini dll)
%GIT% add .
%GIT% reset php.ini frontend do_commits.ps1 fix_git.bat
%GIT% commit -m "ui: update receh tampilan css dan layout web"

REM FORCE PUSH
%GIT% push --force-with-lease origin development/mvc
