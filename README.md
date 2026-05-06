<<<<<<< HEAD
# Indirasanti Flight ✈️

Sistem pemesanan tiket penerbangan fullstack berbasis Laravel dengan sistem pembayaran transfer bank manual.

## Stack Teknologi
- **Backend**: Laravel (PHP 8.2)
- **Frontend**: Blade + Tailwind CSS
- **Database**: MySQL 8.0
- **Payment**: Manual Bank Transfer (Upload Proof of Payment)
- **Containerization**: Docker + Nginx

## Akun Default (setelah seeding)
| Role     | Email                         | Password |
|----------|-------------------------------|----------|
| Admin    | admin@indirasanti.com        | password |
| Manager  | manager@indirasanti.com      | password |
| Staff    | staff@indirasanti.com        | password |
| Customer | budi@example.com             | password |

## Setup Lokal

### 1. Clone & Install
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Konfigurasi Database (.env)
```
DB_HOST=127.0.0.1
DB_DATABASE=maskapai_penerbangan
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Konfigurasi Database (.env)
```
DB_HOST=127.0.0.1
DB_DATABASE=maskapai_penerbangan
DB_USERNAME=root
DB_PASSWORD=
FILESYSTEM_DISK=public
```

### 4. Migrate & Seed
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 5. Build Assets & Jalankan
```bash
npm run build
# atau untuk development:
npm run dev

php artisan serve
```

## Setup Docker

### 1. Salin dan atur environment
```bash
cp .env.example .env
# Edit .env sesuai kebutuhan (APP_KEY, MIDTRANS keys, dll)
```

### 2. Generate APP_KEY
```bash
# Generate dulu secara manual atau gunakan:
docker-compose run --rm app php artisan key:generate
```

### 3. Jalankan Docker
```bash
docker-compose up -d --build
```

### 4. Aplikasi akan berjalan di
- **Website**: http://localhost
- **MySQL**: localhost:3306

> Catatan: Migrasi dan seeding dijalankan otomatis saat container pertama kali berjalan via `docker-entrypoint.sh`.

## Fitur

### Halaman Publik
- 🏠 Landing page dengan carousel otomatis
- 🔍 Pencarian penerbangan (asal, tujuan, tanggal, jumlah penumpang)
- 📋 Daftar hasil pencarian penerbangan

### Customer
- 📝 Registrasi & Login
- 📊 Dashboard pemesanan
- 🎫 Pemesanan tiket multi-penumpang
- 💳 Pembayaran via Transfer Bank (BCA/BNI/BRI/Mandiri)
- 📸 Upload bukti pembayaran (Proof of Payment)
- 🧾 Riwayat & detail pemesanan

### Admin
- 📈 Dashboard statistik
- ✈️ CRUD Penerbangan
- 🏢 CRUD Maskapai
- 🗺️ CRUD Bandara
- 🛩️ CRUD Pesawat
- 📋 Manajemen Pemesanan
- 👥 Manajemen Pengguna

## Struktur Folder
```
app/
  Http/
    Controllers/
      Admin/           <- Controller admin panel
      AuthController   <- Login/Register/Logout
      BookingController <- Pemesanan & Pembayaran
      CustomerController <- Dashboard customer
      HomeController    <- Landing & Pencarian
    Middleware/
      AdminMiddleware
      StaffMiddleware
  Models/
    User, Airline, Airport, Airplane, Flight, Booking, Passenger, Payment, Seat
database/
  migrations/          <- Sesuai skema SQL yang diberikan
  seeders/             <- Data master + dummy transaksi
resources/
  views/
    layouts/           <- app.blade.php, admin.blade.php
    home, auth, flights, bookings, customer, admin/
docker/
  nginx/nginx.conf
Dockerfile
docker-compose.yml
```

## Manual Payment Flow
1. Customer memilih metode bank transfer (BCA/Mandiri/dll)
2. Sistem menampilkan nomor rekening tujuan
3. Customer melakukan transfer dan mengunggah foto bukti pembayaran
4. Status booking berubah menjadi "Menunggu Verifikasi" (pending_verification)
5. Admin/Manager mengecek bukti di dashboard
6. Admin melakukan Konfirmasi (Confirmed) atau Penolakan (Cancelled)
7. Jika Konfirmasi → Status pembayaran menjadi "Lunas" (Paid)
=======
# indirasanti-flight
>>>>>>> f2f03cf9d67d634cbf4b24d2c9eb5945942cb924
