# 🏠 Dormitory Management System (KTX Management)

A web-based Dormitory Management System developed using PHP and MySQL to support student dormitory operations, including room registration, contract management, billing, maintenance requests, violations tracking, and administrative management.

---

# 📖 Project Overview

The Dormitory Management System aims to digitize and simplify the management of student housing facilities. The system provides separate interfaces for Administrators and Students while maintaining secure role-based access control.

The application follows the MVC architecture and supports essential dormitory management processes from room registration to contract and billing management.

---

# ✨ Main Features

## 👨‍💼 Administrator Features

* Dashboard and statistics overview
* Building management
* Room management
* Student management
* User account management
* Registration approval workflow
* Contract management
* Invoice management
* Utility management (Electricity & Water)
* Violation tracking
* Maintenance request management
* Notification management

---

## 🎓 Student Features

* Student dashboard
* Room registration
* View room information
* View contracts
* View invoices
* Submit maintenance requests
* View violation records
* Receive notifications
* Manage personal profile

---

# 🔐 Role-Based Access Control

The system implements role-based authentication:

### Admin

* Full access to all management modules
* Access URL:

```text
/admin/dashboard
```

### Student

* Access only personal information and services
* Access URL:

```text
/student/dashboard
```

Authentication is managed through PHP sessions and middleware protection.

---

# 🛠️ Technology Stack

## Backend

* PHP 8
* MVC Architecture
* Session Authentication

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL
* phpMyAdmin

## Server

* Apache (XAMPP)

## Development Tools

* Visual Studio Code
* Git
* GitHub

---

# 🗄️ Database Design

Database name:

```sql
ktx
```

Main database file:

```text
ktx.sql
```

The system contains 12 core tables:

| Table                | Description                   |
| -------------------- | ----------------------------- |
| users                | System user accounts          |
| students             | Student profiles              |
| buildings            | Dormitory buildings           |
| rooms                | Room information              |
| room_registrations   | Room registration requests    |
| contracts            | Dormitory contracts           |
| invoices             | Monthly invoices              |
| utility_readings     | Electricity and water records |
| violation_records    | Violation management          |
| room_amenities       | Room facilities               |
| maintenance_requests | Maintenance requests          |
| notifications        | System notifications          |

### Database Characteristics

* InnoDB Engine
* UTF8MB4 Charset
* Foreign Key Constraints
* Triggers
* Normalized to 3NF

---

# 📂 Project Structure

```text
Final-Web2-PHP-Dormitory-Management
│
├── app/
├── config/
├── middleware/
├── public/
├── routes/
├── scripts/
├── test/
│
├── ktx.sql
├── index.php
├── README.md
│
├── MODERN_UI_UX_GUIDE.md
├── ROLE_BASED_INTERFACE_GUIDE.md
├── MODERN_UI_IMPLEMENTATION_COMPLETE.md
│
└── documentation files
```

---

# ⚙️ Installation Guide

## Step 1: Clone Repository

```bash
git clone https://github.com/yaminotenshi2109/Final-Web2-PHP-Dormitory-Management.git
```

---

