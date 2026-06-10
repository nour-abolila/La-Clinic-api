# 🛒 La Clinic - Laravel E-Commerce API

## 📌 Project Overview

This is a Laravel-based E-Commerce API project built with a clean and scalable architecture.  
The project focuses on RESTful API development and provides core e-commerce features such as authentication, OTP verification, product management, cart system, and password reset.

The system uses JWT authentication for secure access and includes email verification via OTP.

---

## 🚀 Features

### 🔐 Authentication System
- User registration with OTP email verification
- Login using JWT authentication
- Logout with token invalidation
- Password reset via OTP
- Resend OTP with rate limiting

---

### 🧑‍💻 User Management
- User registration with hashed passwords
- Email verification before login
- Role-based structure (ready for admin/user roles)

---

### 📦 Product Management
- Product CRUD operations
- Product fields: name, description, price, stock, rating, status
- Category-based organization
- Active scope filtering

---

### 📂 Category System
- Categories with slug generation
- Auto slug generation using Laravel Model Events
- One-to-many relationship with products

---

### 🛒 Cart System
- Add products to cart
- Increase quantity if product already exists
- Remove products from cart
- Automatic total price calculation
- Cart and cart items relationships

---

### 📧 OTP System
- Secure OTP generation for email verification
- OTP expiration handling
- Attempt limitation for security
- Resend OTP rate limiting

---

## 🏗️ Architecture

The project follows a Service-Oriented Architecture (SOA):

- Controllers → Handle HTTP requests
- Services → Business logic layer
- Models → Database layer
- Form Requests → Validation
- Resources → API response formatting

This ensures:
- Clean code structure
- Separation of concerns
- Scalability

---

## 🧰 Tech Stack

- Laravel 12+
- PHP 8+
- MySQL
- JWT Authentication
- Laravel Mail (SMTP)
- Eloquent ORM

---

## 🔐 Authentication Flow

1. User registers
2. OTP is sent to email
3. User verifies OTP
4. Account is activated
5. User logs in using JWT

---

## 📊 Database Structure

- users
- products
- categories
- carts
- cart_items
- otp_verifications

---

## ⚙️ Installation

```bash
git clone <repo-url>
cd project-folder
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
