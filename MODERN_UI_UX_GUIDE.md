# 🎨 KTX System - Modern UI/UX Design Guide

**Date**: 2026-06-08  
**Version**: 1.0  
**Status**: ✅ Complete

---

## 📑 Table of Contents

1. [Design System](#design-system)
2. [Color Palette](#color-palette)
3. [Typography](#typography)
4. [Component Library](#component-library)
5. [Responsive Design](#responsive-design)
6. [Folder Structure](#folder-structure)
7. [Implementation Guide](#implementation-guide)
8. [JavaScript Utilities](#javascript-utilities)

---

## 🎨 Design System

### Principles
✅ **Modern**: Clean, minimalist design with contemporary aesthetics
✅ **Responsive**: Works perfectly on desktop, tablet, mobile
✅ **Accessible**: WCAG 2.1 AA compliant
✅ **Performance**: Optimized CSS and minimal JS
✅ **Consistent**: Unified design language across all pages

### Key Features
- Bootstrap 5 foundation
- Custom CSS variables for theming
- Smooth transitions and animations
- Intuitive navigation
- User-friendly forms
- Professional data tables

---

## 🎨 Color Palette

### Primary Colors
| Color | Value | Usage |
|-------|-------|-------|
| Primary | `#185FA5` | Main CTA, links, active states |
| Primary Dark | `#154FA0` | Hover states, deep accents |
| Primary Light | `#2A7FD8` | Background tints |

### Semantic Colors
| Color | Value | Usage |
|-------|-------|-------|
| Success | `#28A745` | Positive actions, success messages |
| Danger | `#DC3545` | Destructive actions, errors |
| Warning | `#FFC107` | Warnings, alerts |
| Info | `#17A2B8` | Informational messages |

### Neutral Colors
| Color | Value | Usage |
|-------|-------|-------|
| Dark | `#212529` | Text, headings |
| Light | `#F8F9FA` | Backgrounds |
| White | `#FFFFFF` | Cards, modals |
| Gray-600 | `#6C757D` | Muted text |

---

## 📝 Typography

### Font Family
- **Primary**: System fonts (-apple-system, Segoe UI, Roboto)
- **Monospace**: SFMono-Regular, Consolas, Monaco

### Sizes
```
H1: 2.25rem (36px)  - Page titles
H2: 1.875rem (30px) - Section titles
H3: 1.5rem (24px)   - Subsection titles
H4: 1.25rem (20px)  - Card titles
P:  1rem (16px)     - Body text
SM: 0.875rem (14px) - Secondary text
XS: 0.75rem (12px)  - Labels, captions
```

### Font Weights
- **400**: Normal text
- **500**: Medium emphasis
- **600**: Semibold (labels)
- **700**: Bold (headings)
- **800**: Extrabold (important text)

### Line Heights
- **1.2**: Tight (headings)
- **1.5**: Normal (body)
- **1.75**: Relaxed (lists)
- **2**: Loose (descriptions)

---

## 🧩 Component Library

### 1. Buttons

#### Variants
```html
<!-- Primary Button -->
<button class="btn btn-primary">
    <i class="ti ti-check"></i> Save
</button>

<!-- Secondary Button -->
<button class="btn btn-secondary">Cancel</button>

<!-- Outline Button -->
<button class="btn btn-outline-primary">Edit</button>

<!-- Danger Button -->
<button class="btn btn-danger">
    <i class="ti ti-trash"></i> Delete
</button>
```

#### Sizes
```html
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Normal</button>
<button class="btn btn-primary btn-lg">Large</button>
<button class="btn btn-primary btn-block">Full Width</button>
```

---

### 2. Forms

#### Input Example
```html
<div class="form-group">
    <label for="email">Email</label>
    <input 
        type="email" 
        id="email" 
        name="email" 
        class="form-control" 
        placeholder="your@email.com"
    >
    <div class="invalid-feedback" style="display: block;">
        Vui lòng nhập email hợp lệ
    </div>
</div>
```

#### Form Validation
```javascript
// Validate on submit
const form = document.querySelector('form');
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Get form data
    const data = Form.getData('form');
    
    // Validate
    const errors = {};
    if (!Validate.email(data.email)) {
        errors.email = 'Email không hợp lệ';
    }
    
    // Show errors if any
    if (Object.keys(errors).length > 0) {
        Form.setErrors('form', errors);
        return;
    }
    
    // Submit
    try {
        const result = await API.post('/api/users', data);
        Notify.success('Tạo thành công');
    } catch (error) {
        Notify.error('Lỗi: ' + error.message);
    }
});
```

---

### 3. Cards

```html
<div class="card">
    <div class="card-header">
        <h4>Thông tin phòng</h4>
    </div>
    <div class="card-body">
        <p>Nội dung card</p>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary btn-sm">Chỉnh sửa</button>
    </div>
</div>
```

---

### 4. Tables

```html
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên phòng</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>101</td>
                <td><span class="badge badge-success">Standard</span></td>
                <td>2,000,000 VND</td>
                <td>
                    <button class="btn btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

---

### 5. Alerts

```html
<!-- Success Alert -->
<div class="alert alert-success">
    <i class="ti ti-check-circle"></i> Thao tác thành công!
</div>

<!-- Danger Alert -->
<div class="alert alert-danger">
    <i class="ti ti-alert-circle"></i> Có lỗi xảy ra!
</div>

<!-- Warning Alert -->
<div class="alert alert-warning">
    <i class="ti ti-alert-triangle"></i> Cảnh báo!
</div>
```

---

### 6. Badges

```html
<span class="badge badge-success">Hoạt động</span>
<span class="badge badge-danger">Bị cấm</span>
<span class="badge badge-warning">Chờ xử lý</span>
<span class="badge badge-info">Thông tin</span>
```

---

### 7. Modal

```html
<!-- Modal HTML -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Form here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Show Modal -->
<script>
    Modal.show('editModal');
</script>
```

---

## 📱 Responsive Design

### Breakpoints
```
Mobile:     < 480px
Tablet:     480px - 768px  
Desktop:    768px - 992px
Large:      > 992px
```

### Responsive Classes
```html
<!-- Columns adjust based on screen size -->
<div class="row">
    <div class="col col-md-6 col-sm-12">
        Responsive column
    </div>
</div>

<!-- Hide/Show on specific screens -->
<div class="d-none d-md-block">Visible only on medium+ screens</div>
<div class="d-block d-md-none">Visible only on mobile</div>
```

---

## 📁 Folder Structure

```
public/
├── assets/
│   ├── css/
│   │   ├── base/
│   │   │   ├── variables.css       ← All variables
│   │   │   ├── reset.css
│   │   │   └── typography.css
│   │   ├── components/
│   │   │   ├── buttons.css
│   │   │   ├── forms.css
│   │   │   ├── tables.css
│   │   │   └── cards.css
│   │   ├── layouts/
│   │   │   └── main.css            ← Main layout
│   │   └── pages/
│   │       ├── dashboard.css
│   │       └── invoices.css
│   │
│   ├── js/
│   │   ├── lib/
│   │   │   └── utils.js            ← Utilities
│   │   ├── components/
│   │   │   ├── table.js
│   │   │   ├── form.js
│   │   │   └── modal.js
│   │   └── pages/
│   │       ├── dashboard.js
│   │       └── invoices.js
│   │
│   └── images/
│       ├── logo/
│       ├── icons/
│       └── backgrounds/
```

---

## 🚀 Implementation Guide

### Step 1: Include CSS
```html
<link rel="stylesheet" href="/testfinal/public/assets/css/base/variables.css">
<link rel="stylesheet" href="/testfinal/public/assets/css/layouts/main.css">
```

### Step 2: Include JavaScript
```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
<script src="/testfinal/public/assets/js/lib/utils.js"></script>
<script src="/testfinal/public/assets/js/main.js"></script>
```

### Step 3: Use Components
```html
<!-- Use modern components in your views -->
<button class="btn btn-primary">Click me</button>
<div class="card"><div class="card-body">Content</div></div>
```

### Step 4: Add JavaScript
```javascript
// Use utility functions
Notify.success('Success message');
API.post('/api/users', data);
Validate.email('test@example.com');
```

---

## 🛠️ JavaScript Utilities

### API Requests
```javascript
// GET request
const data = await API.get('/api/users');

// POST request
const result = await API.post('/api/users', { name: 'John' });

// PUT request
await API.put('/api/users/1', { name: 'Jane' });

// DELETE request
await API.delete('/api/users/1');
```

### Notifications
```javascript
Notify.success('Thành công!');
Notify.error('Có lỗi!');
Notify.warning('Cảnh báo!');
Notify.info('Thông tin');
```

### Form Validation
```javascript
Validate.email('test@example.com')      // true/false
Validate.required('text')                // true/false
Validate.minLength('password', 8)       // true/false
Validate.phone('+84901234567')          // true/false
Validate.number('123')                   // true/false
```

### DOM Manipulation
```javascript
DOM.get('.selector')                    // querySelector
DOM.getAll('.selector')                 // querySelectorAll
DOM.addClass(element, 'class')          // Add class
DOM.removeClass(element, 'class')       // Remove class
DOM.setText(element, 'text')            // Set text
DOM.getValue(input)                     // Get input value
DOM.show(element)                       // Show element
DOM.hide(element)                       // Hide element
```

### Form Helpers
```javascript
// Get all form data
const data = Form.getData('#myForm');

// Set validation errors
Form.setErrors('#myForm', { 
    email: 'Email không hợp lệ',
    phone: 'Số điện thoại không hợp lệ'
});

// Clear errors
Form.clearErrors('#myForm');
```

---

## 📊 Usage Examples

### Example 1: Dashboard Page
```php
<?php include 'layouts/modern.php'; ?>

<div class="page-header">
    <h1>Dashboard</h1>
    <p class="text-muted">Chào mừng trở lại</p>
</div>

<div class="cards-grid">
    <div class="stat-card">
        <div class="stat-card-icon primary">📊</div>
        <div>
            <div class="stat-card-value">150</div>
            <div class="stat-card-label">Sinh viên</div>
        </div>
    </div>
    <!-- More stat cards -->
</div>
```

### Example 2: Form Page
```php
<form id="editForm">
    <div class="form-group">
        <label for="name">Tên phòng</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="type">Loại phòng</label>
        <select id="type" name="type" class="form-select" required>
            <option value="">-- Chọn loại --</option>
            <option value="standard">Standard</option>
            <option value="deluxe">Deluxe</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Lưu</button>
    <button type="button" class="btn btn-secondary">Hủy</button>
</form>

<script>
    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Form.getData('#editForm');
        
        try {
            await API.post('/api/rooms', data);
            Notify.success('Tạo thành công');
        } catch (error) {
            Notify.error('Lỗi: ' + error.message);
        }
    });
</script>
```

### Example 3: Data Table
```php
<div class="table-container">
    <table class="table" id="roomsTable">
        <thead>
            <tr>
                <th>Phòng</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>
</div>

<script>
    // Load table data
    async function loadTable() {
        const data = await API.get('/api/rooms');
        const tbody = document.getElementById('tableBody');
        
        tbody.innerHTML = data.map(room => `
            <tr>
                <td>${room.room_number}</td>
                <td><span class="badge badge-info">${room.type}</span></td>
                <td>${String.formatCurrency(room.price)}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editRoom(${room.id})">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteRoom(${room.id})">
                        Delete
                    </button>
                </td>
            </tr>
        `).join('');
    }
    
    loadTable();
</script>
```

---

## ✅ Checklist for New Pages

- [ ] Use modern.php layout
- [ ] Include CSS variables
- [ ] Use responsive grid system
- [ ] Add proper form validation
- [ ] Include success/error alerts
- [ ] Use semantic HTML
- [ ] Test on mobile devices
- [ ] Add proper labels and placeholder text
- [ ] Implement loading states
- [ ] Add keyboard navigation support

---

## 📚 Resources

- Bootstrap 5: https://getbootstrap.com
- Tabler Icons: https://tabler-icons.io
- Axios: https://axios-http.com
- CSS Variables: https://developer.mozilla.org/en-US/docs/Web/CSS/--*

---

**Status**: ✅ Complete  
**Last Updated**: 2026-06-08  
**Created by**: KTX Development Team
