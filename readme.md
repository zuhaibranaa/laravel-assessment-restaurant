# 🚀 Laravel + Vue (Inertia.js) Application Setup Guide

This guide explains how to set up the project locally, including installing dependencies, setting permissions, and running the development server.

---

## 🏗️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Vue 3 (Inertia.js + SSR)
- **Database**: MySQL
- **Styling**: Tailwind CSS
- **Auth**: Laravel Breeze (Inertia)

---


---

## ⚙️ Local Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/zuhaibranaa/laravel-assessment-restaurant.git
```
```bash
cd laravel-assessment-restaurant
```
### 2. Install Dependencies

```bash
composer install
npm install
```
### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```
### 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```
### 5. Link Storage for Uploaded Files

```bash
php artisan storage:link
```
### 6. Run Vite Dev Server

```bash
npm run dev
```
### 7. Run Laravel Server

```bash
php artisan serve
```


## Super Admin Login Creds
- ```Email``` => ```superadmin@example.com```
- ```Password``` => ```password```

