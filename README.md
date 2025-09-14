# Starter Aplikasi CodeIgniter 4

## Deskripsi

Ini adalah starter project untuk aplikasi web menggunakan [CodeIgniter 4](https://codeigniter.com/), sebuah framework PHP yang ringan, cepat, fleksibel, dan aman. Cocok untuk membangun aplikasi CRUD, website, maupun API.

## Instalasi

1. **Clone repository ini**  
   Jalankan perintah berikut di terminal:
   ```sh
   git clone <url-repo-anda>
   cd CI4+Crud
   ```

2. **Install dependency dengan Composer**  
   Pastikan Composer sudah terinstall, lalu jalankan:
   ```sh
   composer install
   ```

3. **Konfigurasi environment**  
   Salin file `env` menjadi `.env`:
   ```sh
   cp env .env
   ```
   Edit file `.env` sesuai kebutuhan, terutama bagian `baseURL` dan pengaturan database.

4. **Konfigurasi web server**  
   Pastikan web server (Apache/Nginx) diarahkan ke folder `public/` sebagai root.

## Cara Menggunakan

- Jalankan aplikasi di localhost dengan web server (XAMPP/Laragon/dll) yang mengarah ke folder `public/`.
- Untuk development, bisa juga menggunakan built-in server:
  ```sh
  php spark serve
  ```
  Akses aplikasi di [http://localhost:8080](http://localhost:8080).

## Fitur yang Tersedia

- **CRUD Mahasiswa**  
  - Tambah, edit, hapus, dan lihat data mahasiswa.
  - Pencarian data mahasiswa.
  - Validasi input (NIM, nama, jenis kelamin).
- **Struktur MVC**  
  - Model, View, Controller terpisah sesuai standar CodeIgniter.
- **Keamanan**  
  - Proteksi CSRF pada form.
  - Validasi data.
- **Konfigurasi Mudah**  
  - Pengaturan database, session, dan lain-lain melalui file konfigurasi di `app/Config/`.
- **Testing**  
  - Dukungan unit test dengan PHPUnit (lihat folder `tests/`).

## Struktur Folder Utama

- `app/` : Kode aplikasi (Controller, Model, View, Config)
- `public/` : Web root (index.php, asset publik)
- `writable/` : Folder untuk cache, logs, upload, dll
- `tests/` : Unit test
- `vendor/` : Dependency dari Composer

## Dokumentasi

- [Panduan CodeIgniter 4](https://codeigniter.com/user_guide/)
- [Forum Diskusi](https://forum.codeigniter.com/)

---

**Lisensi:** MIT License  