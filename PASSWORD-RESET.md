# Forgot password & reset link

Alur menggunakan broker reset password Laravel dan tabel `password_reset_tokens` yang ada di migration project. Email reset memakai notification berbahasa Indonesia, tautan named route `password.reset` dengan token + email, masa berlaku 60 menit, satu kali pakai, dan form reset password dengan validasi konfirmasi. Permintaan dibatasi 3x/menit; reset dibatasi 10x/menit. Untuk menghindari enumerasi, form memberi pesan generik apakah email akun ditemukan.

## Konfigurasi

Pastikan `.env` memiliki URL aplikasi yang benar dan SMTP Gmail:

```dotenv
APP_URL=http://127.0.0.1:8000
MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=alamat-gmail-pengirim@gmail.com
MAIL_PASSWORD=APP_PASSWORD_GMAIL_16_KARAKTER_TANPA_SPASI
MAIL_FROM_ADDRESS=alamat-gmail-pengirim@gmail.com
MAIL_FROM_NAME="Direktori UMKM Putat Jaya"
```

Pada production, ganti `APP_URL` dengan domain HTTPS publik. Jangan gunakan URL localhost untuk email yang akan dibuka dari perangkat lain. App Password harus App Password Google (bukan kata sandi akun), gunakan akun yang sama untuk `MAIL_USERNAME` dan `MAIL_FROM_ADDRESS`.

Sesudah `.env` berubah:

```bash
php artisan config:clear
php artisan route:clear
php artisan migrate --force
```

Jalankan server kembali. Buka `/forgot-password`, masukkan email akun, lalu gunakan link terbaru di email dalam 60 menit. Jika tautan tidak terkirim, lihat `storage/logs/laravel.log`; jika tautan mengarah ke alamat salah, periksa `APP_URL` dan domain host yang dipakai aplikasi.
