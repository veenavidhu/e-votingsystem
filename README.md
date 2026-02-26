# E-voting System

A modern, secure, and aesthetically pleasing electronic voting application built with Laravel and Bootstrap 5.

## 🌟 Features

- **Dual-Role System**: Dedicated interfaces for Voters and Administrators.
- **Secure Voting**: Built-in protection against double-voting via user-level flags.
- **Candidate Management**: Full CRUD (Create, Read, Update, Delete) for election candidates with profile photo uploads.
- **Interactive Dashboards**: 
    - **Voter**: View candidates and cast votes with clear confirmations.
    - **Admin**: Monitor live election turnout, turnout percentages, and leading candidates.
- **Searchable Logs**: Integrated DataTables for filtering users, candidates, and voting logs.
- **Live Results Simulation**: Interactive dashboard effects that highlight live activity.
- **Login Impersonation**: Administrators can "Login As" any voter directly from the User Management table for testing or support.
- **Modern UI**: Consistent Purple/Indigo theme with `rounded-pill` design and glassmorphic icons.

## 🔐 Default Login Credentials

After seeding the database, you can use the following accounts to test the system:

### 1. Administrator
- **Email**: `admin@evoting.com`
- **Password**: `admin123`

### 2. Standard Voter
- **Email**: `remya@evoting.com`
- **Password**: `password123`

## 🎨 Visual Identity

- **Primary Gradient**: `linear-gradient(135deg, #667eea 0%, #764ba2 100%)`
- **Typography**: Poppins (via Google Fonts)
- **Icons**: Bootstrap Icons

## 🛠 Tech Stack

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Blade Templates, Bootstrap 5, jQuery
- **Database**: MySQL (MariaDB)
- **Tools**: DataTables.js, Chart.js

## 🚀 Getting Started

1. **Clone the project** to your local server directory.
2. **Environment Setup**:
   ```powershell
   copy .env.example .env
   php artisan key:generate
   ```
3. **Database Configuration**:
   Update your `.env` file with your database credentials.
4. **Run Migrations & Seeding**:
   ```powershell
   php artisan migrate --seed
   ```
5. **Storage Link**:
   ```powershell
   php artisan storage:link
   ```

## 📖 Documentation

Detailed documentation projects are available in the repository:
- **Database Schema**: See `database_explanation.md` for table relationships.
- **Administrative Workflows**: See `.agents/workflows/voting_workflow.md` for step-by-step management guides.

