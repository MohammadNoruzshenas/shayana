<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <h1>Shayana Academy - Advanced Laravel LMS</h1>
</p>

<p align="center">
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License: MIT"></a>
</p>

**Shayana Academy** is a feature-rich, open-source Learning Management System (LMS) built with the **Laravel** framework. It provides a comprehensive solution for creating, selling, and managing online courses with a strong focus on content security, e-commerce features, and user engagement.

---

## 📂 Project Structure

This project utilizes a directory structure optimized for shared hosting environments, separating the application core from the public-facing files:

- **`core/`**: Contains the entire Laravel application backend, including models, controllers, business logic, and framework files.
- **`public_html/`**: Serves as the public document root. It contains assets like CSS, JS, images, and the main `index.php` entry point.

---

## ✨ Key Features

### 📚 Course & Content Management

- **Dynamic Course Management**: Create courses with various statuses (e.g., In Progress, Pre-sale, Completed, Locked).
- **Structured Content**: Organize courses into Seasons and Lessons for a clear learning path.
- **Secure Video Hosting**: Seamless integration with **SpotPlayer** for DRM-protected video content and automatic license generation per user.
- **Multiple Course Types**: Supports Free, Paid (one-time purchase), and VIP/Subscription-based access models.
- **File Management**: Robust file upload system with support for local storage, FTP, and **AWS S3** for scalable file hosting.

### 💰 E-commerce & Financials

- **Complete Sales Funnel**: Full shopping cart, order management, and checkout process.
- **Advanced Discount System**: Create and manage coupon codes and site-wide promotional discounts.
- **User Wallet**: A built-in wallet system for users to top-up and make purchases easily.
- **Installment Payments**: Functionality to sell courses through installment plans.
- **Instructor Payouts**: A dedicated system for instructors to request and track their earnings and settlements.

### 👥 User & Admin Panels

- **Student Dashboard**: Allows students to access their courses, track their progress, and manage their profile.
- **Instructor Dashboard**: Enables instructors to upload content, manage their courses, and view sales data.
- **Admin Panel**: A comprehensive backend to manage all aspects of the platform, including users, courses, sales, and system settings.

### 🛠 System & Tools

- **Support Ticket System**: A built-in ticketing module for handling user inquiries and support requests.
- **Notification System**: Integrated with SMS gateways (e.g., MeliPayamak) for sending automated notifications.
- **Activity Logging**: Tracks important user and admin actions for security and auditing purposes.
- **Weekly Schedule Planner**: A unique tool for students to build and follow a personalized study plan.

---

## 🚀 Installation Guide

Follow these steps to get the project up and running on your local machine.

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM
- Redis (Recommended)

### Steps

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/MohammadNoruzshenas/shayana.git
    cd shayana
    ```

2.  **Install PHP dependencies:**
    Navigate into the `core` directory and run Composer.

    ```bash
    cd core
    composer install
    ```

3.  **Set up the environment:**
    Create your environment file and generate the application key.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configure your `.env` file:**
    Open `core/.env` and update the following variables with your local environment details:

    ```dotenv
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=shayana_db
    DB_USERNAME=root
    DB_PASSWORD=

    # Add your SpotPlayer, AWS S3, and SMS gateway credentials
    SPOT_API_KEY=your_spotplayer_api_key
    ```

5.  **Run database migrations and seeders:**
    This will create the database schema and populate it with initial data.

    ```bash
    php artisan migrate --seed
    ```

6.  **Link storage:**
    Create the symbolic link for the public storage disk.

    ```bash
    php artisan storage:link
    ```

7.  **Serve the application:**
    Run the development server from the `core` directory.
    ```bash
    php artisan serve
    ```
    Alternatively, configure a local web server (like Nginx or Apache) and set its document root to the `public_html` directory of the project.

---

## 🤝 Contributing

Contributions are welcome! If you have a suggestion or find a bug, please:

1.  Fork the repository.
2.  Create a new feature branch (`git checkout -b feature/AmazingFeature`).
3.  Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4.  Push to the branch (`git push origin feature/AmazingFeature`).
5.  Open a Pull Request.

---

## 📄 License

This project is open-sourced software licensed under the MIT license.
