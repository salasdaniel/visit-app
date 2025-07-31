# 🏢 Visit App - Commercial Visits Management System

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13%2B-blue.svg)](https://postgresql.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.0-purple.svg)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Description

**Visit App** 

This is a real case implemented in a Paraguayan company dedicated to pool maintenance and selling related products. This system is designed to manage and monitor maintenance visits to their clients. The system includes user management, client management, product management, visit tracking, photo capture, check-in and check-out through QR code scanning, and automatic WhatsApp notifications.

## Main Features

### 👥 User Management
- **Differentiated roles**: Administrators and advisors
  - **Administrator (1)**: Can manage users, clients, products and monitor visits performed.
  - **Advisor (2)**: Must scan QR to check in and out, complete form data with information required by the company, and attach photographic records
- **Secure authentication**: Login system with role validation, login is based on the user's identity document as required by the company
- **Complete management**: User CRUD operations
- **Bulk import**: User loading through Excel files

### 🏢 Client Management
- **Complete database**: Detailed client information
- **Subscription plans**: Different types of commercial plans
- **Excel import**: Bulk client loading with validations
- **Advanced search**: Data filtering and sorting

### 📦 Product Management
- **Complete catalog**: Products with cost and sale prices
- **Automatic calculation**: Profit margins and profitability
- **Inventory control**: Active/inactive states
- **Bulk import**: Loading through Excel templates

### 📍 Visit System
- **QR Scanner**: Visit initiation through QR codes
- **Photo capture**: Visual documentation of visits
- **Time tracking**: Entry and exit time recording
- **Follow-up states**: Customer needs control

### 📱 WhatsApp Integration
- **Automatic notifications**: Visit report sending
- **Attached images**: Visit photos included in messages
- **Detailed summaries**: Complete visit information

### 📊 Reports
- **Administrative reports**: Products, clients, users and visits
- **Advanced filters**: By dates, users, clients, active status, sorting.

## How to Test:
- **Administrative role**: Login with document number 12345678
  - **Record creation**: From home select the section you want to manage: users, clients, products. In each section you can create, edit, deactivate and bulk load.
  - **Bulk data loading**: Find in the project root within the docs folder the examples to import clients and products, use the files ending with _copy, they already contain the data to migrate.
  - **Reports**: in all sections you'll find tables with database records.
- **Advisor role**: Login with document 87654321, optimized for mobile.
    - **QR entry/exit**: Within the /img folder located in the project root you'll find the qr.jpeg file, this is the code that must be scanned to allow advisor entry and exit.
    - **Form**: Complete the visit form, photographic records are required.
    - **WhatsApp message**: The message is sent automatically when finishing the visit, for this you must create an instance at Ultramsg.com and complete the ULTRAMSG_TOKEN, ULTRAMSG_INSTANCE data in the .env file

## Technologies Used

### Backend
- **PHP 7.4+**: Main language
- **PostgreSQL**: Main database
- **Composer**: Dependency management

### Frontend
- **Bootstrap 4.5.2**: Responsive CSS framework
- **SweetAlert2**: Elegant notifications
- **Font Awesome**: Iconography
- **jQuery**: DOM manipulation

### Main Libraries
- **PhpSpreadsheet**: Excel file handling
- **UltraMsg WhatsApp SDK**: WhatsApp integration
- **vlucas/phpdotenv**: Environment variable management

## 📁 Project Structure

```
visit-app/
├── 📂 css/                    # Custom CSS styles
├── 📂 docs/                   # Excel templates and documentation
├── 📂 images/                 # User uploaded images
├── 📂 img/                    # Static resources (logos, favicons)
├── 📂 js/                     # JavaScript scripts
├── 📂 php/
│   ├── 📂 app/               # Application logic
│   │   ├── add_client.php    # Add clients
│   │   ├── add_product.php   # Add products
│   │   ├── add_user.php      # Add users
│   │   ├── add_visit.php     # Register visits
│   │   ├── bulk.php          # Bulk client import
│   │   ├── bulk_products.php # Bulk product import
│   │   ├── end_visit.php     # Finalize visits
│   │   └── ...               # Other modules
│   ├── 📂 config/            # Configurations
│   │   ├── connection.php    # DB connection
│   │   └── validations.php   # Access validations
│   ├── 📂 partials/          # Reusable components
│   │   ├── head.php          # HTML header
│   │   ├── subheader.php     # Navigation
│   │   └── footer.php        # Footer
│   └── 📂 views/             # Application views
│       ├── 📂 admin/         # Administrative panel
│       └── 📂 user/          # User panel
├── 📂 vendor/                # Composer dependencies
├── .env                      # Environment variables
├── composer.json             # PHP dependencies
├── index.php                 # Main page
└── README.md                 # Documentation
```

## 🚀 Installation

### Prerequisites
- **PHP 7.4+** with extensions: pdo, pdo_pgsql, gd, curl
- **PostgreSQL 13+**
- **Composer**
- **Web server** (Apache/Laragon): you must redirect to https:// to test correctly QR scan throw qrCode.min.js

### Installation Steps

1. **Clone the repository**
```bash
git clone https://github.com/salasdaniel/visit-app.git
cd visit-app
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment variables**
```bash
cp .env.example .env
```

Edit `.env` with your data:
```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=visit_app
DB_USER=your_user
DB_PASSWORD=your_password

ULTRAMSG_TOKEN=your_ultramsg_token
INSTANCE_ID=your_instance_id
```

4. **Create database**
```sql
-- Execute in PostgreSQL
CREATE DATABASE visit_app;
```

5. **Import database schema**
```bash
psql -U your_user -d visit_app -f database/backup.sql
```

6. **Configure permissions**
```bash
chmod 755 images/
chmod 644 .env
```

## 🔐 Authentication and Roles

### Security
- Session validation on each page
- Sensitive variable encryption
- Role validation per endpoint

## 🛡 Environment Variables

### Database
```env
DB_HOST=localhost           # PostgreSQL host
DB_PORT=5432               # Database port
DB_NAME=visit_app          # Database name
DB_USER=user               # Database user
DB_PASSWORD=password       # Database password
```

### WhatsApp API
```env
ULTRAMSG_TOKEN=token       # UltraMsg token
INSTANCE_ID=instance       # WhatsApp instance ID
```

## 🤝 Contributions

Contributions are welcome. Please:

1. Fork the project
2. Create a branch for your feature (`git checkout -b feature/new-functionality`)
3. Commit your changes (`git commit -m 'Add new functionality'`)
4. Push to the branch (`git push origin feature/new-functionality`)
5. Open a Pull Request

*Developed by salasdev*