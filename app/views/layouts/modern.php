<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hệ thống quản lý ký túc xá KTX - quản lý sinh viên, phòng, hóa đơn, vi phạm">
    <meta name="theme-color" content="#185FA5">
    
    <title><?= $pageTitle ?? 'KTX Management System' ?></title>
    
    <!-- ── CSS ──────────────────────────────────────────── -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/1.110.0/tabler-icons.min.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="/Final-Web2-PHP-Dormitory-Management/public/assets/css/base/variables.css">
    <link rel="stylesheet" href="/Final-Web2-PHP-Dormitory-Management/public/assets/css/layouts/main.css">
    <?= $additionalCSS ?? '' ?>
</head>
<body>
    <!-- ┌──────────────────────────────────────────────┐ -->
    <!-- │ NAVBAR / HEADER                              │ -->
    <!-- └──────────────────────────────────────────────┘ -->
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/Final-Web2-PHP-Dormitory-Management/public/">
                <i class="ti ti-building-community me-2" style="font-size: 24px;"></i>
                <span class="fw-bold">KTX System</span>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Nav Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($this->auth()): ?>
                        <li class="nav-item">
                            <span class="navbar-text text-white me-3">
                                👤 <?= htmlspecialchars($this->auth('username') ?? 'User') ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="/Final-Web2-PHP-Dormitory-Management/public/logout" method="POST" style="display: inline;">
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="ti ti-logout me-1"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/Final-Web2-PHP-Dormitory-Management/public/auth/login">Đăng nhập</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ┌──────────────────────────────────────────────┐ -->
    <!-- │ MAIN CONTENT AREA                             │ -->
    <!-- └──────────────────────────────────────────────┘ -->
    
    <div class="page-wrapper">
        <?php if ($this->auth()): ?>
            <!-- ── Sidebar (for authenticated users) ──── -->
            <aside class="sidebar">
                <?php if ($this->auth('role') === 'admin'): ?>
                    <!-- ADMIN SIDEBAR -->
                    <div class="sidebar-menu">
                        <div class="sidebar-header mb-3">
                            <h5 class="mb-0">Admin Panel</h5>
                        </div>
                        
                        <nav class="nav flex-column">
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/dashboard" class="nav-link">
                                <i class="ti ti-dashboard"></i> Dashboard
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/buildings" class="nav-link">
                                <i class="ti ti-building"></i> Tòa nhà
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/rooms" class="nav-link">
                                <i class="ti ti-door"></i> Phòng
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/students" class="nav-link">
                                <i class="ti ti-users"></i> Sinh viên
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations" class="nav-link">
                                <i class="ti ti-clipboard-list"></i> Đăng ký phòng
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/contracts" class="nav-link">
                                <i class="ti ti-file-text"></i> Hợp đồng
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices" class="nav-link">
                                <i class="ti ti-receipt"></i> Hóa đơn
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/utilities" class="nav-link">
                                <i class="ti ti-zap"></i> Tiện ích
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/violations" class="nav-link">
                                <i class="ti ti-alert-circle"></i> Vi phạm
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/maintenance" class="nav-link">
                                <i class="ti ti-tool"></i> Bảo trì
                            </a>
                        </nav>
                    </div>
                <?php else: ?>
                    <!-- STUDENT SIDEBAR -->
                    <div class="sidebar-menu">
                        <div class="sidebar-header mb-3">
                            <h5 class="mb-0">Sinh viên</h5>
                        </div>
                        
                        <nav class="nav flex-column">
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/dashboard" class="nav-link">
                                <i class="ti ti-dashboard"></i> Dashboard
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/registrations" class="nav-link">
                                <i class="ti ti-door"></i> Phòng của tôi
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/contracts" class="nav-link">
                                <i class="ti ti-file-text"></i> Hợp đồng
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/invoices" class="nav-link">
                                <i class="ti ti-receipt"></i> Hóa đơn
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/maintenance" class="nav-link">
                                <i class="ti ti-tool"></i> Bảo trì
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/violations" class="nav-link">
                                <i class="ti ti-alert-circle"></i> Vi phạm
                            </a>
                            <a href="/Final-Web2-PHP-Dormitory-Management/public/student/profile" class="nav-link">
                                <i class="ti ti-user"></i> Hồ sơ
                            </a>
                        </nav>
                    </div>
                <?php endif; ?>
            </aside>
        <?php endif; ?>

        <!-- ── Main Content ──────────────────────── -->
        <main class="main-content">
            <!-- Breadcrumb -->
            <?php if ($breadcrumb ?? false): ?>
                <nav class="breadcrumb-nav mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/Final-Web2-PHP-Dormitory-Management/public/">Home</a></li>
                            <?php foreach ($breadcrumb as $link => $label): ?>
                                <li class="breadcrumb-item active"><?= $label ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>
                </nav>
            <?php endif; ?>

            <!-- Alerts -->
            <?php if ($success ?? false): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check"></i> <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error ?? false): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle"></i> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="page-content">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>

    <!-- ┌──────────────────────────────────────────────┐ -->
    <!-- │ FOOTER                                       │ -->
    <!-- └──────────────────────────────────────────────┘ -->
    
    <footer class="bg-light border-top mt-4 py-3">
        <div class="container-fluid text-center">
            <p class="text-muted mb-0">
                &copy; 2026 KTX Management System | 
                <a href="#" class="text-decoration-none">Privacy</a> |
                <a href="#" class="text-decoration-none">Terms</a>
            </p>
        </div>
    </footer>

    <!-- ── JS ──────────────────────────────────────────── -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="/Final-Web2-PHP-Dormitory-Management/public/assets/js/lib/utils.js"></script>
    <script src="/Final-Web2-PHP-Dormitory-Management/public/assets/js/main.js"></script>
    <?= $additionalJS ?? '' ?>
</body>
</html>
