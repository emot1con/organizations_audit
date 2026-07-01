# OrgAudit - Organization Audit System

[![Laravel Version](https://img.shields.io/badge/Laravel-v13.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.3-blue.svg)](https://php.net)
[![Tailwind CSS Version](https://img.shields.io/badge/Tailwind%20CSS-v4.x-38bdf8.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**OrgAudit** adalah platform manajemen organisasi kampus modern yang dirancang untuk mengelola struktur organisasi, pembagian peran (*roles & permissions*), manajemen divisi, serta pemantauan dan audit keuangan secara transparan, aman, dan terstruktur.

---

## 🚀 Fitur Utama

### 1. Autentikasi & Manajemen Pengguna
*   **Registrasi & Login**: Sistem masuk aman untuk anggota dan admin sistem.
*   **Manajemen Profil**: Pengguna dapat memperbarui informasi pribadi mereka dengan mudah.
*   **Pemulihan Kata Sandi**: Fitur *Forgot Password* untuk mereset kata sandi.

### 2. Room Organisasi & Divisi
*   **Pembuatan Room Organisasi**: Setiap organisasi dapat membuat ruang tersendiri dengan deskripsi, kategori, kontak, serta opsi kata sandi untuk bergabung.
*   **Pembagian Divisi**: Struktur organisasi dapat diturunkan menjadi divisi-divisi internal untuk koordinasi yang lebih spesifik.
*   **Gabung Organisasi/Divisi**: Anggota dapat mencari dan mengajukan diri untuk bergabung ke organisasi atau divisi tertentu.

### 3. Manajemen Hak Akses Dinamis (Roles & Permissions)
*   **Role Organisasi & Divisi**: Pengaturan peran kustom (misal: Ketua, Bendahara, Sekretaris, Anggota).
*   **Hak Akses Dinamis**: Administrator organisasi/divisi dapat mengelola izin (*permissions*) secara detail untuk setiap peran (membaca, menulis, menyetujui transaksi, dll.).

### 4. Manajemen Keuangan & Audit Transaksi
*   **Pencatatan Transaksi**: Pengajuan transaksi pemasukan atau pengeluaran dana organisasi/divisi.
*   **Bukti Transaksi**: Mendukung pengunggahan tautan atau berkas bukti transaksi untuk transparansi.
*   **Alur Persetujuan (Approval Flow)**: Transaksi memiliki status `pending`, `approved`, atau `rejected`. Bendahara atau pemilik organisasi dapat meninjau dan mengubah status tersebut.
*   **Laporan Keuangan & Cetak Transaksi**: Fitur cetak laporan transaksi dan invoice baik di tingkat organisasi maupun divisi untuk kebutuhan audit fisik.

### 5. Panel Admin Utama (System Level Admin)
*   **Manajemen Pengguna**: Admin sistem dapat mengelola, menyunting, dan menghapus akun pengguna.
*   **Manajemen Organisasi**: Admin sistem memiliki kendali penuh untuk meninjau dan menghapus organisasi yang terdaftar di dalam sistem.

---

## 🛠️ Teknologi yang Digunakan

*   **Framework Utama**: [Laravel 13](https://laravel.com)
*   **Database**: SQLite (Default), mendukung PostgreSQL dan MySQL
*   **Frontend**: Blade Templating Engine
*   **Styling**: [Tailwind CSS v4](https://tailwindcss.com) (melalui Vite integration)
*   **Reaktivitas**: [Alpine.js](https://alpinejs.dev)
*   **Pustaka Tambahan**:
    *   [ApexCharts](https://apexcharts.com/) (Visualisasi data dan grafik keuangan)
    *   [FullCalendar](https://fullcalendar.io/) (Manajemen jadwal dan agenda)
    *   [Flatpickr](https://flatpickr.js.org/) (Pemilihan tanggal)
    *   [Swiper](https://swiperjs.com/) (Slider interaktif)

---

## 📋 Persyaratan Sistem

Sebelum memulai instalasi, pastikan sistem Anda memenuhi persyaratan berikut:
*   **PHP** >= 8.3
*   **Composer** (Manajer Dependensi PHP)
*   **Node.js & NPM** (Untuk kompilasi aset frontend)
*   **SQLite** / database engine lainnya (MySQL / PostgreSQL)

---

## ⚙️ Panduan Instalasi & Konfigurasi

Ikuti langkah-langkah di bawah ini untuk memasang project di lingkungan lokal Anda:

### 1. Klon Repositori
```bash
git clone <url-repositori-anda>
cd expenses_tracker
```

### 2. Jalankan Perintah Setup
Project ini menyediakan perintah pintas *setup* yang terintegrasi di dalam `composer.json` untuk mempermudah konfigurasi awal. Perintah ini akan otomatis menginstal dependensi Composer, membuat berkas `.env`, menghasilkan *application key*, menjalankan migrasi database, menginstal dependensi NPM, dan membangun aset frontend.

Cukup jalankan:
```bash
composer setup
```

*Atau jika ingin melakukannya secara manual:*
```bash
# Instal dependensi PHP
composer install

# Salin konfigurasi environment
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Jalankan migrasi database
php artisan migrate --force

# Instal dependensi JavaScript & kompilasi aset
npm install
npm run build
```

---

## 🖥️ Menjalankan Project

Untuk menjalankan server pengembangan lokal secara efisien, jalankan perintah berikut:

```bash
composer dev
```

> [!NOTE]
> Perintah `composer dev` menggunakan package `concurrently` untuk menyalakan beberapa layanan sekaligus secara paralel:
> *   **Server Utama**: `php artisan serve` (berjalan di http://127.0.0.1:8000)
> *   **Queue Listener**: `php artisan queue:listen` (untuk antrean tugas latar belakang)
> *   **Vite Dev Server**: `npm run dev` (hot reloading untuk aset frontend & CSS)
> *   **Laravel Pail**: `php artisan pail` (untuk logging langsung di terminal)

---

## 🧪 Akun Pengujian (Seeded Users)

Untuk mempermudah proses pengujian fitur, Anda dapat menjalankan seeder database untuk mengisi data awal:

```bash
php artisan db:seed
```

Setelah menjalankan seeder, Anda dapat menggunakan akun-akun default di bawah ini untuk masuk ke aplikasi:

| Nama | Email | Kata Sandi | Peran Sistem |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `admin123` | Administrator Utama |
| **Deru** | `deru@gmail.com` | `admin123` | Pengguna Umum / Anggota |
| **Rachel** | `rachel@gmail.com` | `admin123` | Pengguna Umum / Anggota |
| **Arqan** | `arqan@gmail.com` | `admin123` | Pengguna Umum / Anggota |

---

## 🤝 Kontribusi & Lisensi

Project ini dibuat untuk memenuhi tugas kuliah pemrograman web.
Dilisensikan di bawah [MIT License](LICENSE).
