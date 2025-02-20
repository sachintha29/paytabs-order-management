# CodeIgniter 4 Order Management System

## Overview
This is a CodeIgniter 4-based Order Management System that integrates with PayTabs for payment processing. The system allows users to place orders, manage payments, and view order details.

## Features
- Product ordering with quantity selection
- PayTabs iframe payment integration
- Order and payment management
- Database relationships between orders, products, and payments

## Installation
### 1. Clone the Repository
```sh
git clone https://github.com/sachintha29/paytabs-order-management.git
cd paytabs-order-management
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Configure Environment
Copy `env` to `.env` and update database credentials:
```sh
cp env .env
```
Modify the `.env` file:
```ini
app.baseURL = 'http://localhost:8080'
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_db_user
database.default.password = your_db_password
database.default.DBDriver = MySQLi
PAYTABS_API_KEY= text-text
Please add PATTABS_API_KEY  given test credincials

```

### 4. Run Migrations
```sh
php spark migrate
```

### 5. Run Seeders
Run the `ProductSeeder` to populate the database with sample products:
```sh
php spark db:seed ProductSeeder
```

### 6. Start the Development Server
```sh
php spark serve
```

## Technologies Used
- CodeIgniter 4
- MySQL
- PayTabs API
- jQuery & AJAX



