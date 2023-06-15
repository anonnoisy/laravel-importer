<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Mini Project

#### What's in the box?

-   User Sign In
-   User Register
-   User Profile Update
-   Excel Import
-   Use Vue 3 with Typescript
-   Use Tailwindcss
-   Use Websockets for realtime notification

#### System Requirement

-   PHP >= ^8.1
-   Node >= 16.04
-   MySQL 8.0

#### Installation

-   Clone this repository
-   Run `cp .env.example .env`
-   Create new MySQL database and adjust to `.env`
-   Run `composer install`
-   Run `php artisan key:generate`
-   Run `php artisan migrate`
-   Run `php artisan db:seed` it will be import data from `storage/app/dataset` (Optional)
-   Run `npm install`

*   Need few new terminal to run the services

-   Run `npm run dev`
-   Run `php artisan serve`
-   Run `php artisan websockets:serve`
-   Run `php artisan queue:listen` or `php artisan queue:work`

#### Query Question

-   Tampilkan hari, total transaksi, total perolehan, dimana total perolahan yang lebih dari 5 di hari itu:

` SELECT
    DATE_FORMAT(transaction_date, '%Y-%m-%d') hari,
    COUNT(id) as total_transaksi,
    SUM(total_purchase_price) AS total_perolehan
  FROM sales
  GROUP BY DATE_FORMAT(transaction_date, '%Y-%m-%d')
  HAVING COUNT(id) > 5
  ORDER BY hari DESC;`