## Step 2: Move Project to XAMPP

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
Applications/XAMPP/xamppfiles/htdocs/
```

for macOS.

---

## Step 3: Create Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create database:

```sql
CREATE DATABASE ktx;
```

---

## Step 4: Import Database

Import:

```text
ktx.sql
```

into the newly created database.

---

## Step 5: Configure Database Connection

Open:

```text
config/config.php
```

Update database settings if necessary:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ktx');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## Step 6: Start Services

Start:

* Apache
* MySQL

using XAMPP Control Panel.

---

## Step 7: Run Application

Open browser:

```text
http://localhost/Final-Web2-PHP-Dormitory-Management/public
```

---

# 🧪 Demo Accounts

## Administrator Account

```text
Email: admin@ktx.edu.vn
Password: Admin@123
```

---

## Student Account

```text
Email: student@ktx.edu.vn
Password: Student@123
```

---

# 🔒 Security Features

* Password hashing using bcrypt
* Session-based authentication
* Role-based authorization
* Middleware route protection
* Input validation
* CSRF-safe form handling

---

# 📑 Additional Documentation

The project includes detailed documentation files:

| File                                 | Description                        |
| ------------------------------------ | ---------------------------------- |
| ROLE_BASED_INTERFACE_GUIDE.md        | Role-based interface documentation |
| MODERN_UI_UX_GUIDE.md                | UI/UX guidelines                   |
| MODERN_UI_IMPLEMENTATION_COMPLETE.md | UI implementation report           |

---

# 🧪 Testing Files

The repository contains several testing scripts:

```text
test_admin_regs_page.php
test_db_connection.php
test_simulate_request.php
test_violations_create.php
```

These files are used during development and debugging.

---

# 🚀 Future Enhancements

* Online payment integration
* Email notifications
* SMS notifications
* Analytics dashboard
* Mobile responsive improvements
* REST API integration
* Multi-language support

---

# 👥 Development Team

Dormitory Management System Development Team

Course Project – Web Development

---

# 📄 License

This project is developed for educational and academic purposes only.
# 🏠 Dormitory Management System (KTX Management)

A web-based Dormitory Management System developed using PHP and MySQL to support student dormitory operations, including room registration, contract management, billing, maintenance requests, violations tracking, and administrative management.

---

# 📖 Project Overview

The Dormitory Management System aims to digitize and simplify the management of student housing facilities. The system provides separate interfaces for Administrators and Students while maintaining secure role-based access control.

The application follows the MVC architecture and supports essential dormitory management processes from room registration to contract and billing management.

---

# ✨ Main Features

## 👨‍💼 Administrator Features

* Dashboard and statistics overview
* Building management
* Room management
* Student management
* User account management
* Registration approval workflow
* Contract management
* Invoice management
* Utility management (Electricity & Water)
* Violation tracking
* Maintenance request management
* Notification management

---

## 🎓 Student Features

* Student dashboard
* Room registration
* View room information
* View contracts
* View invoices
* Submit maintenance requests
* View violation records
* Receive notifications
* Manage personal profile

---

# 🔐 Role-Based Access Control

The system implements role-based authentication:

### Admin

* Full access to all management modules
* Access URL:

```text
/admin/dashboard
```

### Student

* Access only personal information and services
* Access URL:

```text
/student/dashboard
```

Authentication is managed through PHP sessions and middleware protection.

---

# 🛠️ Technology Stack

## Backend

* PHP 8
* MVC Architecture
* Session Authentication

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL
* phpMyAdmin

## Server

* Apache (XAMPP)

## Development Tools

* Visual Studio Code
* Git
* GitHub

---

# 🗄️ Database Design

Database name:

```sql
ktx
```

Main database file:

```text
ktx.sql
```

The system contains 12 core tables:

| Table                | Description                   |
| -------------------- | ----------------------------- |
| users                | System user accounts          |
| students             | Student profiles              |
| buildings            | Dormitory buildings           |
| rooms                | Room information              |
| room_registrations   | Room registration requests    |
| contracts            | Dormitory contracts           |
| invoices             | Monthly invoices              |
| utility_readings     | Electricity and water records |
| violation_records    | Violation management          |
| room_amenities       | Room facilities               |
| maintenance_requests | Maintenance requests          |
| notifications        | System notifications          |

### Database Characteristics

* InnoDB Engine
* UTF8MB4 Charset
* Foreign Key Constraints
* Triggers
* Normalized to 3NF

---

# 📂 Project Structure

```text
Final-Web2-PHP-Dormitory-Management
│
├── app/
├── config/
├── middleware/
├── public/
├── routes/
├── scripts/
├── test/
│
├── ktx.sql
├── index.php
├── README.md
│
├── MODERN_UI_UX_GUIDE.md
├── ROLE_BASED_INTERFACE_GUIDE.md
├── MODERN_UI_IMPLEMENTATION_COMPLETE.md
│
└── documentation files
```

---

# ⚙️ Installation Guide

## Step 1: Clone Repository

```bash
git clone https://github.com/yaminotenshi2109/Final-Web2-PHP-Dormitory-Management.git
```

---

## Step 2: Move Project to XAMPP

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
Applications/XAMPP/xamppfiles/htdocs/
```

for macOS.

---

## Step 3: Create Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create database:

```sql
CREATE DATABASE ktx;
```

---

## Step 4: Import Database

Import:

```text
ktx.sql
```

into the newly created database.

---

## Step 5: Configure Database Connection

Open:

```text
config/config.php
```

Update database settings if necessary:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ktx');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## Step 6: Start Services

Start:

* Apache
* MySQL

using XAMPP Control Panel.

---

## Step 7: Run Application

Open browser:

