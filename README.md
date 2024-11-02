# E-SIGNATURE - Proyek Tanda Tangan Digital PDF

E-SIGNATURE adalah aplikasi web yang digunakan pengguna untuk menambahkan tanda tangan digital pada dokumen PDF secara langsung. Aplikasi ini dirancang untuk memberikan pengalaman pengguna yang mudah dan efisien dengan fitur upload file menggunakan AJAX, notifikasi dengan SweetAlert, preview file sebelum upload, serta indikator loading untuk memudahkan interaksi pengguna.

## Fitur Utama

- **Penempatan Tanda Tangan Otomatis**: Menambahkan tanda tangan digital pada PDF dengan posisi yang telah ditentukan.
- **Upload PDF dengan AJAX**: Mengunggah file PDF tanpa reload halaman, mempermudah proses upload dan meningkatkan UX.
- **Notifikasi SweetAlert**: Menampilkan notifikasi sukses/gagal dengan SweetAlert untuk memberikan feedback kepada pengguna.
- **Preview File**: Menampilkan nama dan ukuran file yang dipilih sebelum diunggah.
- **Indikator Loading**: Menambahkan loading indicator pada tombol upload selama proses berlangsung.

## Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal di komputer Anda.

### Prasyarat

- [Composer](https://getcomposer.org/) - Manajer ketergantungan PHP
- [Node.js](https://nodejs.org/) & [npm](https://www.npmjs.com/) - Untuk manajemen package frontend
- PHP >= 8.3
- Laravel >= 11
- Database (MySQL, PostgreSQL, dll.)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/arya114/pspdfkit-app.git
   cd pspdfkit-app
   ```

2. **Instalasi Dependensi Backend**
   ```bash
   composer install
   ```

3. **Instalasi Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Buat File `.env`**
   Salin file `.env.example` menjadi `.env` dan perbarui konfigurasi database serta pengaturan lainnya.

   ```bash
   cp .env.example .env
   ```

5. **Generate Key Aplikasi**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database**
   Pastikan database Anda sudah berjalan, lalu jalankan migrasi untuk membuat tabel yang dibutuhkan.
   ```bash
   php artisan migrate
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

Aplikasi akan berjalan di `http://localhost:8000`. Anda dapat mengaksesnya di browser.

## Cara Penggunaan

1. Buka aplikasi di browser dan navigasikan ke halaman upload PDF.
2. Pilih file PDF yang ingin Anda tandatangani.
3. File akan diunggah dengan AJAX, dan Anda akan menerima notifikasi sukses atau gagal setelah proses selesai.
4. Jika berhasil, Anda dapat melihat preview file yang dipilih beserta detail ukuran file.
5. Setelah dokumen ditandatangani, unduh dokumen PDF yang telah selesai.

## Struktur Folder

- `app/` - Folder berisi logika backend (controller, model).
- `resources/views/` - Template Blade untuk tampilan frontend.
- `public/js/` - JavaScript kustom, termasuk integrasi AJAX dan SweetAlert.
- `public/css/` - CSS kustom untuk styling aplikasi.
- `routes/web.php` - Definisi rute utama untuk aplikasi ini.

## Kontribusi

Kami menyambut kontribusi dari siapa pun! Jika Anda ingin berkontribusi:

1. Fork repository ini.
2. Buat branch fitur baru (`git checkout -b fitur-baru`).
3. Commit perubahan Anda (`git commit -am 'Tambah fitur baru'`).
4. Push ke branch (`git push origin fitur-baru`).
5. Buat pull request baru.

## Kontak

Jika Anda memiliki pertanyaan atau masukan terkait proyek ini, silakan hubungi:
- **Nama Pengembang**: arya114
- **Email**: [alraqkiananda@gmail.com](mailto:alraqkiananda@gmail.com)
- **GitHub**: [https://github.com/arya114](https://github.com/arya114)
