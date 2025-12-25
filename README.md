# Laravel Blog Management System

A simple role-based blog application built with Laravel. Users can submit blogs for review, Admins can approve or reject them, and only published blogs are visible on the public frontend.

---

## Features

### User Panel
- Authentication using **Laravel Breeze**
- Create blog posts with:
  - Title
  - Content
  - Image (jpg / png / gif, max 1MB)
- View list of submitted blogs
- Track blog status:
  - Pending
  - Published
  - Rejected
- Edit or delete blogs **only when status is Pending**

### Admin Panel
- Admin authentication
- View all submitted blogs
- View full blog details
- Update blog status via **AJAX**:
  - Pending
  - Published
  - Rejected
- Published blogs are visible on the public frontend

### Public Frontend
- Home page showing all **Published** blogs
- Blog detail page (title, content, image)
- Simple UI using **Bootstrap**

---

## Tech Stack

- Laravel
- Laravel Breeze (Authentication)
- MySQL (Database)
- Bootstrap (UI)
- AJAX

---

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and npm
- MySQL >= 5.7 or MariaDB >= 10.3

---

## Project Setup

Follow the steps below to set up the project locally.

### 1. Clone the Repository

```bash
git clone https://github.com/Travel-Agent7/blog-system.git
cd blog-system
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the environment file and configure your database settings:

```bash
cp .env.example .env
```

Edit the `.env` file and update the following database configuration:

```env
DB_DATABASE=blog_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

This will create the database tables and seed default admin and user accounts.

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run dev
```

Or for production:

```bash
npm run build
```

### 8. Start the Development Server

```bash
php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

---

## Default Credentials

After running the seeders, you can use the following default credentials:

### Admin Account
- **Email:** admin@blog.com
- **Password:** password

### User Account
- **Email:** user@blog.com
- **Password:** password

---

## Usage

1. **Admin Login**: Access the admin panel to review and manage blog submissions
2. **User Login**: Users can create, edit (when pending), and delete their blog posts
3. **Public View**: Visit the home page to see all published blogs