```text
http://localhost/Final-Web2-PHP-Dormitory-Management/public
```

---

# 🧪 Demo Accounts

## Administrator Account

```text
Email: admin@ktx.edu.vn
Password: Admin@123
```

---

## Student Account

```text
Email: student@ktx.edu.vn
Password: Student@123
```

---

# 🔒 Security Features

* Password hashing using bcrypt
* Session-based authentication
* Role-based authorization
* Middleware route protection
* Input validation
* CSRF-safe form handling

---

# 📑 Additional Documentation

The project includes detailed documentation files:

| File                                 | Description                        |
| ------------------------------------ | ---------------------------------- |
| ROLE_BASED_INTERFACE_GUIDE.md        | Role-based interface documentation |
| MODERN_UI_UX_GUIDE.md                | UI/UX guidelines                   |
| MODERN_UI_IMPLEMENTATION_COMPLETE.md | UI implementation report           |

---

# 🧪 Testing Files

The repository contains several testing scripts:

```text
test_admin_regs_page.php
test_db_connection.php
test_simulate_request.php
test_violations_create.php
```

These files are used during development and debugging.

---

# 🚀 Future Enhancements

* Online payment integration
* Email notifications
* SMS notifications
* Analytics dashboard
* Mobile responsive improvements
* REST API integration
* Multi-language support

---

# 👥 Development Team

Dormitory Management System Development Team

Course Project – Web Development

---

# 📄 License

This project is developed for educational and academic purposes only.
# 🏠 Dormitory Management System (KTX Management)

A web-based Dormitory Management System developed using PHP and MySQL to support student dormitory operations, including room registration, contract management, billing, maintenance requests, violations tracking, and administrative management.

---

# 📖 Project Overview

The Dormitory Management System aims to digitize and simplify the management of student housing facilities. The system provides separate interfaces for Administrators and Students while maintaining secure role-based access control.

The application follows the MVC architecture and supports essential dormitory management processes from room registration to contract and billing management.

---

# ✨ Main Features

## 👨‍💼 Administrator Features

* Dashboard and statistics overview
* Building management
* Room management
* Student management
* User account management
* Registration approval workflow
* Contract management
* Invoice management
* Utility management (Electricity & Water)
* Violation tracking
* Maintenance request management
* Notification management

---

## 🎓 Student Features

* Student dashboard
* Room registration
* View room information
* View contracts
* View invoices
* Submit maintenance requests
* View violation records
* Receive notifications
* Manage personal profile

---

# 🔐 Role-Based Access Control

The system implements role-based authentication:

### Admin

* Full access to all management modules
* Access URL:

```text
/admin/dashboard
```

### Student

* Access only personal information and services
* Access URL:

```text
/student/dashboard
```

Authentication is managed through PHP sessions and middleware protection.

---

# 🛠️ Technology Stack

## Backend

* PHP 8
* MVC Architecture
* Session Authentication

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL
* phpMyAdmin

## Server

* Apache (XAMPP)

## Development Tools

* Visual Studio Code
* Git
* GitHub

---

# 🗄️ Database Design

Database name:

```sql
ktx
```

Main database file:

```text
ktx.sql
```

The system contains 12 core tables:

| Table                | Description                   |
| -------------------- | ----------------------------- |
| users                | System user accounts          |
| students             | Student profiles              |
| buildings            | Dormitory buildings           |
| rooms                | Room information              |
| room_registrations   | Room registration requests    |
| contracts            | Dormitory contracts           |
| invoices             | Monthly invoices              |
| utility_readings     | Electricity and water records |
| violation_records    | Violation management          |
| room_amenities       | Room facilities               |
| maintenance_requests | Maintenance requests          |
| notifications        | System notifications          |

### Database Characteristics

* InnoDB Engine
* UTF8MB4 Charset
* Foreign Key Constraints
* Triggers
* Normalized to 3NF

---

# 📂 Project Structure

```text
Final-Web2-PHP-Dormitory-Management
│
├── app/
├── config/
├── middleware/
├── public/
├── routes/
├── scripts/
├── test/
│
├── ktx.sql
├── index.php
├── README.md
│
├── MODERN_UI_UX_GUIDE.md
├── ROLE_BASED_INTERFACE_GUIDE.md
├── MODERN_UI_IMPLEMENTATION_COMPLETE.md
│
└── documentation files
```

---

# ⚙️ Installation Guide

## Step 1: Clone Repository

