# Serasne Web-Based Order Application

Aplikasi pemesanan cafe berbasis Laravel. Aplikasi menyediakan dashboard admin, pengelolaan menu dan meja, transaksi, serta QR code untuk membuka menu customer pada meja tertentu.

## Fitur

- Login berbasis role.
- Admin mengelola produk, kategori, user, meja, dan transaksi.
- Cashier mengelola produk dan kategori, serta melihat meja dan transaksi.
- QR code meja menuju menu customer.
- Keranjang, pemesanan, bill, dan penutupan bill.
- SQLite untuk development lokal.

## Kebutuhan

- PHP 8.2 atau lebih baru.
- Composer.
- Node.js dan npm.
- SQLite.

Di macOS dengan Homebrew:

```bash
brew install php composer node
```

## Instalasi

Clone repository lalu masuk ke folder proyek:

```bash
git clone https://github.com/rafliprasaka/serasne-web-based-order-application.git
cd serasne-web-based-order-application
```

Pasang dependency PHP dan JavaScript:

```bash
composer install
npm install
```

Siapkan environment dan database SQLite:

```bash
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
```

Pastikan konfigurasi database di `.env` menggunakan SQLite:

```env
DB_CONNECTION=sqlite
SESSION_DRIVER=database
```

Jalankan migration dan data demo:

```bash
php artisan migrate --seed
```

## Menjalankan Aplikasi

Terminal pertama, jalankan Laravel:

```bash
php artisan serve
```

Buka [http://127.0.0.1:8000](http://127.0.0.1:8000).

Terminal kedua, jalankan Vite untuk asset frontend:

```bash
npm run dev
```

Untuk mengakses aplikasi dari HP yang berada di Wi-Fi yang sama:

```bash
php artisan serve --host=0.0.0.0
```

Gunakan alamat IP komputer, contohnya `http://192.168.1.10:8000`.

## Credentials Demo

### Admin

- Email: `test@example.com`
- Password: `password`

### Cashier

- Email: `cashier@example.com`
- Password: `cashier`

Seeder juga membuat tiga meja demo: `Table 1`, `Table 2`, dan `Table 3`.

## Role dan Akses

| Role | Akses |
| --- | --- |
| Admin | Dashboard, products, categories, users, tables, transactions, dan QR code |
| Cashier | Dashboard, products, categories, tables, transactions, dan QR code |
| User | Dashboard, tables, transactions, dan QR code |

Cashier tidak dapat mengakses menu Users. Pengelolaan tambah, edit, dan hapus meja tersedia melalui menu admin.

## QR Code Meja

1. Login sebagai admin atau cashier.
2. Buka menu **Table**.
3. Klik **Generate QR** pada meja yang dipilih.
4. Simpan atau cetak QR code.

QR code mengarah ke route `/menu/{table}`. Saat digunakan dari HP, QR harus berisi alamat IP komputer yang dapat diakses pada jaringan yang sama, bukan `localhost` atau `127.0.0.1`.

Halaman QR menggunakan ukuran cetak 8 x 12 cm. Matikan opsi **Headers and footers** pada dialog print agar URL browser dan nomor halaman tidak ikut tercetak.

## Perintah Berguna

```bash
php artisan migrate --seed
php artisan route:list
php artisan test
npm run build
```

Database lokal `database/database.sqlite`, file `.env`, `vendor`, dan `node_modules` tidak disimpan ke repository.
