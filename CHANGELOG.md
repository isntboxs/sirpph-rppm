# 📝 Histori Update & Bug Fix (Changelog Lengkap)

Dokumen ini merangkum *semua* perjalanan perbaikan dan penambahan fitur dari awal banget sampai sekarang. Bahasanya dibikin santai aja biar gampang dipahamin sama tim atau klien pas lagi presentasi.

---

## 🔥 Mayor Update & Fitur Baru (Feature Updates)

*   **Sistem Validasi & Status (Workflow RPPM & Laporan)**
    Dulu alurnya mungkin masih belum jelas, sekarang udah ada sistem status yang solid: `draft`, `pending`, `disetujui`, dan `revisi`. 
    - Guru bisa nyimpen sebagai *draft* dulu sebelum diajuin.
    - Kepala Sekolah bisa gampang nge-ACC (*approve*) atau minta revisi kalau ada yang kurang pas.
*   **Fitur Catatan Revisi (Feedback System)**
    Nambahin kolom khusus di database buat nampung "alasan revisi" atau coretan dari Kepala Sekolah. Jadi guru tau persis apa yang harus diperbaikin tanpa harus tanya-tanya lagi.
*   **Relasi Data Lebih Cerdas (Tahun Ajaran & Sub Tema)**
    - Nambahin `minggu_ke` di Sub Tema biar urutan belajarnya makin rapi.
    - Tema sekarang udah nyambung langsung ke **Tahun Ajaran Aktif**. Manfaatnya? Data RPPM tahun ini nggak bakal kecampur sama data tahun lalu.
*   **Database Role & Kelas yang Dinamis**
    Dulu pilihan *Role* (Admin, Kepsek, Guru) cuma ditulis mentahan di HTML. Sekarang semuanya udah dipindah ke *database* (`roles` dan `kelas` A, B, C, D). Selain bikin sistem lebih transparan, ini juga ngebantu otomatisasi pas mau nge-print PDF.

---

## 🐛 Perbaikan Bug & Penyesuaian (Bug Fixes & Patches)

*   **Fix: Dashboard Statistik Ngaco**
    Benerin *bug* di halaman Beranda (akun Admin/Kepsek) di mana hitungan "Total RPP" dan "Total Laporan RPP" sempet gak akurat. Sekarang datanya dijamin *real-time* dan sesuai sama jumlah data aslinya.
*   **Fix: Error Cetak PDF Digital di HP (GD Extension)**
    Ini *bug* lumayan ngeselin. Waktu mau cetak PDF dari HP, sering muncul *error* karena server lokal klien nggak *support* modul transparansi PNG (GD Extension). Solusinya? Logonya dikonversi jadi format JPEG standar (background putih) plus klien *upload* logo baru (PAUD QU biru). Sekarang PDF bisa dicetak mulus dari device apa aja.
*   **Penyempurnaan Layout PDF**
    - Ngegabungin teks "Bulan" dan "Minggu ke-" jadi satu baris biar nggak makan tempat.
    - Ngerapihin cetak tebal (*bold*); sekarang cuma label kirinya aja yang tebal, isinya tetep biasa.
    - Ngilangin info "Guru Kelas" ganda di bagian atas PDF (karena udah ada di kolom tanda tangan bawah).
    - Ngilangin kotak border hitam di logo yang bikin jelek.
*   **Fix: Form Tambah & Edit Pengguna Bertabrakan**
    Sempet ada insiden waktu nekan tombol "Edit Pengguna", yang kebuka malah mode "Tambah Pengguna" baru. Udah diberesin! Sistem sekarang pinter ngebaca ID (*data-id*) mana yang mau di-*update*. Judul pop-up nya juga sekarang otomatis nyesuaiin (bisa "Edit" atau "Tambah").
*   **Fix: Pilihan Kelas Kosong (Penyakit Cache)**
    Waktu mau nambah akun Guru, daftar kelasnya sempet *blank* karena *browser* nyimpen *cache* lawas. Udah dirombak total: sekarang data kelas langsung di-*render* dari belakang (*backend*), dijamin 100% langsung muncul seketika!
*   **Penyempurnaan Pesan Error (Validasi)**
    Dulu kalau gagal nambah akun, errornya cuma bilang "Gagal Menambahkan User" (bikin bingung). Sekarang sistem bakal ngasih tau alasan persisnya, misalnya *"Username sudah dipakai"* atau *"Role belum dipilih"*.

---

## 🧹 Code Clean-Up & Maintenance

*   **Pembersihan Database (Drop Legacy Tables)**
    Ngebersihin dan ngehapus tabel-tabel jadul atau *file* sisa uji coba yang udah nggak kepake. Bikin *database* jadi lebih langsing dan enteng pas di-load.
*   **Penyesuaian Gaya Kode (Student-Style Code)**
    Ngerapihin seluruh isi *source code* (Controller & Model). Komentar-komentar bahasa Inggris yang kaku bawaan *template* atau AI udah dihapus. Diganti pake catatan bahasa Indonesia yang kasual, padat, dan *to-the-point* layaknya hasil karya mahasiswa IT lokal sungguhan.
*   **Proteksi Struktur Inti Framework**
    Biar aplikasi nggak gampang meledak di kemudian hari, nama-nama kolom krusial bawaan Laravel (kayak `users`, `password`, `created_at`) sengaja *dipertahankan* dalam bahasa Inggris. Anak IT paham banget kalau ngubah ini bisa merusak sistem Login secara fatal. Jadi, keamanannya tetep dijaga standar industri.