```bash
git clone https://github.com/yaminotenshi2109/Final-Web2-PHP-Dormitory-Management.git
```

---

## Step 2: Move Project to XAMPP

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
Applications/XAMPP/xamppfiles/htdocs/
```

for macOS.

---

## Step 3: Create Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create database:

```sql
CREATE DATABASE ktx;
```

---

## Step 4: Import Database

Import:

```text
ktx.sql
```

into the newly created database.

---

## Step 5: Configure Database Connection

Open:

```text
config/config.php
```

Update database settings if necessary:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ktx');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## Step 6: Start Services

Start:

* Apache
* MySQL

using XAMPP Control Panel.

---

## Step 7: Run Application

Open browser:

```text
http://localhost/Final-Web2-PHP-Dormitory-Management/public
```

---

# 🧪 Demo Accounts

## Administrator Account

```text
Email: admin@ktx.edu.vn
Password: Admin@123
```

---

## Student Account

```text
Email: student@ktx.edu.vn
Password: Student@123
```

---

# 🔒 Security Features

* Password hashing using bcrypt
* Session-based authentication
* Role-based authorization
* Middleware route protection
* Input validation
* CSRF-safe form handling

---

# 📑 Additional Documentation

The project includes detailed documentation files:

| File                                 | Description                        |
| ------------------------------------ | ---------------------------------- |
| ROLE_BASED_INTERFACE_GUIDE.md        | Role-based interface documentation |
| MODERN_UI_UX_GUIDE.md                | UI/UX guidelines                   |
| MODERN_UI_IMPLEMENTATION_COMPLETE.md | UI implementation report           |

---

# 🧪 Testing Files

The repository contains several testing scripts:

```text
test_admin_regs_page.php
test_db_connection.php
test_simulate_request.php
test_violations_create.php
```

These files are used during development and debugging.

---

# 🚀 Future Enhancements

* Online payment integration
* Email notifications
* SMS notifications
* Analytics dashboard
* Mobile responsive improvements
* REST API integration
* Multi-language support

---

# 👥 Development Team

Dormitory Management System Development Team

Course Project – Web Development

---

# 📄 License

This project is developed for educational and academic purposes only.
# 🏠 Dormitory Management System (KTX Management)

A web-based Dormitory Management System developed using PHP and MySQL to support student dormitory operations, including room registration, contract management, billing, maintenance requests, violations tracking, and administrative management.

---

# 📖 Project Overview

The Dormitory Management System aims to digitize and simplify the management of student housing facilities. The system provides separate interfaces for Administrators and Students while maintaining secure role-based access control.

The application follows the MVC architecture and supports essential dormitory management processes from room registration to contract and billing management.

---

# ✨ Main Features

## 👨‍💼 Administrator Features

* Dashboard and statistics overview
* Building management
* Room management
* Student management
* User account management
* Registration approval workflow
* Contract management
* Invoice management
* Utility management (Electricity & Water)
* Violation tracking
* Maintenance request management
* Notification management

---

## 🎓 Student Features

* Student dashboard
* Room registration
* View room information
* View contracts
* View invoices
* Submit maintenance requests
* View violation records
* Receive notifications
* Manage personal profile

---

# 🔐 Role-Based Access Control

The system implements role-based authentication:

### Admin

* Full access to all management modules
* Access URL:

```text
/admin/dashboard
```

### Student

* Access only personal information and services
* Access URL:

```text
/student/dashboard
```

Authentication is managed through PHP sessions and middleware protection.

---

# 🛠️ Technology Stack

## Backend

* PHP 8
* MVC Architecture
* Session Authentication

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL
* phpMyAdmin

## Server

* Apache (XAMPP)

## Development Tools

* Visual Studio Code
* Git
* GitHub

---

# 🗄️ Database Design

Database name:

```sql
ktx
```

Main database file:

```text
ktx.sql
```

The system contains 12 core tables:

| Table                | Description                   |
| -------------------- | ----------------------------- |
| users                | System user accounts          |
| students             | Student profiles              |
| buildings            | Dormitory buildings           |
| rooms                | Room information              |
| room_registrations   | Room registration requests    |
| contracts            | Dormitory contracts           |
| invoices             | Monthly invoices              |
| utility_readings     | Electricity and water records |
| violation_records    | Violation management          |
| room_amenities       | Room facilities               |
| maintenance_requests | Maintenance requests          |
| notifications        | System notifications          |

### Database Characteristics

* InnoDB Engine
* UTF8MB4 Charset
* Foreign Key Constraints
* Triggers
* Normalized to 3NF

---

# 📂 Project Structure

```text
Final-Web2-PHP-Dormitory-Management
│
├── app/
├── config/
├── middleware/
├── public/
├── routes/
├── scripts/
├── test/
│
├── ktx.sql
├── index.php
├── README.md
│
├── MODERN_UI_UX_GUIDE.md
├── ROLE_BASED_INTERFACE_GUIDE.md
├── MODERN_UI_IMPLEMENTATION_COMPLETE.md
│
└── documentation files
```

---

# ⚙️ Installation Guide

## Step 1: Clone Repository

```bash
git clone https://github.com/yaminotenshi2109/Final-Web2-PHP-Dormitory-Management.git
```

---

## Step 2: Move Project to XAMPP

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
Applications/XAMPP/xamppfiles/htdocs/
```

