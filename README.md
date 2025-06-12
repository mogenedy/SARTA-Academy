# 🎓 SARTA Academy – Laravel Learning Platform

A Laravel-based web application for managing an academy system, including user authentication, admin dashboard, and course or student management features.

---

## 📌 Project Overview

SARTA Academy is a modular and scalable Laravel application designed to handle educational operations like managing users, roles, and possibly academic resources (e.g., courses or content). Built with Laravel 10 and includes a RESTful API and front-end views via Blade.

---

## 🚀 Features

- 👤 User Authentication & Roles (Admin / User)
- 🛡️ Role-based Access Control via Middleware
- 🧑‍💼 Admin Dashboard (e.g., users, content, reports)
- 📄 Blade Templating for UI
- 🔌 RESTful API Endpoints for integration
- 📦 Clean Laravel 10 architecture

---

## 🛠️ Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/mogenedy/SARTA-Academy.git
cd SARTA-Academy

2. Install Dependencies

composer install
npm install && npm run dev

3. Environment Configuration

cp .env.example .env

Then open .env and set your database and mail credentials.

4. Generate Key & Run Migrations

php artisan key:generate
php artisan migrate

5. Run the Server

php artisan serve

Access it via http://localhost:8000


---

🔐 Authentication

Built-in Laravel Auth (php artisan make:auth)

Middleware for protecting admin routes

Login / Register pages

Role-based access (e.g., Admin vs. User)



---

📡 API Endpoints (Basic)

> ⚠️ All API routes are typically prefixed with /api



🔑 Auth

Method	Endpoint	Description

POST	/api/login	Login user
POST	/api/register	Register user
POST	/api/logout	Logout authenticated


👥 Users

Method	Endpoint	Description

GET	/api/users	Get list of users (admin)
GET	/api/users/{id}	Get single user profile
PUT	/api/users/{id}	Update user info (admin)
DELETE	/api/users/{id}	Delete user (admin)


📚 (Optional Future) Courses / Content

Method	Endpoint	Description

GET	/api/courses	List all courses
POST	/api/courses	Create new course (admin)
PUT	/api/courses/{id}	Update course (admin)
DELETE	/api/courses/{id}	Delete course (admin)
