# Koshub - Sistem Informasi Manajemen Kos

**Koshub** adalah sebuah sistem informasi berbasis web yang dirancang untuk membantu pemilik kos dalam mengelola data kos, kamar, penyewa, pembayaran, dan laporan secara efisien. Aplikasi ini dilengkapi dengan berbagai fitur untuk mempermudah pengelolaan operasional kos sehari-hari.

---

## **Fitur Utama**
- **Pengelolaan Kamar**: Tambah, edit, hapus, dan lihat daftar kamar lengkap dengan informasi seperti nomor kamar, tipe, lantai, harga, kapasitas, dan status kamar.
- **Pengelolaan Penyewa**: Manajemen data penyewa yang tinggal di kos.
- **Pengelolaan Pembayaran**: Rekam pembayaran kos dari para penyewa.
- **Reservasi**: Kelola reservasi kamar secara langsung.
- **Laporan**: Buat laporan berkala untuk menganalisis data kos.

---

## **Struktur File dan Folder**
Aplikasi ini memiliki struktur file yang terorganisir sebagai berikut:

```
SIMPLE-WEB/
|-- components/
|   |-- navbar.php
|   |-- sidebar.php
|
|-- config/
|   |-- auth.php
|   |-- db.php
|   |-- logout.php
|
|-- forms/
|   |-- add_kamar.php
|   |-- add_laporan.php
|   |-- add_pembayaran.php
|   |-- add_penyewa.php
|   |-- add_reservasi.php
|   |-- edit_kamar.php
|   |-- edit_laporan.php
|   |-- edit_pembayaran.php
|   |-- edit_penyewa.php
|   |-- edit_reservasi.php
|
|-- admin.php
|-- index.php
|-- laporan.php
|-- login.php
|-- pembayaran.php
|-- penyewa.php
|-- reservasi.php
```

### Penjelasan Folder:
- **`components/`**: Berisi elemen antarmuka, seperti navbar dan sidebar.
- **`config/`**: File konfigurasi, termasuk koneksi database dan autentikasi pengguna.
- **`forms/`**: Halaman untuk menambah dan mengedit data.

---

## **Cara Instalasi**
1. **Persiapan Lingkungan:**
   - Pastikan Anda memiliki server lokal seperti XAMPP atau LAMP.
   - Install **PHP** (minimal versi 7.4), **MySQL**, dan **Composer** (opsional).

2. **Clone Repository:**
   ```bash
   git clone https://github.com/username/koshub.git
   cd koshub
   ```

3. **Konfigurasi Database:**
   - Buat database MySQL dengan nama `sewa_kos`.
   - Import file SQL yang terdapat di folder repository (jika ada).
   - Ubah file konfigurasi database di `config/db.php` sesuai dengan kredensial Anda:
     ```php
     $host = 'localhost';
     $db = 'sewa_kos';
     $user = 'root';
     $pass = 'password';
     ```

4. **Jalankan Aplikasi:**
   - Pindahkan folder proyek ke direktori server lokal Anda (contoh: `htdocs` pada XAMPP).
   - Akses aplikasi melalui browser: `http://localhost/koshub`

---

## **Demo Aplikasi**
Anda dapat mencoba aplikasi ini secara langsung melalui link berikut:

🔗 **[Koshub - Sistem Informasi Kos](https://koshub.42web.io)**

Gunakan detail login berikut:
- **Username**: `owner`
- **Password**: `password`

---

## **Akses Kode Sumber (Open Source)**
Kode sumber aplikasi ini tersedia secara open source dan dapat diakses melalui repositori GitHub:

🔗 **[GitHub Repository - Koshub](https://github.com/username/koshub)**

Kami mengundang Anda untuk mempelajari, menggunakan, atau berkontribusi pada pengembangan aplikasi ini.

---

## **Kontribusi**
Kami menyambut kontribusi dari siapa pun! Jika Anda ingin berkontribusi, ikuti langkah-langkah berikut:
1. Fork repository ini.
2. Buat branch baru untuk fitur atau perbaikan Anda.
3. Lakukan perubahan dan push ke branch Anda.
4. Kirimkan pull request ke repository utama.

---

## **Lisensi**
Aplikasi ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT). Anda bebas untuk menggunakan, memodifikasi, dan mendistribusikan kode ini sesuai ketentuan lisensi.

---

Terima kasih telah menggunakan Koshub! Jika ada pertanyaan atau masukan, jangan ragu untuk menghubungi kami melalui saluran komunikasi yang tersedia. 😊

