<?php
// app/helpers/dummy-data.php
// Semua data dummy disimpan di sini (pengganti sementara database)

// ------------------- USER YANG SEDANG LOGIN -------------------
$CURRENT_USER = [
    'id'     => 1,
    'nama'   => 'Alex Jordan',
    'avatar' => BASE_URL . '/assets/img/avatars/alex.png',
    'rank'   => 3,
    'total_siswa' => 32,
    'progress' => 65, // persen
    'kelas'  => 'Advanced Calculus II',
];

// ------------------- DAFTAR TUGAS -------------------
$DUMMY_TASKS = [
    [
        'id' => 1,
        'mapel' => 'Matematika',
        'warna' => 'teal',
        'judul' => 'Kalkulus Lanjut: Integral Tentu',
        'deskripsi' => 'Selesaikan 15 soal latihan dari modul Bab 4. Pastikan langkah pengerjaan ditulis dengan rapi di kertas berpetak.',
        'deadline' => '25 Okt 2023',
        'sisa_waktu' => '2 hari lagi',
        'status' => 'belum', // belum | selesai
    ],
    [
        'id' => 2,
        'mapel' => 'Fisika',
        'warna' => 'cyan',
        'judul' => 'Laporan Praktikum: Optik Geometris',
        'deskripsi' => 'Analisis data hasil percobaan pembiasan cahaya pada lensa cembung. Lampirkan foto setup praktikum.',
        'deadline' => '30 Okt 2023',
        'sisa_waktu' => 'Minggu depan',
        'status' => 'belum',
    ],
    [
        'id' => 3,
        'mapel' => 'Bahasa Inggris',
        'warna' => 'gray',
        'judul' => 'Essay: Modern Education',
        'deskripsi' => 'Menulis esai argumentatif sepanjang 500 kata mengenai dampak kecerdasan buatan di ruang kelas.',
        'deadline' => 'Selesai pada: 20 Okt 2023',
        'sisa_waktu' => null,
        'status' => 'selesai',
    ],
];

// ------------------- PENGUMUMAN -------------------
$DUMMY_ANNOUNCEMENTS = [
    [
        'id' => 1,
        'penulis' => 'Ibu Siti Aminah',
        'mapel' => 'Fisika',
        'waktu' => '2 jam yang lalu',
        'judul' => 'Persiapan Ujian Praktikum Optik',
        'isi' => 'Anak-anak, jangan lupa besok membawa jas lab dan modul praktikum bab 4. Kita akan melakukan pengamatan lensa cembung di Lab Fisika Lantai 2 pukul 08.00 WIB. Harap datang tepat waktu!',
        'tag' => ['URGENT', 'PRAKTIKUM'],
        'warna' => 'cyan',
    ],
    [
        'id' => 2,
        'penulis' => 'Bapak Andi Wijaya',
        'mapel' => 'Matematika',
        'waktu' => 'Kemarin',
        'judul' => 'Tugas Kalkulus Integral di Google Classroom',
        'isi' => 'Materi dan latihan soal untuk Integral Substitusi sudah saya upload. Silakan dikerjakan dan dikumpulkan paling lambat hari Jumat depan ya. Selamat belajar!',
        'tag' => ['TUGAS'],
        'warna' => 'yellow',
    ],
];

// ------------------- JADWAL PELAJARAN -------------------
$DUMMY_SCHEDULE = [
    '07:30' => ['Upacara', 'Kimia', 'Biologi', 'B. Inggris', 'Olahraga'],
    '09:00' => ['Fisika', 'Kimia', 'Biologi', 'B. Inggris', 'Olahraga'],
    '10:30' => 'ISTIRAHAT',
    '11:00' => ['Matematika', 'B. Indonesia', 'Agama', 'Seni Budaya', 'Sejarah'],
];
$DUMMY_DAYS = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

// ------------------- TEMAN SEKELAS -------------------
$DUMMY_CLASSMATES = [
    ['nama' => 'Adelia Putri', 'absen' => '01', 'jabatan' => 'Siswa', 'online' => true],
    ['nama' => 'Bima Sakti',   'absen' => '02', 'jabatan' => 'Ketua Kelas', 'online' => true],
    ['nama' => 'Citra Kirana', 'absen' => '03', 'jabatan' => 'Siswa', 'online' => true],
    ['nama' => 'Dimas Wahyu',  'absen' => '04', 'jabatan' => 'Siswa', 'online' => true],
    ['nama' => 'Eka Lestari',  'absen' => '05', 'jabatan' => 'Siswa', 'online' => false],
];

$DUMMY_CLASS_INFO = [
    'nama_kelas' => 'Ruang Kelas 12-IPA-1',
    'total_siswa' => 32,
];