for macOS.

---

## Step 3: Create Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create database:

```sql
CREATE DATABASE ktx;
```

---

## Step 4: Import Database

Import:

```text
ktx.sql
```

into the newly created database.

---

## Step 5: Configure Database Connection

Open:

```text
config/config.php
```

Update database settings if necessary:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ktx');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## Step 6: Start Services

Start:

* Apache
* MySQL

using XAMPP Control Panel.

---

## Step 7: Run Application

Open browser:

```text
http://localhost/Final-Web2-PHP-Dormitory-Management/public
```

---

# 🧪 Demo Accounts

## Administrator Account

```text
Email: admin@ktx.edu.vn
Password: Admin@123
```

---

## Student Account

```text
Email: student@ktx.edu.vn
Password: Student@123
```

---

# 🔒 Security Features

* Password hashing using bcrypt
* Session-based authentication
* Role-based authorization
* Middleware route protection
* Input validation
* CSRF-safe form handling

---

# 📑 Additional Documentation

The project includes detailed documentation files:

| File                                 | Description                        |
| ------------------------------------ | ---------------------------------- |
| ROLE_BASED_INTERFACE_GUIDE.md        | Role-based interface documentation |
| MODERN_UI_UX_GUIDE.md                | UI/UX guidelines                   |
| MODERN_UI_IMPLEMENTATION_COMPLETE.md | UI implementation report           |

---

# 🧪 Testing Files

The repository contains several testing scripts:

```text
test_admin_regs_page.php
test_db_connection.php
test_simulate_request.php
test_violations_create.php
```

These files are used during development and debugging.

---

# 🚀 Future Enhancements

* Online payment integration
* Email notifications
* SMS notifications
* Analytics dashboard
* Mobile responsive improvements
* REST API integration
* Multi-language support

---

# 👥 Development Team

Dormitory Management System Development Team

Course Project – Web Development

---

# 📄 License

This project is developed for educational and academic purposes only.
# 🏠 Dormitory Management System (KTX Management)

A web-based Dormitory Management System developed using PHP and MySQL to support student dormitory operations, including room registration, contract management, billing, maintenance requests, violations tracking, and administrative management.

---

# 📖 Project Overview

The Dormitory Management System aims to digitize and simplify the management of student housing facilities. The system provides separate interfaces for Administrators and Students while maintaining secure role-based access control.

The application follows the MVC architecture and supports essential dormitory management processes from room registration to contract and billing management.

---

# ✨ Main Features

## 👨‍💼 Administrator Features

* Dashboard and statistics overview
* Building management
* Room management
* Student management
* User account management
* Registration approval workflow
* Contract management
* Invoice management
* Utility management (Electricity & Water)
* Violation tracking
* Maintenance request management
* Notification management

---

## 🎓 Student Features

* Student dashboard
* Room registration
* View room information
* View contracts
* View invoices
* Submit maintenance requests
* View violation records
* Receive notifications
* Manage personal profile

---

# 🔐 Role-Based Access Control

The system implements role-based authentication:

### Admin

* Full access to all management modules
* Access URL:

```text
/admin/dashboard
```

### Student

* Access only personal information and services
* Access URL:

```text
/student/dashboard
```

Authentication is managed through PHP sessions and middleware protection.

---

# 🛠️ Technology Stack

## Backend

* PHP 8
* MVC Architecture
* Session Authentication

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL
* phpMyAdmin

## Server

* Apache (XAMPP)

## Development Tools

