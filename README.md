# La Prona - Bimbel Online (PHP Native + MySQL)

## Cara Menjalankan

1. **Siapkan MySQL** (misalnya lewat XAMPP / Laragon).
2. **Import database**: buka phpMyAdmin atau terminal, lalu import file
   `database/bimbel_online.sql`. File ini otomatis membuat database
   `bimbel_online` beserta semua tabel dan data dummy.
3. **Sesuaikan koneksi** di `config/database.php` jika user/password MySQL kamu
   berbeda dari default (`root` tanpa password).
4. **Jalankan server**:
   ```
   php -S localhost:8000 -t public
   ```
5. Buka `http://localhost:8000` di browser.

## Akun Demo

| Role  | Email                | Password  |
|-------|-----------------------|-----------|
| Admin | admin@laprona.com     | admin123  |
| Admin | siti@laprona.com      | guru123   |
| User  | alex@laprona.com      | user123   |
| User  | adelia@laprona.com    | user123   |
| User  | bima@laprona.com      | user123   |

## Struktur Folder

```
bimbel-online/
├── config/
│   ├── config.php        # Konfigurasi global + session
│   └── database.php      # Koneksi PDO ke MySQL
├── database/
│   └── bimbel_online.sql # Schema + data dummy
├── app/
│   ├── helpers/
│   │   └── functions.php # isLoggedIn, requireAdmin, dsb
│   └── views/layouts/
│       ├── header.php / footer.php             # Layout untuk user
│       └── admin-header.php / admin-footer.php # Layout untuk admin (sidebar)
├── public/                # Document root
│   ├── index.php, login.php, logout.php
│   ├── dashboard.php, tasks.php, task-detail.php, task-submit.php
│   ├── schedule.php, announcements.php
│   ├── assets/css/style.css
│   └── admin/             # Semua halaman khusus admin
│       ├── dashboard.php
│       ├── users.php, user-form.php
│       ├── tasks.php, task-form.php, submissions.php
│       ├── announcements.php, announcement-form.php
│       ├── schedule.php, schedule-form.php
│       └── master.php     # Kelola kelas & mata pelajaran
└── uploads/submissions/    # File jawaban tugas siswa
```

## Role & Hak Akses

- **admin**: bisa masuk ke `/admin/*` untuk kelola user, tugas, pengumuman,
  jadwal, kelas, dan mata pelajaran. Juga tetap bisa melihat sisi user biasa.
- **user**: hanya bisa mengakses dashboard, tugas, jadwal, dan pengumuman
  sesuai kelas yang di-assign admin. Tidak bisa mengakses `/admin/*`
  (otomatis di-redirect oleh `requireAdmin()`).

## Catatan Keamanan

Password pada data dummy disimpan **plain text** demi kemudahan belajar/demo.
Untuk produksi, ganti proses simpan password dengan `password_hash()` saat
membuat user, dan `password_verify()` saat login di `public/login.php`.
