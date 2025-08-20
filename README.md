# 🎓 Online Course Project

🌐 **Live Demo**: [online-course.ranggadwimah.xyz](https://online-course.ranggadwimah.xyz)

## 📌 Deskripsi
Proyek **Online Course** adalah aplikasi berbasis web untuk mengelola kursus online.  
Dibangun dengan **Laravel 11** dan menggunakan **Breeze** untuk sistem autentikasi yang sederhana namun powerful. Database yang digunakan adalah **MySQL**.

## ⚙️ Tech Stack
- **Backend**: [Laravel 11](https://laravel.com/)
- **Authentication**: [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze)
- **Database**: MySQL
- **Frontend**: Blade Template + TailwindCSS (default dari Breeze)

## 🚀 Fitur Utama
- Registrasi & Login menggunakan Laravel Breeze
- Manajemen pengguna
- Tampilan sederhana dengan Blade dan TailwindCSS
- Struktur siap dikembangkan untuk fitur kursus online

## 📂 Cara Instalasi 1 (tanpa docker)
1. Clone repository:
   ```bash
   git clone https://github.com/username/online-course.git
   cd online-course
2. Install Dependencies:
   ```bash
   composer install
   npm install && npm run dev
3. Salin file .env.example menjadi .env:
   ```bash
   cp .env.example .env
4. Generate key:
    ```bash
   php artisan key:generate
5. Konfigurasi database di file .env
    ```bash
   DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=online_course
    DB_USERNAME=root
    DB_PASSWORD=
6. Jalankan migrasi dan seed
    ```bash
   php artisan migrate --seed
7. Jalankan server
    ```bash
   php artisan serve

## 📂 Cara Instalasi 2 (docker)
1. Clone repository:
   ```bash
   git clone https://github.com/username/online-course.git
   cd online-course
2. Salin file .env.example menjadi .env:
   ```bash
   cp .env.example .env
3. Konfigurasi database di file .env:
    ```bash
   DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=online_course
    DB_USERNAME=root
    DB_PASSWORD=root
4. Build dan jalankan container dengan Docker Compose:
    ```bash
   docker-compose up -d --build
5. Jalankan migrasi dan seed:
    ```bash
   docker exec -it online course php artisan migrate --seed
