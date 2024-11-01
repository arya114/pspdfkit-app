

# E-Signature dengan Laravel

Aplikasi ini adalah implementasi berbasis Laravel untuk mengelola, menampilkan, dan mengedit dokumen PDF menggunakan E-Signature, sebuah toolkit populer untuk menangani file PDF di aplikasi web.

## Fitur

- Menampilkan dokumen PDF
- Mengedit anotasi pada dokumen PDF
- Menambah dan menghapus halaman dalam dokumen PDF
- Menyimpan dan mengekspor dokumen PDF

## Persyaratan

- **PHP** versi 7.4 atau lebih baru
- **Composer**
- **Laravel** versi 8 atau lebih baru
- PSPDFKit API Key (dapatkan di [sini](https://pspdfkit.com/))

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan aplikasi:

1. **Clone repositori ini:**

   ```bash
   git clone https://github.com/arya114/pspdfkit-app.git
   cd pspdfkit-app
   ```

2. **Instal dependensi menggunakan Composer:**

   ```bash
   composer install
   ```

3. **Salin file `.env.example` menjadi `.env`:**

   ```bash
   cp .env.example .env
   ```

4. **Konfigurasi Kunci API PSPDFKit:**

   Tambahkan PSPDFKit API Key Anda di file `.env`:

   ```
   PSPDFKIT_API_KEY=your_pspdfkit_api_key
   ```

5. **Buat key aplikasi Laravel:**

   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database (opsional, jika menggunakan database):**

   ```bash
   php artisan migrate
   ```

7. **Jalankan server pengembangan:**

   ```bash
   php artisan serve
   ```

Aplikasi akan berjalan di `http://localhost:8000`.

## Cara Penggunaan

1. **Mengunggah Dokumen PDF**: Buka halaman utama dan pilih file PDF untuk diunggah.
2. **Menambahkan Anotasi**: Gunakan tool anotasi di aplikasi untuk menambah teks, highlight, atau bentuk ke dalam PDF.
3. **Ekspor PDF**: Setelah selesai, simpan perubahan dan ekspor dokumen dalam format PDF.

## Struktur Proyek

- **Routes**: Terletak di `routes/web.php`, menentukan alur halaman aplikasi.
- **Controllers**: Berada di `app/Http/Controllers`, mengelola logika utama aplikasi.
- **Views**: Berada di `resources/views`, menyimpan halaman antarmuka pengguna.
- **Models**: Berada di `app/Models`, mendefinisikan model database.

## Kontribusi

Kami sangat menghargai kontribusi untuk meningkatkan aplikasi ini! Jika Anda tertarik, ikuti langkah-langkah berikut:

1. Fork repositori ini
2. Buat branch untuk fitur: `git checkout -b fitur-anda`
3. Commit perubahan Anda: `git commit -m 'Menambahkan fitur baru'`
4. Push ke branch: `git push origin fitur-anda`
5. Buat Pull Request

Pastikan untuk memeriksa panduan kontribusi sebelum memulai.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Kontak

Jika Anda memiliki pertanyaan atau masalah, silakan hubungi saya melalui [Email Anda atau Tautan Kontak GitHub Anda].

---

Anda bisa menyesuaikan README ini lebih lanjut sesuai dengan kebutuhan proyek Laravel Anda!
