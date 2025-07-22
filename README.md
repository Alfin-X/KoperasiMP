# PPS Betako Merpati Putih Cabang Jember - Management System

Sistem manajemen web untuk organisasi PPS Betako Merpati Putih Cabang Jember yang dibangun dengan Laravel 12.

## 🚀 Fitur Utama

### 👥 Manajemen Pengguna & Organisasi
- **3 Role Pengguna**: Admin, Pelatih, Anggota
- Manajemen data anggota dan pelatih
- Sistem autentikasi dan otorisasi
- Profile management untuk setiap role

### 📅 Jadwal & Absensi
- Penjadwalan latihan dan kegiatan
- Sistem absensi digital
- Tracking kehadiran anggota
- Dashboard monitoring untuk pelatih

### 💰 SPP (Iuran Keanggotaan)
- Sistem billing SPP otomatis
- Tracking pembayaran
- Laporan keuangan SPP
- Notifikasi tunggakan

### 🏦 Koperasi Simpan Pinjam
- **Jenis Simpanan**:
  - Simpanan Pokok
  - Simpanan Wajib  
  - Simpanan Sukarela
- Sistem approval transaksi
- Upload bukti transfer
- Dashboard saldo dan riwayat

### 🛒 E-commerce Peralatan
- Katalog peralatan beladiri
- Sistem pemesanan online
- Manajemen inventory
- Tracking pesanan

## 🛠️ Teknologi

- **Framework**: Laravel 12
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Auth
- **File Storage**: Laravel Storage

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (untuk asset compilation)

## 🚀 Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/Alfin-X/KoperasiMP.git
cd KoperasiMP
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mp_jember
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Database Migration & Seeding**
```bash
php artisan migrate
php artisan db:seed
```

6. **Storage Link**
```bash
php artisan storage:link
```

7. **Start Development Server**
```bash
php artisan serve
```

## 👤 Default Login

### Admin
- **Email**: admin@test.com
- **Password**: password

### Pelatih
- **Email**: pelatih@test.com
- **Password**: password

### Anggota
- **Email**: anggota@test.com
- **Password**: password

## 📱 Struktur Role & Akses

### 🔴 Admin
- Dashboard overview sistem
- Manajemen pengguna (CRUD)
- Manajemen kolat/tingkatan
- Manajemen jadwal latihan
- Monitoring SPP dan koperasi
- Approval transaksi koperasi
- Manajemen e-commerce

### 🟡 Pelatih
- Dashboard monitoring anggota
- Input dan monitoring absensi
- Verifikasi transaksi koperasi
- Manajemen data anggota

### 🟢 Anggota
- Dashboard personal
- Lihat jadwal latihan
- Absensi mandiri
- Manajemen simpanan koperasi
- Pembayaran SPP
- Belanja peralatan
- Profile management

## 🗂️ Struktur Database

### Tabel Utama
- `users` - Data pengguna sistem
- `roles` - Role/peran pengguna
- `kolats` - Tingkatan/sabuk
- `schedules` - Jadwal latihan
- `attendances` - Data absensi
- `spp_bills` - Tagihan SPP
- `spp_payments` - Pembayaran SPP
- `savings` - Saldo simpanan
- `savings_transactions` - Transaksi simpanan
- `products` - Produk e-commerce
- `orders` - Pesanan
- `order_items` - Detail pesanan

## 🔧 Development

### Menjalankan Tests
```bash
php artisan test
```

### Asset Compilation
```bash
npm run dev          # Development
npm run build        # Production
```

## 📞 Support

Untuk pertanyaan atau dukungan teknis, silakan hubungi tim development atau buat issue di repository ini.

## 📄 License

Project ini dibuat khusus untuk PPS Betako Merpati Putih Cabang Jember.
