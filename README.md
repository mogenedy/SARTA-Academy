# 🎓 SARTA Academy

**SARTA Academy** is a scalable Laravel-based educational platform built with clean architecture principles. It’s designed to be both a learning project and a solid foundation for real-world applications.

---

## 📌 Project Overview

- 🧑‍💻 User management and authentication  
- 🛡️ Role-based access control (Admin / User)  
- 🧾 Admin dashboard with essential tools  
- ⚙️ RESTful API support for integrations  
- 🎨 Blade-powered frontend UI  

---

## 🚀 Features

✅ Built-in authentication system  
✅ Distinct roles: Admin & User  
✅ Blade templating engine for UI  
✅ Middleware-based route protection  
✅ RESTful API support  
✅ Modern Laravel 10 structure  

---

## 🛠️ Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/mogenedy/SARTA-Academy.git
cd SARTA-Academy
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install && npm run dev
```

### 3️⃣ Configure Environment

```bash
cp .env.example .env
```

Then update your `.env` file with database, mail, and other environment credentials.

### 4️⃣ Generate App Key & Run Migrations

```bash
php artisan key:generate
php artisan migrate
```

### 5️⃣ Serve the Application

```bash
php artisan serve
```

🌐 Now open your browser at:  
[http://localhost:8000](http://localhost:8000)

---

## 🔐 Authentication & Access Control

- Built-in Laravel login & register pages  
- Middleware-protected routes  
- Role-based restrictions (Admin vs. User)  

---

## 📡 API Endpoints

> All API routes are prefixed with `/api`

### 🔑 Auth Endpoints

| Method | Endpoint         | Description       |
|--------|------------------|-------------------|
| POST   | /api/login       | Login a user      |
| POST   | /api/register    | Register a user   |
| POST   | /api/logout      | Logout the user   |

### 👥 User Endpoints

| Method | Endpoint              | Description           |
|--------|-----------------------|-----------------------|
| GET    | /api/users            | Get all users (admin) |
| GET    | /api/users/{id}       | Get a specific user   |
| PUT    | /api/users/{id}       | Update user (admin)   |
| DELETE | /api/users/{id}       | Delete user (admin)   |

### 📚 Course Endpoints *(Planned)*

| Method | Endpoint              | Description               |
|--------|-----------------------|---------------------------|
| GET    | /api/courses          | List all courses          |
| POST   | /api/courses          | Create a new course (admin) |
| PUT    | /api/courses/{id}     | Update a course (admin)   |
| DELETE | /api/courses/{id}     | Delete a course (admin)   |

---

## 📂 Folder Structure Highlights

- `app/Http/Controllers` – Web & API controllers  
- `routes/web.php` – UI routes  
- `routes/api.php` – API routes  
- `resources/views` – Blade templates  
- `database/migrations` – Database schema files