* Visual Studio Code
* Git
* GitHub

---

# 🗄️ Database Design

Database name:

```sql
ktx
```

Main database file:

```text
ktx.sql
```

The system contains 12 core tables:

| Table                | Description                   |
| -------------------- | ----------------------------- |
| users                | System user accounts          |
| students             | Student profiles              |
| buildings            | Dormitory buildings           |
| rooms                | Room information              |
| room_registrations   | Room registration requests    |
| contracts            | Dormitory contracts           |
| invoices             | Monthly invoices              |
| utility_readings     | Electricity and water records |
| violation_records    | Violation management          |
| room_amenities       | Room facilities               |
| maintenance_requests | Maintenance requests          |
| notifications        | System notifications          |

### Database Characteristics

* InnoDB Engine
* UTF8MB4 Charset
* Foreign Key Constraints
* Triggers
* Normalized to 3NF

---

# 📂 Project Structure

```text
Final-Web2-PHP-Dormitory-Management
│
├── app/
├── config/
├── middleware/
├── public/
├── routes/
├── scripts/
├── test/
│
├── ktx.sql
├── index.php
├── README.md
│
├── MODERN_UI_UX_GUIDE.md
├── ROLE_BASED_INTERFACE_GUIDE.md
├── MODERN_UI_IMPLEMENTATION_COMPLETE.md
│
└── documentation files
```

---

# ⚙️ Installation Guide

## Step 1: Clone Repository

```bash
git clone https://github.com/yaminotenshi2109/Final-Web2-PHP-Dormitory-Management.git
```

---

