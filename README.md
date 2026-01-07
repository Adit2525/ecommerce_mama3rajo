# ecommerce_3rajo

A production-ready e-commerce application built with Laravel 11, Eloquent ORM, and MySQL. Features role-based access control, product management, order tracking, and comprehensive financial reporting.

## Features

- **Authentication & Authorization**: Role-based access (admin, customer) with custom middleware
- **Product Management**: Full CRUD for products with SKU, pricing, stock tracking
- **Order Management**: Order creation, status tracking, and order history
- **Financial Reporting**: Monthly/yearly income and expense aggregations, top products by revenue
- **CSV Import**: Bulk product import with row-level validation, preview, and transaction-based commit/rollback
- **Admin Dashboard**: Blade-based dashboard with KPI cards and Chart.js visualizations
- **Security**: CSRF/XSS protection, strong password hashing (Argon2), file upload validation, transactional operations

## Tech Stack

- **Backend**: Laravel 11, PHP 8.3+
- **Database**: MySQL 8.0+
- **Frontend (Admin)**: Blade templating + Chart.js
- **Authentication**: Laravel's built-in auth system
- **Validation**: Form Request validation (FormRequest)
- **ORM**: Eloquent

## Installation

### Prerequisites
- PHP 8.3 or higher
- Composer
- MySQL 8.0+
- Node.js (for asset compilation)

### Steps

1. **Clone the repository and install dependencies:**
   ```bash
   cd ecommerce_3rajo
   composer install
   npm install
   ```

2. **Copy environment file and generate app key:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure database:**
   Edit `.env` and set your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce_3rajo
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Install Laravel Breeze (authentication scaffolding):**
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install
   npm run build
   ```

6. **Create admin user (manually or via tinker):**
   ```bash
   php artisan tinker
   >>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@test.local','password'=>bcrypt('password'),'role'=>'admin'])
   ```

7. **Compile assets:**
   ```bash
   npm run dev
   ```

8. **Start the dev server:**
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000/admin/dashboard` (login required; admin role enforced)

## API Endpoints

### Admin Routes (Protected by `role:admin` middleware)

**Dashboard:**
- `GET /admin/dashboard` — Admin dashboard with KPI cards

**Products:**
- `GET /admin/products` — List products (paginated)
- `GET /admin/products/create` — Create product form
- `POST /admin/products` — Store product
- `GET /admin/products/{id}/edit` — Edit product form
- `PUT /admin/products/{id}` — Update product
- `DELETE /admin/products/{id}` — Delete product

**Reporting:**
- `GET /admin/reports/monthly` — Monthly income/expense (JSON)
- `GET /admin/reports/yearly` — Yearly income/expense (JSON)
- `GET /admin/reports/top-products` — Top 10 products by revenue (JSON)

**CSV Import:**
- `POST /admin/import/preview` — Preview CSV upload (validate rows, return errors and preview data)
- `POST /admin/import/commit` — Commit validated rows within a DB transaction (rollback on any error)

## Database Schema

### Tables

- **users**: Authentication, role column (admin/customer)
- **products**: Product catalog with SKU, pricing, stock
- **orders**: Customer orders with status tracking
- **order_items**: Individual line items per order (with price snapshot)
- **manage_products**: Audit log of product admin actions
- **manage_orders**: Audit log of order status changes
- **preorders**: Pre-order reservations
- **pemasukan**: Income records (from various sources)
- **pengeluaran**: Expense records (by category)

## Development

### Create a new resource controller:
```bash
php artisan make:controller Admin/ProductController --resource
php artisan make:request ProductRequest
```

### Add a new route:
Edit `routes/web.php` and add to the admin middleware group:
```php
Route::resource('products', Admin\ProductController::class);
```

### Run migrations:
```bash
php artisan migrate
```

### Rollback migrations:
```bash
php artisan migrate:rollback
```

## Testing

Unit and feature tests are in `tests/`. Run:
```bash
php artisan test
```

## Security Considerations

1. **Role-based Access**: Only users with `role = 'admin'` can access admin routes
2. **CSRF Protection**: Laravel middleware automatically protects POST/PUT/DELETE requests
3. **Password Hashing**: Uses Argon2 by default (configured in `config/hashing.php`)
4. **File Validation**: CSV and image uploads are validated by MIME type and size
5. **Transactions**: Multi-step operations (CSV import) use database transactions with rollback on error
6. **Query Protection**: Eloquent parameterized queries prevent SQL injection

## Deployment

### Production Checklist

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Set a strong `APP_KEY` (via `php artisan key:generate`)
3. Use a production database (managed MySQL service recommended)
4. Set up Redis for caching/queues (optional; currently uses sync queue)
5. Configure email driver (SMTP, SendGrid, etc.)
6. Enable HTTPS/SSL
7. Run migrations: `php artisan migrate --force`
8. Compile assets: `npm run build`
9. Set proper file permissions: `chmod -R 775 storage bootstrap/cache`
10. Use a process manager (Supervisor, systemd) to keep `php artisan serve` or a production server running

### Docker (Optional)

A Docker setup is recommended for consistent environments:

```bash
docker-compose up -d
docker-compose exec app php artisan migrate
```

(Docker files can be added if needed.)

## License

This project is proprietary. All rights reserved.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
