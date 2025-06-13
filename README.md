🛠️ Installation & Setup
1️⃣ Clone the Repository
bash
Copy
Edit
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
Then update your .env file with database, mail, and other environment credentials.

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
🌐 Open your browser at:
http://localhost:8000

🔐 Authentication & Access Control
Built-in Laravel login & register pages

Middleware-protected routes

Role-based restrictions (Admin vs. User)

📡 API Endpoints
All API routes are prefixed with /api

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
POST	/api/courses	Create a new course (admin)
PUT	/api/courses/{id}	Update a course (admin)
DELETE	/api/courses/{id}	Delete a course (admin)

📂 Folder Structure Highlights
app/Http/Controllers – Web & API controllers

routes/web.php – UI routes

routes/api.php – API routes

resources/views – Blade templates

database/migrations – Database schema files