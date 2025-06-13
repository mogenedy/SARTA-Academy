## 📌 Project Overview

SARTA Academy is a scalable Laravel-based platform tailored for educational environments. It includes:

- 🧑‍💻 User management and authentication  
- 🛡️ Role-based access (Admin / User)  
- 🧾 Admin dashboard with essential tools  
- ⚙️ RESTful API support  
- 🎨 Blade-powered user interface  

Built with clean architecture principles, ideal for both learning and extending into real-world use.

---

## 🚀 Features

✅ **Authentication System**  
✅ **Admin / User Role Distinction**  
✅ **Blade Templating Engine**  
✅ **Middleware for Access Control**  
✅ **RESTful API for Integration**  
✅ **Modern Laravel 10 Structure**

---

## 🛠️ Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/mogenedy/SARTA-Academy.git
cd SARTA-Academy
2️⃣ Install Dependencies
bash
Copy
Edit
composer install
npm install && npm run dev
3️⃣ Configure Environment
bash
Copy
Edit
cp .env.example .env
Then, update .env with your database, mail, and other environment credentials.

4️⃣ Generate App Key & Run Migrations
bash
Copy
Edit
php artisan key:generate
php artisan migrate
5️⃣ Serve the Application
bash
Copy
Edit
php artisan serve
🌐 Now open your browser at: http://localhost:8000

🔐 Authentication
Includes Laravel's built-in auth scaffolding.

🧑‍🔒 Login & Register pages

🛡️ Middleware-protected routes

🔐 Role-based route restrictions (Admin vs User)

📡 API Endpoints
🔗 All API routes are prefixed with /api

🔑 Auth Endpoints
Method	Endpoint	Description
POST	/api/login	Login a user
POST	/api/register	Register a user
POST	/api/logout	Logout the user

👥 User Endpoints
Method	Endpoint	Description
GET	/api/users	Get all users (admin)
GET	/api/users/{id}	Get a specific user
PUT	/api/users/{id}	Update user (admin)
DELETE	/api/users/{id}	Delete user (admin)

📚 Course Endpoints (Planned)
Method	Endpoint	Description
GET	/api/courses	List all courses
POST	/api/courses	Create new course (admin)
PUT	/api/courses/{id}	Update course (admin)
DELETE	/api/courses/{id}	Delete course (admin)

📂 Folder Structure Highlights
app/Http/Controllers – Web & API controllers

routes/web.php – Routes for UI

routes/api.php – Routes for API

resources/views – Blade templates

database/migrations – Database schema
