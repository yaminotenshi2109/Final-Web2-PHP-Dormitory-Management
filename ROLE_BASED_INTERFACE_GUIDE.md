# Role-Based Interface Distinction Guide

## Overview
The KTX Management System now provides **distinct interfaces for Admin and Student roles** while maintaining a **unified logout experience** for both.

---

## 🔐 Login Page - Demo Accounts

The login page (`app/views/auth_login_page.php`) now displays:

### Admin Account
- **Role**: 🛡️ **Quản Trị Viên (Admin)**
- **Email**: `admin@ktx.edu.vn`
- **Password**: `Admin@123`
- **Dashboard**: `/admin/dashboard`
- **Access**: Full system administration, user management, reports

### Student Account  
- **Role**: 🎓 **Sinh Viên (Student)**
- **Email**: `student@ktx.edu.vn`
- **Password**: `Student@123`
- **Dashboard**: `/student/dashboard`
- **Access**: Room registration, invoices, maintenance requests, profile

---

## 📊 How Role-Based Routing Works

### Login Flow

```
1. User enters credentials on /auth/login
2. System verifies email and password in users table
3. User's role is checked (admin | student)
4. System redirects to appropriate dashboard:
   - Admin → /admin/dashboard
   - Student → /student/dashboard
5. Session stores user data including role: $_SESSION['_auth_user']
```

### Location: `app/controllers/RoomController.php` (lines 369-370)
```php
$home = $user['role'] === 'admin' ? '/admin/dashboard' : '/student/dashboard';
$this->redirect($intended ?? $home);
```

---

## 🎨 Different Interfaces

### Admin Interface
- **Sidebar**: Admin Panel with menu items
  - 📊 Dashboard
  - 🏢 Buildings management
  - 🚪 Room management
  - 🎓 Student management
  - 📋 Registration approvals
  - 📄 Contract management
  - 💰 Invoice management
  - ⚡ Utilities management
  - ⚠️ Violation tracking
  - 🔧 Maintenance oversight

- **Location**: `app/views/layouts/modern.php` (lines 76-107)

### Student Interface
- **Sidebar**: Student Portal with menu items
  - 📊 Dashboard
  - 🚪 My Room
  - 📄 Contracts
  - 💰 Invoices
  - 🔧 Maintenance requests
  - ⚠️ Violations
  - 👤 Profile

- **Location**: `app/views/layouts/modern.php` (lines 118-142)

---

## 🚪 Logout - Unified Experience

### Important Feature ✅
Both Admin and Student users share the **same logout mechanism**:

- **Logout Button**: Available on topbar for both roles
- **Action**: Calls `POST /logout`
- **Handler**: `app/controllers/RoomController.php` (line 427-430)
- **Behavior**:
  ```php
  public function logout(array $params = []): void
  {
      $this->logoutUser();  // Clears session
      $this->flash('success', 'Đã đăng xuất thành công.');
      $this->redirect('/auth/login');  // Both roles redirect here
  }
  ```

- **Result**: 
  - Session data is destroyed
  - User is redirected to `/auth/login`
  - Same login page is shown to both roles
  - Generic success message appears

---

## 🔒 Middleware Protection

### Authentication Middleware
- **File**: `middleware/Middleware.php`
- **Class**: `AuthMiddleware`
- **Purpose**: Ensures user is logged in
- **Action**: Redirects to login if not authenticated
- **Applies to**: All protected routes

### Admin Middleware
- **File**: `middleware/Middleware.php`
- **Class**: `AdminMiddleware`
- **Purpose**: Ensures user is logged in AND has admin role
- **Action**: Returns 403 Forbidden if not admin
- **Applies to**: Routes under `/admin/*`

---

## 📝 Implementation Details

### User Table Structure
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50),
  email VARCHAR(100) UNIQUE,
  password_hash VARCHAR(255),
  role ENUM('admin','student'),  -- Role stored here
  status ENUM('active','inactive','banned'),
  created_at DATETIME,
  updated_at DATETIME
);
```

### Session Data
When user logs in, the following is stored:
```php
$_SESSION['_auth_user'] = [
    'id'        => 1,
    'username'  => 'admin',
    'email'     => 'admin@ktx.edu.vn',
    'role'      => 'admin',        // Key field for UI routing
    'status'    => 'active'
];
```

### Helper Methods in BaseController
```php
// Check if logged in
protected function isLoggedIn(): bool
protected function auth(?string $key = null): mixed

// Check role
protected function isAdmin(): bool
protected function isStudent(): bool

// Login/Logout
protected function loginUser(array $user): void
protected function logoutUser(): void
```

---

## 🎯 Testing the System

### Test Admin Login
1. Go to `/auth/login`
2. Click "Đăng nhập Admin →" button (blue)
3. OR manually enter:
   - Email: `admin@ktx.edu.vn`
   - Password: `Admin@123`
4. You should see Admin Dashboard with full sidebar menu

### Test Student Login
1. Go to `/auth/login`
2. Click "Đăng nhập Sinh Viên →" button (green)
3. OR manually enter:
   - Email: `student@ktx.edu.vn`
   - Password: `Student@123`
4. You should see Student Dashboard with limited sidebar menu

### Test Logout
1. From either dashboard, click logout button
2. Both roles should:
   - See success message: "Đã đăng xuất thành công."
   - Be redirected to `/auth/login`
   - See the same generic login page

---

## 🔑 Key Features

✅ **Distinct Interfaces**: Different dashboards and sidebars for each role
✅ **Unified Logout**: Same logout process and destination for both roles
✅ **Role-Based Access Control**: Routes protected by role middleware
✅ **Quick Demo Login**: One-click demo account login buttons
✅ **Session-Based**: Role checking done via session, no cookies needed
✅ **Secure**: Passwords hashed with bcrypt, session regenerated on login

---

## 📂 Relevant Files Modified

1. **`app/views/auth_login_page.php`** - Enhanced login with dual demo accounts
2. **`app/views/layouts/modern.php`** - Role-based sidebar display
3. **`test/add_student_demo.php`** - Script to add student demo account (can be deleted after running)

---

## ⚙️ How to Add New Users with Different Roles

Via Admin Panel (`/admin/users/create`):
1. Click "Add User" button
2. Select role: Admin or Student
3. If Student, additional fields appear for student profile
4. Submit form to create user

Via Database:
```sql
-- Create admin user
INSERT INTO users (username, email, password_hash, role)
VALUES ('newadmin', 'newadmin@ktx.edu.vn', PASSWORD_HASH('Password123'), 'admin');

-- Create student user + profile
INSERT INTO users (username, email, password_hash, role)
VALUES ('newsv', 'newsv@student.edu.vn', PASSWORD_HASH('Password123'), 'student');

-- Then add student profile
INSERT INTO students (user_id, student_code, full_name, gender, dob, ...)
VALUES (LAST_INSERT_ID(), 'SV20250002', 'Tên Sinh Viên', 'male', '2005-01-01', ...);
```

---

Generated: 2026-06-08
Status: ✅ Implementation Complete
