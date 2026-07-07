# La Prona - Bimbel Online (PHP Native + MySQL)

## Akun Demo

| Role  | Email                | Password  |
|-------|-----------------------|-----------|
| Admin | admin@laprona.com     | admin123  |
| User  | alex@laprona.com      | user123   |


## Struktur Folder

```
bimbel-online/
├── config/
│   ├── config.php        
│   └── database.php      
├── database/
│   └── bimbel_online.sql 
├── app/
│   ├── helpers/
│   │   └── functions.php 
│   └── views/layouts/
│       ├── header.php / footer.php             
│       └── admin-header.php / admin-footer.php 
├── public/                
│   ├── index.php, login.php, logout.php
│   ├── dashboard.php, tasks.php, task-detail.php, task-submit.php
│   ├── schedule.php, announcements.php
│   ├── assets/css/style.css
│   └── admin/            
│       ├── dashboard.php
│       ├── users.php, user-form.php
│       ├── tasks.php, task-form.php, submissions.php
│       ├── announcements.php, announcement-form.php
│       ├── schedule.php, schedule-form.php
│       └── master.php    
└── uploads/submissions/    
```

## Role & Hak Akses

- **admin**: bisa masuk ke `/admin/*` untuk kelola user, tugas, pengumuman,
  jadwal, kelas, dan mata pelajaran. Juga tetap bisa melihat sisi user biasa.
- **user**: hanya bisa mengakses dashboard, tugas, jadwal, dan pengumuman
  sesuai kelas yang di-assign admin. Tidak bisa mengakses `/admin/*`
  (otomatis di-redirect oleh `requireAdmin()`).