## Step 2: Move Project to XAMPP

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
Applications/XAMPP/xamppfiles/htdocs/
```

for macOS.

---

## Step 3: Create Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create database:

```sql
CREATE DATABASE ktx;
```

---

## Step 4: Import Database

Import:

```text
ktx.sql
```

into the newly created database.

---

## Step 5: Configure Database Connection

Open:

```text
config/config.php
```

Update database settings if necessary:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ktx');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## Step 6: Start Services

Start:

* Apache
* MySQL

using XAMPP Control Panel.

---

## Step 7: Run Application

Open browser:

```text
http://localhost/Final-Web2-PHP-Dormitory-Management/public
```

---

# 🧪 Demo Accounts

## Administrator Account

```text
Email: admin@ktx.edu.vn
Password: Admin@123
```

---

## Student Account

```text
Email: student@ktx.edu.vn
Password: Student@123
```

---

# 🔒 Security Features

* Password hashing using bcrypt
* Session-based authentication
* Role-based authorization
* Middleware route protection
* Input validation
* CSRF-safe form handling

---

# 📑 Additional Documentation

The project includes detailed documentation files:

| File                                 | Description                        |
| ------------------------------------ | ---------------------------------- |
| ROLE_BASED_INTERFACE_GUIDE.md        | Role-based interface documentation |
| MODERN_UI_UX_GUIDE.md                | UI/UX guidelines                   |
| MODERN_UI_IMPLEMENTATION_COMPLETE.md | UI implementation report           |

---

# 🧪 Testing Files

The repository contains several testing scripts:

```text
test_admin_regs_page.php
test_db_connection.php
test_simulate_request.php
test_violations_create.php
```

These files are used during development and debugging.

---

# 🚀 Future Enhancements

* Online payment integration
* Email notifications
* SMS notifications
* Analytics dashboard
* Mobile responsive improvements
* REST API integration
* Multi-language support

---

# 👥 Development Team

Dormitory Management System Development Team

Course Project – Web Development

---

# 📄 License

This project is developed for educational and academic purposes only.
# 🏠 Dormitory Management System (KTX Management)

A web-based Dormitory Management System developed using PHP and MySQL to support student dormitory operations, including room registration, contract management, billing, maintenance requests, violations tracking, and administrative management.

---

# 📖 Project Overview

The Dormitory Management System aims to digitize and simplify the management of student housing facilities. The system provides separate interfaces for Administrators and Students while maintaining secure role-based access control.

The application follows the MVC architecture and supports essential dormitory management processes from room registration to contract and billing management.

---

# ✨ Main Features

## 👨‍💼 Administrator Features

* Dashboard and statistics overview
* Building management
* Room management
* Student management
* User account management
* Registration approval workflow
* Contract management
* Invoice management
* Utility management (Electricity & Water)
* Violation tracking
* Maintenance request management
* Notification management

---

## 🎓 Student Features

* Student dashboard
* Room registration
* View room information
* View contracts
* View invoices
* Submit maintenance requests
* View violation records
* Receive notifications
* Manage personal profile

---

# 🔐 Role-Based Access Control

The system implements role-based authentication:

### Admin

* Full access to all management modules
* Access URL:

```text
/admin/dashboard
```

### Student

* Access only personal information and services
* Access URL:

```text
/student/dashboard
```

Authentication is managed through PHP sessions and middleware protection.

---

# 🛠️ Technology Stack

## Backend

* PHP 8
* MVC Architecture
* Session Authentication

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL
* phpMyAdmin

## Server

* Apache (XAMPP)

## Development Tools

* Visual Studio Code
* Git
* GitHub

---

# 🗄️ Database Design

Database name:

```sql
ktx
```

Main database file:

```text
ktx.sql
```

The system contains 12 core tables:

| Table                | Description                   |
| -------------------- | ----------------------------- |
| users                | System user accounts          |
| students             | Student profiles              |
| buildings            | Dormitory buildings           |
| rooms                | Room information              |
| room_registrations   | Room registration requests    |
| contracts            | Dormitory contracts           |
| invoices             | Monthly invoices              |
| utility_readings     | Electricity and water records |
| violation_records    | Violation management          |
| room_amenities       | Room facilities               |
| maintenance_requests | Maintenance requests          |
| notifications        | System notifications          |

### Database Characteristics

* InnoDB Engine
* UTF8MB4 Charset
* Foreign Key Constraints
* Triggers
* Normalized to 3NF

---

# 📂 Project Structure

```text
Final-Web2-PHP-Dormitory-Management
│
├── app/
├── config/
├── middleware/
├── public/
├── routes/
├── scripts/
├── test/
│
├── ktx.sql
├── index.php
├── README.md
│
├── MODERN_UI_UX_GUIDE.md
├── ROLE_BASED_INTERFACE_GUIDE.md
├── MODERN_UI_IMPLEMENTATION_COMPLETE.md
│
└── documentation files
```

---

# ⚙️ Installation Guide

## Step 1: Clone Repository

```bash
git clone https://github.com/yaminotenshi2109/Final-Web2-PHP-Dormitory-Management.git
```

---

## Step 2: Move Project to XAMPP

Copy the project folder to:

```text
xampp/htdocs/
```

or

```text
Applications/XAMPP/xamppfiles/htdocs/
```

for macOS.

---

## Step 3: Create Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create database:

```sql
CREATE DATABASE ktx;
```

---

## Step 4: Import Database

Import:

```text
ktx.sql
```

into the newly created database.

---

## Step 5: Configure Database Connection

Open:

```text
config/config.php
```

Update database settings if necessary:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ktx');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## Step 6: Start Services

Start:

* Apache
* MySQL

using XAMPP Control Panel.

---

## Step 7: Run Application

Open browser:

```text
http://localhost/Final-Web2-PHP-Dormitory-Management/public
```

---

# 🧪 Demo Accounts

## Administrator Account

```text
Email: admin@ktx.edu.vn
Password: Admin@123
```

---

## Student Account

```text
Email: student@ktx.edu.vn
Password: Student@123
```

---

# 🔒 Security Features

* Password hashing using bcrypt
* Session-based authentication
* Role-based authorization
* Middleware route protection
* Input validation
* CSRF-safe form handling

---

# 📑 Additional Documentation

The project includes detailed documentation files:

| File                                 | Description                        |
| ------------------------------------ | ---------------------------------- |
| ROLE_BASED_INTERFACE_GUIDE.md        | Role-based interface documentation |
| MODERN_UI_UX_GUIDE.md                | UI/UX guidelines                   |
| MODERN_UI_IMPLEMENTATION_COMPLETE.md | UI implementation report           |

---

# 🧪 Testing Files

The repository contains several testing scripts:

```text
test_admin_regs_page.php
test_db_connection.php
test_simulate_request.php
test_violations_create.php
```

These files are used during development and debugging.

---

# 🚀 Future Enhancements

* Online payment integration
* Email notifications
* SMS notifications
* Analytics dashboard
* Mobile responsive improvements
* REST API integration
* Multi-language support

---

# 👥 Development Team

Dormitory Management System Development Team

Course Project – Web Development

---

# 📄 License

This project is developed for educational and academic purposes only.
