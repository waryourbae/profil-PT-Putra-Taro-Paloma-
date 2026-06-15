# 🏢 Landing Page Putra Taro Paloma

Website company profile resmi **PT. Putra Taro Paloma** yang menampilkan informasi perusahaan, berita terkini, dan informasi kontak.

---

## 📋 Fitur

- **Profil Perusahaan** — Menampilkan informasi lengkap tentang perusahaan, visi, misi, dan sejarah
- **Berita** — Halaman berita dan update terbaru dari perusahaan
- **Kontak** — Informasi kontak dan lokasi perusahaan

---

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel (PHP)
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, Blade Template
- **Server:** Apache (Shared Hosting)

---

## ⚙️ Cara Menjalankan di Lokal

### Prasyarat
Pastikan sudah terinstall:
- PHP >= 8.0
- Composer
- MySQL
- XAMPP / Laragon

### Langkah Instalasi

1. **Clone repository ini**
   ```bash
   git clone https://github.com/username-kamu/landing-page-putra-taro-paloma.git
   cd landing-page-putra-taro-paloma
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Salin file environment**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Setting database di file `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Import database**
   - Buka phpMyAdmin
   - Buat database baru
   - Import file SQL dari folder `/database`

7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

8. **Buka di browser**
   ```
   http://localhost:8000
   ```

---

## 📁 Struktur Project

```
├── app/
│   ├── Http/Controllers/    # Logic aplikasi
│   └── Models/              # Model database
├── database/                # File SQL / migrations
├── public/                  # Asset publik (gambar, CSS, JS)
├── resources/
│   └── views/               # Tampilan Blade template
├── routes/
│   └── web.php              # Routing aplikasi
└── .env.example             # Contoh konfigurasi environment
```

---

## 🌐 Demo

Website sudah di-deploy dan bisa diakses di:
**(https://putrataropaloma.com/))**

---

## 👤 Developer

**Nama Kamu**
- GitHub: [@waryourbae](https://github.com/waryourbae)
- Email: mhmdmunawarr@gmail.com

---

## 📄 Lisensi

Project ini dibuat untuk keperluan portofolio pribadi.
