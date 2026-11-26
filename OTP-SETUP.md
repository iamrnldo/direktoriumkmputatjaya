# Verifikasi akun UMKM dengan OTP email

Alur baru: setelah registrasi akun berstatus `pending` dan tidak dapat login. Sistem mengirim OTP 6 digit ke email; kode berlaku 10 menit. Setelah kode benar, email ditandai terverifikasi, akun menjadi aktif (`account_status=approved`), lalu pemilik UMKM bisa login. Kode di database hanya disimpan sebagai hash; endpoint verifikasi dan kirim ulang memiliki rate limit.

## Setup di server

1. Pastikan file migration terbaru ada di server. Jalankan dari folder Laravel:

   ```bash
   php artisan migrate --force
   php artisan config:clear
   ```

   Migration baru adalah `2026_11_24_000002_add_email_otp_fields_to_users_table.php`. Migration `000001` juga perlu sudah dijalankan karena membuat `account_status`.

2. Atur `.env` untuk SMTP Gmail (gunakan Google App Password, bukan password login Gmail biasa):

   ```dotenv
   MAIL_MAILER=smtp
   MAIL_SCHEME=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=alamat-gmail-anda@gmail.com
   MAIL_PASSWORD=APP_PASSWORD_16_KARAKTER
   MAIL_FROM_ADDRESS=alamat-gmail-anda@gmail.com
   MAIL_FROM_NAME="Direktori UMKM Putat Jaya"
   ```

   Buat App Password di pengaturan Google Account dengan 2-Step Verification aktif. Simpan rahasia hanya di `.env` server.

3. Bersihkan cache config dan reload aplikasi:

   ```bash
   php artisan config:clear
   php artisan route:clear
   ```

   Untuk tes email: `php artisan tinker`, lalu `Mail::raw('Tes OTP', fn ($m) => $m->to('email-penerima@example.com')->subject('Tes'));`.

Halaman verifikasi: `/verify-email-otp`. Setelah daftar, pengguna diarahkan ke halaman tersebut. Pengguna dapat mengirim ulang kode (dibatasi 3 kali per menit) dan mencoba OTP (dibatasi 10 permintaan per menit). OTP hanya berlaku sekali selama 10 menit.

Catatan: verifikasi OTP mengaktifkan **akun/login**. Proses verifikasi profil usaha oleh admin untuk menampilkan UMKM di direktori tetap menjadi alur terpisah.
