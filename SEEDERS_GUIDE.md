# Database Seeders Guide

This guide explains the example seeders included with the ecommerce_3rajo application for testing and demonstration purposes.

## Overview

The application includes 5 example seeders that populate your database with realistic sample data:

- **UserSeeder** — Creates 1 admin + 3 customer users
- **ProductSeeder** — Creates 10 sample tech products
- **OrderSeeder** — Creates 15 orders with items, statuses, and customers
- **PreorderSeeder** — Creates 10 sample preorders
- **PemasukanSeeder** — Creates 30 income records (various sources)
- **PengeluaranSeeder** — Creates 25 expense records (various categories)

## Running Seeders

### Run All Seeders (Recommended)

```bash
php artisan db:seed
```

This runs the `DatabaseSeeder` which calls all seeders in the correct order.

### Run Individual Seeders

```bash
# Run only users
php artisan db:seed --class=UserSeeder

# Run only products
php artisan db:seed --class=ProductSeeder

# Run only orders
php artisan db:seed --class=OrderSeeder
```

### Fresh Migration + Seeding (Clean Database)

```bash
php artisan migrate:fresh --seed
```

⚠️ **Warning**: This deletes all data and recreates tables. Use only for development!

## Sample Data Details

### Users (UserSeeder)

| Name | Email | Password | Role |
|------|-------|----------|------|
| Admin User | admin@example.com | password123 | admin |
| John Doe | john@example.com | password123 | customer |
| Jane Smith | jane@example.com | password123 | customer |
| Bob Johnson | bob@example.com | password123 | customer |

**Note**: All passwords are `password123` for easy testing.

### Products (ProductSeeder)

10 tech products with realistic pricing:

- **Wireless Headphones** — $149.99 (45 in stock)
- **USB-C Charging Cable** — $12.99 (200 in stock)
- **4K Webcam** — $89.99 (32 in stock)
- **Mechanical Keyboard RGB** — $129.99 (28 in stock)
- **Portable SSD 1TB** — $119.99 (15 in stock)
- **Laptop Stand** — $39.99 (85 in stock)
- **Wireless Mouse** — $24.99 (120 in stock)
- **USB Hub 7-Port** — $34.99 (OUT OF STOCK)
- **Monitor Stand Riser** — $49.99 (55 in stock)
- **Desk Lamp LED** — $44.99 (42 in stock)

Each product includes:
- SKU (PROD-001 format)
- Slug (for URLs)
- Description
- Price + Cost Price (for margin calculations)
- Stock quantity
- Weight
- Status (active/out_of_stock)

### Orders (OrderSeeder)

15 orders created with:
- Random customers
- Random order statuses (pending, paid, processing, shipped, completed, cancelled)
- 1-5 items per order
- Random payment methods
- Created over the last 60 days
- Automatic total amount calculation
- Sample shipping/billing addresses

**Example Order Data**:
```
Order #: ORD-ABCD1234
Customer: John Doe
Status: completed
Total: $287.45
Items: 3
```

### Preorders (PreorderSeeder)

10 preorders with:
- Random customers and products
- Quantity 1-10
- Expected ship date 7-60 days from now
- Status tracking (open, confirmed, shipped)

### Income Records (PemasukanSeeder)

30 income records spread over the last 90 days:
- **Sources**: product_sales, service_fee, subscription, refund_reversal
- **Amount**: $50-$500
- **Recorded by**: Admin user
- Used for monthly/yearly reporting

### Expense Records (PengeluaranSeeder)

25 expense records spread over the last 90 days:
- **Categories**: supplier, shipping, marketing, utilities, rent, salaries, other
- **Amount**: $100-$1,000
- **Recorded by**: Admin user
- Used for financial reporting

## Testing the Dashboard

After seeding, log in as admin and visit:

```
http://localhost:8000/admin/dashboard
```

**Credentials**:
- Email: `admin@example.com`
- Password: `password123`

You should see:
- Total Products: 10
- Total Orders: 15
- Pending Orders: ~2-3 (varies by random status)
- Total Revenue: Sum of all completed orders

## Testing Reports

The sample data enables testing of reporting endpoints:

```bash
# Monthly income/expense
curl http://localhost:8000/admin/reports/monthly

# Yearly income/expense
curl http://localhost:8000/admin/reports/yearly

# Top products by revenue
curl http://localhost:8000/admin/reports/top-products
```

## Notes

- All created_at timestamps are randomized to spread data over the last 30-90 days
- Order items include "price snapshots" (the price at the time of order)
- Products include cost prices for profit margin analysis
- Seeder dependencies are managed automatically (must run UserSeeder before others)
- Seeders include validation to check for prerequisite data

## Resetting Data

To remove all sample data and start fresh:

```bash
# Option 1: Rollback and re-migrate
php artisan migrate:rollback
php artisan migrate

# Option 2: Fresh migration (cleaner)
php artisan migrate:fresh
```

## Production Notes

⚠️ **Important**: Never run seeders in production. Seeders are for development/testing only.

To prevent accidental seeding in production:
1. Use environment-specific commands
2. Add data validation in seeders
3. Always back up your database before running migrations
4. Test migrations in a staging environment first
