# Online Exam and Student Management System

**Created By:** Norliyana Aisyah

---

## 📌 Project Overview
A web-based system built using Laravel that allows lecturers to create exams and students to attempt them with time limits and role-based access control.

---

## 🛠️ Tech Stack
- Laravel 11
- MySQL Database
- Blade Templates
- Tailwind CSS
- JavaScript (Vanilla + SweetAlert)
- Spatie Laravel Permission

---

## ⚙️ Installation Guide

### 1. Clone Repository
```bash
git clone https://github.com/norliyana-dev/oesm.git
cd oesm
```

---

### 2. Setup Environment
```bash
cp .env.example .env
```

---

### 3. Configure `.env`
```env
APP_NAME=OESM
APP_ENV=local
APP_KEY=your_key
APP_DEBUG=true
APP_TIMEZONE=Asia/Kuala_Lumpur
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 4. Install Dependencies
```bash
composer install
npm install
```

---

### 5. Run Setup
```bash
php artisan key:generate
php artisan migrate --seed
```

---

### 6. Run Project
```bash
npm run dev
php artisan serve
```