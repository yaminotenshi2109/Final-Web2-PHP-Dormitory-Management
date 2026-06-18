<?php
/**
 * app/views/home/index.php
 * Redesigned Premium Landing Page — public, no auth required
 */
?>
<<<<<<< HEAD
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
=======
<style>
  /* Premium Landing Page Custom Styles */
  .landing-wrapper {
    --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .hero-section {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    color: white;
    padding: 90px 24px;
    position: relative;
    overflow: hidden;
  }
  
  .hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 30% 20%, rgba(99, 102, 241, 0.2) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 60%);
    pointer-events: none;
  }
  
  .hero-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 56px;
    align-items: center;
    position: relative;
    z-index: 2;
  }
  
  .hero-left {
    text-align: left;
  }
  
  .hero-left h1 {
    font-size: 46px;
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -1.5px;
    margin-bottom: 20px;
  }
  
  .hero-left h1 span {
    background: linear-gradient(135deg, #a5b4fc 0%, #c7d2fe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  .hero-left p {
    font-size: 17px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 36px;
    line-height: 1.65;
    max-width: 580px;
  }
  
  .hero-btns {
    display: flex;
    gap: 16px;
  }
  
  .btn-hero-primary {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff !important;
    padding: 14px 30px;
    border-radius: var(--radius);
    font-size: 14.5px;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
    transition: var(--transition-smooth);
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  
  .btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
  }
  
  .btn-hero-outline {
    background: transparent;
    color: rgba(255, 255, 255, 0.85) !important;
    padding: 14.5px 30px;
    border-radius: var(--radius);
    font-size: 14.5px;
    font-weight: 600;
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    transition: var(--transition-smooth);
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  
  .btn-hero-outline:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.4);
  }
  
  .hero-right {
    display: flex;
    justify-content: flex-end;
  }
  
  /* Glassmorphism demo login card */
  .demo-login-card {
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: var(--radius-lg);
    padding: 30px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
    color: #fff;
    text-align: left;
  }
  
  .demo-login-card h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
  }
  
  .demo-login-card p {
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.55);
    margin-bottom: 24px;
    line-height: 1.4;
  }
  
  .demo-login-btn {
    width: 100%;
    padding: 12px 16px;
    border-radius: var(--radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: var(--transition-smooth);
    margin-bottom: 12px;
    text-align: left;
  }
  
  .demo-login-btn:hover {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
  }
  
  .demo-login-btn.admin:hover {
    border-color: rgba(99, 102, 241, 0.5);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.25);
  }
  
  .demo-login-btn.student:hover {
    border-color: rgba(16, 185, 129, 0.5);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
  }
  
  .demo-login-btn .btn-icon {
    font-size: 22px;
    flex-shrink: 0;
  }
  
  .demo-login-btn .btn-info {
    display: flex;
    flex-direction: column;
    line-height: 1.35;
  }
  
  .demo-login-btn .btn-info strong {
    font-size: 13.5px;
    font-weight: 600;
  }
  
  .demo-login-btn .btn-info span {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.5);
  }
  
  /* Stats Section */
  .stats-section {
    background: #ffffff;
    padding: 44px 24px;
    border-bottom: 1px solid var(--border);
  }
  
  .stats-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
  }
  
  .stat-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px 24px;
    border-radius: var(--radius);
    background: var(--page-bg);
    border: 1px solid var(--border);
    transition: var(--transition-smooth);
  }
  
  .stat-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow);
  }
  
  .stat-item-icon {
    width: 52px;
    height: 52px;
    background: #fff;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: var(--shadow-sm);
  }
  
  .stat-item-info {
    display: flex;
    flex-direction: column;
  }
  
  .stat-item-num {
    font-size: 28px;
    font-weight: 800;
    color: var(--txt-primary);
    line-height: 1.1;
  }
  
  .stat-item-label {
    font-size: 12.5px;
    color: var(--txt-secondary);
    font-weight: 500;
  }
  
  /* Calculator Section */
  .calc-section {
    padding: 80px 24px;
    background: #f8fafc;
    border-bottom: 1px solid var(--border);
  }
  
  .calc-container {
    max-width: 960px;
    margin: 0 auto;
  }
  
  .calc-card {
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    overflow: hidden;
  }
  
  .calc-form {
    padding: 40px;
    border-right: 1px solid var(--border);
    text-align: left;
  }
  
  .calc-result {
    padding: 40px;
    background: #f1f5f9;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: left;
  }
  
  .calc-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--txt-primary);
    margin-bottom: 24px;
    letter-spacing: -0.3px;
  }
  
  .calc-group {
    margin-bottom: 20px;
  }
  
  .calc-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--txt-secondary);
  }
  
  .calc-select, .calc-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 14px;
    color: var(--txt-primary);
    background: #ffffff;
    outline: none;
    transition: var(--transition-smooth);
  }
  
  .calc-select:focus, .calc-input:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 3px var(--brand-glow);
  }
  
  .calc-checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
  }
  
  .calc-checkbox-group input {
    width: 18px;
    height: 18px;
    accent-color: var(--brand);
  }
  
  .result-header {
    border-bottom: 1px dashed var(--border);
    padding-bottom: 20px;
    margin-bottom: 20px;
  }
  
  .result-total {
    font-size: 32px;
    font-weight: 800;
    color: var(--brand);
    line-height: 1;
    margin-top: 8px;
  }
  
  .result-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  
  .result-item {
    display: flex;
    justify-content: space-between;
    font-size: 13.5px;
    color: var(--txt-secondary);
  }
  
  .result-item strong {
    color: var(--txt-primary);
  }
  
  /* Features section */
  .features-section {
    padding: 90px 24px;
    background: #ffffff;
    border-bottom: 1px solid var(--border);
  }
  
  .features-header {
    text-align: center;
    margin-bottom: 48px;
  }
  
  .features-header h2 {
    font-size: 28px;
    font-weight: 800;
    color: var(--txt-primary);
    letter-spacing: -0.5px;
  }
  
  .features-header p {
    color: var(--txt-muted);
    margin-top: 8px;
    font-size: 14.5px;
  }
  
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .feature-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 32px 28px;
    transition: var(--transition-smooth);
    text-align: left;
  }
  
  .feature-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
  }
  
  .feature-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 18px;
  }
  
  .feature-card h3 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--txt-primary);
  }
  
  .feature-card p {
    font-size: 13.5px;
    color: var(--txt-secondary);
    line-height: 1.65;
  }
  
  /* CTA section */
  .cta-section {
    background: linear-gradient(135deg, #0f172a, #1e1b4b);
    padding: 70px 24px;
    text-align: center;
    color: #fff;
  }
  
  .cta-content {
    max-width: 600px;
    margin: 0 auto;
  }
  
  .cta-content h2 {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 12px;
  }
  
  .cta-content p {
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: 30px;
    font-size: 14.5px;
    line-height: 1.6;
  }
  
  @media (max-width: 992px) {
    .hero-container {
      grid-template-columns: 1fr;
      gap: 48px;
      text-align: center;
    }
    
    .hero-left {
      text-align: center;
    }
    
    .hero-left p {
      margin: 0 auto 32px;
    }
    
    .hero-btns {
      justify-content: center;
    }
    
    .hero-right {
      justify-content: center;
    }
    
    .stats-container {
      grid-template-columns: 1fr;
      gap: 16px;
    }
    
    .calc-card {
      grid-template-columns: 1fr;
    }
    
    .calc-form {
      border-right: none;
      border-bottom: 1px solid var(--border);
      padding: 30px 20px;
    }
    
    .calc-result {
      padding: 30px 20px;
    }
  }
</style>

<div class="landing-wrapper">
  <!-- ┌──────────────────────────────────────────────┐ -->
  <!-- │ HERO SECTION                                 │ -->
  <!-- └──────────────────────────────────────────────┘ -->
  <section class="hero-section">
    <div class="hero-container">
      <div class="hero-left">
        <h1>Hệ thống quản lý<br><span>Ký túc xá thông minh</span></h1>
        <p>Quản lý phòng ở, hợp đồng, hóa đơn và vi phạm một cách hiệu quả, minh bạch và tiện lợi cho sinh viên và ban quản lý.</p>
        <div class="hero-btns">
          <a href="<?= getDynamicUrl('/auth/login') ?>" class="btn-hero-primary">🔐 Vào trang đăng nhập</a>
          <a href="#features" class="btn-hero-outline">📖 Tìm hiểu thêm</a>
        </div>
      </div>
      
      <div class="hero-right">
        <div class="demo-login-card">
          <h3>🚀 Trải nghiệm nhanh</h3>
          <p>Bấm chọn vai trò để tự động đăng nhập nhanh bằng tài khoản Demo:</p>
          
          <form id="demoLoginForm" method="POST" action="<?= getDynamicUrl('/auth/login') ?>">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
            <input type="hidden" name="email" id="demoEmail">
            <input type="hidden" name="password" id="demoPassword">
            
            <button type="button" class="demo-login-btn admin" onclick="submitDemo('admin@ktx.edu.vn', 'Admin@123')">
              <span class="btn-icon">🛡️</span>
              <div class="btn-info">
                <strong>Quản Trị Viên (Admin)</strong>
                <span>Duyệt đăng ký, hóa đơn, báo cáo</span>
              </div>
            </button>
            
            <button type="button" class="demo-login-btn student" onclick="submitDemo('student@ktx.edu.vn', 'Student@123')">
              <span class="btn-icon">🎓</span>
              <div class="btn-info">
                <strong>Sinh Viên (Student)</strong>
                <span>Đăng ký phòng, xem hóa đơn, bảo trì</span>
              </div>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ┌──────────────────────────────────────────────┐ -->
  <!-- │ STATS SECTION                                │ -->
  <!-- └──────────────────────────────────────────────┘ -->
  <section class="stats-section">
    <div class="stats-container">
      <div class="stat-item">
        <div class="stat-item-icon" style="color:#6366f1">🚪</div>
        <div class="stat-item-info">
          <span class="stat-item-num">240+</span>
          <span class="stat-item-label">Phòng ở tiện nghi</span>
        </div>
      </div>
      <div class="stat-item">
        <div class="stat-item-icon" style="color:#10b981">📈</div>
        <div class="stat-item-info">
          <span class="stat-item-num">95%</span>
          <span class="stat-item-label">Tỷ lệ lấp đầy</span>
        </div>
      </div>
      <div class="stat-item">
        <div class="stat-item-icon" style="color:#ef4444">🎓</div>
        <div class="stat-item-info">
          <span class="stat-item-num">800+</span>
          <span class="stat-item-label">Sinh viên lưu trú</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ┌──────────────────────────────────────────────┐ -->
  <!-- │ DYNAMIC ROOM CALCULATOR SECTION              │ -->
  <!-- └──────────────────────────────────────────────┘ -->
  <section class="calc-section" id="estimator">
    <div class="calc-container">
      <div class="calc-title" style="text-align:center; margin-bottom: 30px;">
        <h2 style="font-size:26px;font-weight:800;color:var(--txt-primary);letter-spacing:-.5px">Ước tính Chi phí Thuê phòng</h2>
        <p style="color:var(--txt-muted);font-size:14px;margin-top:6px;font-weight:400">Chọn loại phòng và nhu cầu sử dụng của bạn để dự tính chi phí hàng tháng</p>
      </div>
      
      <div class="calc-card">
        <div class="calc-form">
          <h3 class="calc-title">⚙️ Tùy chọn phòng ở</h3>
          
          <div class="calc-group">
            <label for="roomType">Loại phòng ở</label>
            <select id="roomType" class="calc-select" onchange="calculateCost()">
              <option value="1500000" data-name="Standard (Phòng Thường)">Standard - 1.500.000đ/tháng</option>
              <option value="2200000" data-name="Deluxe (Phòng Cao Cấp)">Deluxe - 2.200.000đ/tháng</option>
            </select>
          </div>
          
          <div class="calc-group">
            <div class="calc-checkbox-group">
              <input type="checkbox" id="hasAC" onchange="calculateCost()">
              <label for="hasAC" style="margin:0; cursor:pointer">❄️ Lắp điều hòa nhiệt độ (+300.000đ/tháng)</label>
            </div>
          </div>
          
          <div class="calc-group">
            <label for="elecUse">Lượng điện tiêu thụ ước lượng (kWh / tháng)</label>
            <input type="number" id="elecUse" class="calc-input" min="0" value="60" oninput="calculateCost()">
            <span class="form-hint">Đơn giá điện: 3.500đ / kWh</span>
          </div>
          
          <div class="calc-group">
            <label for="waterUse">Lượng nước sử dụng ước lượng (m³ / tháng)</label>
            <input type="number" id="waterUse" class="calc-input" min="0" value="6" oninput="calculateCost()">
            <span class="form-hint">Đơn giá nước: 15.000đ / m³</span>
          </div>
        </div>
        
        <div class="calc-result">
          <div class="result-header">
            <h3 class="calc-title" style="margin-bottom:8px">🧾 Tổng phí dự kiến</h3>
            <span style="font-size:12px; color:var(--txt-muted)">Chi phí tính trên 1 tháng sử dụng</span>
            <div class="result-total" id="totalDisplay">1.500.000đ</div>
          </div>
          
          <div class="result-list">
            <div class="result-item">
              <span>Phòng:</span>
              <strong id="roomCostDisplay">1.500.000đ</strong>
            </div>
            <div class="result-item">
              <span>Điều hòa:</span>
              <strong id="acCostDisplay">0đ</strong>
            </div>
            <div class="result-item">
              <span>Tiền điện dự kiến:</span>
              <strong id="elecCostDisplay">0đ</strong>
            </div>
            <div class="result-item">
              <span>Tiền nước dự kiến:</span>
              <strong id="waterCostDisplay">0đ</strong>
            </div>
          </div>
          
          <div style="margin-top:20px; font-size:11px; color:var(--txt-muted)">
            * Lưu ý: Đây chỉ là mức ước lượng dựa trên nhu cầu sử dụng cá nhân của bạn. Chỉ số thực tế sẽ được nhân viên ghi nhận và xuất hóa đơn vào cuối tháng.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ┌──────────────────────────────────────────────┐ -->
  <!-- │ FEATURES SECTION                             │ -->
  <!-- └──────────────────────────────────────────────┘ -->
  <section class="features-section" id="features">
    <div class="features-header">
      <h2>Tính năng nổi bật</h2>
      <p>Hệ thống KTX thông minh tích hợp công nghệ quản lý hiện đại</p>
    </div>
    
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon" style="background:#eef2ff;color:#6366f1">🚪</div>
        <h3>Quản lý phòng ở</h3>
        <p>Theo dõi tình trạng phòng, sức chứa, trang thiết bị theo thời gian thực. Hỗ trợ nhiều loại phòng: standard, deluxe, có điều hòa.</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon" style="background:#d1fae5;color:#10b981">🧾</div>
        <h3>Hóa đơn tự động</h3>
        <p>Tự động tính tiền phòng, điện, nước theo chỉ số thực tế hàng tháng. Hỗ trợ thanh toán nhanh chóng, an toàn và lưu trữ hóa đơn.</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon" style="background:#fee2e2;color:#ef4444">⚠️</div>
        <h3>Theo dõi vi phạm</h3>
        <p>Hệ thống ghi nhận điểm vi phạm nội quy tự động. Sinh viên có thể chủ động theo dõi và tiến hành khiếu nại trực tuyến.</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon" style="background:#cffafe;color:#06b6d4">📄</div>
        <h3>Hợp đồng số</h3>
        <p>Quản lý hợp đồng thuê phòng hiệu quả. Tạo hợp đồng tự động ngay khi duyệt đăng ký, theo dõi ngày hết hạn và lịch sử gia hạn.</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon" style="background:#fef3c7;color:#f59e0b">🔧</div>
        <h3>Quản lý bảo trì</h3>
        <p>Sinh viên gửi yêu cầu sửa chữa cơ sở vật chất bị hỏng hóc qua mạng. BQL phân loại mức độ ưu tiên xử lý nhanh chóng.</p>
      </div>

      <div class="feature-card">
        <div class="feature-icon" style="background:#ede9fe;color:#8b5cf6">🔔</div>
        <h3>Thông báo Realtime</h3>
        <p>Nhận thông báo tức thì khi đăng ký phòng được duyệt, có hóa đơn thanh toán mới, thông tin vi phạm, hoặc cảnh báo hết hạn hợp đồng.</p>
      </div>
    </div>
  </section>

  <!-- ┌──────────────────────────────────────────────┐ -->
  <!-- │ CTA BANNER SECTION                           │ -->
  <!-- └──────────────────────────────────────────────┘ -->
  <section class="cta-section">
    <div class="cta-content">
      <h2>Trải nghiệm hệ thống ngay hôm nay</h2>
      <p>Đăng nhập để bắt đầu trải nghiệm đầy đủ các tính năng quản lý Ký túc xá thông minh.</p>
      <a href="<?= getDynamicUrl('/auth/login') ?>" class="btn-hero-primary" style="text-decoration:none">
        🚀 Bắt đầu ngay
      </a>
    </div>
  </section>
</div>

<script>
  // Dynamic Demo Login Form Submissions
  function submitDemo(email, password) {
    document.getElementById('demoEmail').value = email;
    document.getElementById('demoPassword').value = password;
    document.getElementById('demoLoginForm').submit();
  }

  // Room Fee Estimator Calculation Logic
  function calculateCost() {
    // Inputs
    const roomBase = parseFloat(document.getElementById('roomType').value);
    const acChecked = document.getElementById('hasAC').checked;
    const elecKwh = parseFloat(document.getElementById('elecUse').value) || 0;
    const waterM3 = parseFloat(document.getElementById('waterUse').value) || 0;
    
    // Rates
    const acFee = acChecked ? 300000 : 0;
    const elecRate = 3500;
    const waterRate = 15000;
    
    // Sub-costs
    const elecCost = elecKwh * elecRate;
    const waterCost = waterM3 * waterRate;
    const total = roomBase + acFee + elecCost + waterCost;
    
    // Formatting Helper
    const formatCurrency = (val) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })
      .format(val)
      .replace(/₫/g, 'đ')
      .trim();
      
    // Update display
    document.getElementById('roomCostDisplay').textContent = formatCurrency(roomBase);
    document.getElementById('acCostDisplay').textContent = formatCurrency(acFee);
    document.getElementById('elecCostDisplay').textContent = formatCurrency(elecCost);
    document.getElementById('waterCostDisplay').textContent = formatCurrency(waterCost);
    document.getElementById('totalDisplay').textContent = formatCurrency(total);
  }
  
  // Run calculation once on load
  document.addEventListener('DOMContentLoaded', calculateCost);
</script>
>>>>>>> cab58fd2b4b300bab02822a36621ded10784ddfb
