# Online Learning Platform (Laravel)

An Online Learning Platform built with Laravel that supports multi-role users (Admin, Teacher, Student) and provides a complete course management and learning experience.

This project was developed as part of my hands-on training and academic learning to demonstrate real-world Laravel application development using MVC architecture.

---

## Features

### Authentication & Roles
- User authentication (Login, Register, Email Verification)
- Role-based access control:
  - Admin
  - Teacher
  - Student

### Admin
- Manage departments and courses
- Manage teachers and students
- View reports and system notifications
- Monitor payments

### Teacher
- Create and manage courses
- Upload assignments
- Grade student submissions
- View enrolled students
- Receive notifications

### Student
- Browse and enroll in courses
- View course details
- Submit assignments
- View grades and feedback
- Make payments
- Rate courses and leave comments
- Receive notifications

### Additional Features
- Assignment submission system
- Course rating and comments
- Notification system
- Payment management
- Reports module
- Profile management (update profile & password)

---

## Tech Stack

- **Backend**: Laravel
- **Frontend**: Blade, Tailwind CSS, JavaScript
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Build Tool**: Vite
- **Version Control**: Git & GitHub

---

## Project Structure (MVC)

- `app/Http/Controllers` – Application logic
- `app/Models` – Eloquent models
- `resources/views` – Blade templates
- `routes` – Web and role-based routes
- `database/migrations` – Database schema
- `database/seeders` – Sample data

---

## Installation Guide

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

### Steps

1. Clone the repository
```bash
git clone https://github.com/LonYarHao/Online-Learning-platform.git

