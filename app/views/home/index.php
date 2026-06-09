<?php
/**
 * app/views/home/index.php
 * Landing page — public, no auth required
 */
?>
<div class="home-layout">

<!-- Navigation -->
<nav class="home-nav">
    <a href="<?= getDynamicUrl('/') ?>" class="home-nav-logo">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
        </div>
        <span>KTX System</span>
    </a>
    <div class="home-nav-links">
        <a href="#features"><span class="nav-link-text">Tính năng</span></a>
        <a href="<?= getDynamicUrl('/about') ?>"><span class="nav-link-text">Giới thiệu</span></a>
        <?php if (!empty($_auth)): ?>
            <a href="<?= getDynamicUrl($_auth['role'] === 'admin' ? '/admin/dashboard' : '/student/dashboard') ?>" class="btn btn-primary btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                <span>Dashboard</span>
            </a>
        <?php else: ?>
            <a href="<?= getDynamicUrl('/auth/login') ?>" class="btn btn-primary btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                <span>Đăng nhập</span>
            </a>
        <?php endif; ?>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero glass">
    <!-- Floating decorative shapes -->
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>

    <div class="hero-content">
        <h1>Hệ thống quản lý<br><span>Ký túc xá thông minh</span></h1>
        <p>Quản lý phòng ở, hợp đồng, hóa đơn và vi phạm một cách hiệu quả, minh bạch và tiện lợi cho sinh viên và ban quản lý.</p>
        <div class="hero-btns">
            <a href="<?= getDynamicUrl('/auth/login') ?>" class="hero-btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Đăng nhập
            </a>
            <a href="#features" class="hero-btn-outline">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Tìm hiểu thêm
            </a>
        </div>

        <!-- Stats row -->
        <div class="grid grid-cols-3" style="margin-top:48px;">
            <div class="stat-item">
                <div class="stat-value" data-count="500">0</div>
                <div class="stat-label">Sinh viên</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" data-count="120">0</div>
                <div class="stat-label">Phòng ở</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" data-count="98">0</div>
                <div class="stat-label">% Hài lòng</div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features" id="features" style="background:var(--page-bg)">
    <div style="text-align:center;margin-bottom:48px">
        <h2 style="font-size:30px;font-weight:900;letter-spacing:-.8px" class="gradient-text">Tính năng nổi bật</h2>
        <p style="color:var(--txt-muted);margin-top:10px;font-size:15px;max-width:480px;margin-left:auto;margin-right:auto">Tất cả những gì bạn cần để quản lý ký túc xá hiện đại, hiệu quả và chuyên nghiệp</p>
    </div>

    <div class="features-grid">

        <div class="feature-card animate-on-scroll" data-animate="fade-in-up">
            <div class="feature-icon" style="background:#eef2ff;color:#6366f1">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <h3>Quản lý phòng ở</h3>
            <p>Theo dõi tình trạng phòng, sức chứa, trang thiết bị theo thời gian thực. Hỗ trợ nhiều loại phòng: standard, deluxe, có điều hòa.</p>
        </div>

        <div class="feature-card animate-on-scroll" data-animate="fade-in-up">
            <div class="feature-icon" style="background:#d1fae5;color:#10b981">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <h3>Hóa đơn tự động</h3>
            <p>Tự động tính tiền phòng, điện, nước theo chỉ số thực tế hàng tháng. Hỗ trợ nhiều phương thức thanh toán.</p>
        </div>

        <div class="feature-card animate-on-scroll" data-animate="fade-in-up">
            <div class="feature-icon" style="background:#fee2e2;color:#ef4444">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <h3>Theo dõi vi phạm</h3>
            <p>Hệ thống điểm vi phạm tự động. Khi vượt ngưỡng, hợp đồng chuyển sang trạng thái "đang xem xét". Sinh viên có thể khiếu nại trực tuyến.</p>
        </div>

        <div class="feature-card animate-on-scroll" data-animate="fade-in-up">
            <div class="feature-icon" style="background:#cffafe;color:#06b6d4">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <h3>Hợp đồng số</h3>
            <p>Quản lý hợp đồng thuê phòng từ A đến Z. Tạo hợp đồng khi duyệt đăng ký, theo dõi ngày hết hạn, chấm dứt hợp đồng có ghi nhận lý do.</p>
        </div>

        <div class="feature-card animate-on-scroll" data-animate="fade-in-up">
            <div class="feature-icon" style="background:#fef3c7;color:#f59e0b">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            </div>
            <h3>Quản lý bảo trì</h3>
            <p>Sinh viên báo cáo sự cố phòng trực tuyến. Quản lý theo dõi và cập nhật trạng thái xử lý theo mức độ ưu tiên.</p>
        </div>

        <div class="feature-card animate-on-scroll" data-animate="fade-in-up">
            <div class="feature-icon" style="background:#ede9fe;color:#8b5cf6">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <h3>Thông báo realtime</h3>
            <p>Nhận thông báo tức thì khi đăng ký được duyệt, hóa đơn mới, vi phạm ghi nhận, hay hợp đồng sắp hết hạn.</p>
        </div>

    </div>
</div>

<!-- CTA Banner -->
<div class="cta-banner glass">
    <!-- Decorative gradient -->
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at center,rgba(99,102,241,.15),transparent 70%);pointer-events:none"></div>
    <div style="position:relative;z-index:1">
        <h2 style="font-size:28px;font-weight:900;margin-bottom:14px;letter-spacing:-.5px">Sẵn sàng bắt đầu?</h2>
        <p style="color:rgba(255,255,255,.5);margin-bottom:32px;font-size:15px;max-width:400px;margin-left:auto;margin-right:auto">Đăng nhập để truy cập hệ thống quản lý ký túc xá thông minh và hiện đại</p>
        <a href="<?= getDynamicUrl('/auth/login') ?>" class="hero-btn-primary" style="text-decoration:none">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
            Đăng nhập ngay
        </a>
    </div>
</div>

<!-- Footer -->
<div style="background:var(--card-bg);padding:24px;text-align:center;border-top:1px solid var(--border)">
    <p style="font-size:13px;color:var(--txt-muted)">
        © <?= date('Y') ?> KTX Management System. Được phát triển bởi nhóm sinh viên CNTT.
    </p>
</div>

</div>
