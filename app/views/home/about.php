<?php
/**
 * app/views/home/about.php
 * About Page — public, no auth required
 */
?>

<div class="home-layout" style="background: var(--page-bg); padding-top: 80px;">

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
          <a href="<?= getDynamicUrl('/#features') ?>"><span class="nav-link-text">Tính năng</span></a>
          <a href="<?= getDynamicUrl('/about') ?>"><span class="nav-link-text" style="color:#fff">Giới thiệu</span></a>
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
  <div class="hero" style="min-height: 35vh; padding: 60px 24px; display: flex; align-items: center; justify-content: center;">
    <div class="hero-shape hero-shape-1" style="width: 200px; height: 200px;"></div>
    <div class="hero-shape hero-shape-2" style="width: 150px; height: 150px;"></div>
    <div class="hero-content" style="max-width: 800px; text-align: center; position: relative; z-index: 2;">
      <h1 style="font-size: 36px; font-weight: 900; line-height: 1.2; letter-spacing: -1px; margin-bottom: 12px;">Về chúng tôi<br><span style="background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">KTX Management System</span></h1>
      <p style="font-size: 15px; opacity: 0.85; max-width: 600px; margin: 0 auto; color: rgba(255,255,255,0.75);">Dự án quản lý ký túc xá thông minh, kiến tạo không gian sống tiện nghi, hiện đại và kết nối cho cộng đồng sinh viên.</p>
    </div>
  </div>

  <!-- Main Section -->
  <div style="max-width: 1100px; margin: 0 auto; padding: 60px 24px;">
    <div class="grid-2" style="gap: 48px; align-items: center; margin-bottom: 60px;">
      <div class="animate-on-scroll">
        <h2 style="font-size: 26px; font-weight: 800; color: var(--txt-primary); margin-bottom: 20px; letter-spacing: -0.5px;">Tầm nhìn & Sứ mệnh</h2>
        <p style="color: var(--txt-secondary); line-height: 1.7; margin-bottom: 16px; font-size: 14.5px;">
          Chúng tôi xây dựng giải pháp phần mềm quản lý ký túc xá KTX System nhằm giải quyết triệt để các rào cản và khó khăn trong quy trình quản lý vận hành truyền thống.
        </p>
        <p style="color: var(--txt-secondary); line-height: 1.7; font-size: 14.5px;">
          Nhờ ứng dụng chuyển đổi số toàn diện, ban quản lý có thể tối ưu hóa hiệu suất vận hành, giảm bớt thủ tục giấy tờ, trong khi sinh viên được trải nghiệm các dịch vụ đăng ký phòng, theo dõi hợp đồng, thanh toán hóa đơn điện nước và gửi phản ánh sự cố một cách trực quan, nhanh chóng, minh bạch.
        </p>
      </div>

      <div class="card animate-on-scroll" style="background: var(--card-bg); border: 1px solid var(--border); padding: 32px; display: flex; flex-direction: column; gap: 24px; box-shadow: var(--shadow-md); border-radius: var(--radius-lg);">
        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(99, 102, 241, 0.1); color: var(--brand); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: var(--txt-primary); font-size: 15px;">An toàn & Bảo mật</h4>
            <p style="color: var(--txt-muted); font-size: 13.5px; margin-top: 4px; line-height: 1.5;">Dữ liệu cá nhân, lịch sử đóng tiền và thông tin hợp đồng được mã hóa bảo mật tuyệt đối.</p>
          </div>
        </div>

        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: var(--txt-primary); font-size: 15px;">Tiện lợi & Nhanh chóng</h4>
            <p style="color: var(--txt-muted); font-size: 13.5px; margin-top: 4px; line-height: 1.5;">Thực hiện mọi thủ tục đăng ký, khiếu nại, thanh toán ngay trên điện thoại hoặc máy tính.</p>
          </div>
        </div>

        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(6, 182, 212, 0.1); color: #06b6d4; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <circle cx="12" cy="12" r="6"/>
              <circle cx="12" cy="12" r="2"/>
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: var(--txt-primary); font-size: 15px;">Trực quan & Minh bạch</h4>
            <p style="color: var(--txt-muted); font-size: 13.5px; margin-top: 4px; line-height: 1.5;">Theo dõi chi tiết các thông số điện, nước, hóa đơn, lịch sử vi phạm rõ ràng.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline Section -->
    <div style="margin: 80px 0 60px;">
      <div style="text-align: center; margin-bottom: 48px;">
        <h2 style="font-size: 26px; font-weight: 800; color: var(--txt-primary); letter-spacing: -0.5px;">Hành trình phát triển</h2>
        <p style="color: var(--txt-muted); font-size: 14.5px; margin-top: 8px;">Các cột mốc quan trọng trong quá trình hoàn thiện sản phẩm</p>
      </div>

      <div style="position: relative; max-width: 800px; margin: 0 auto; padding-left: 32px; border-left: 2px solid var(--border);">
        
        <div style="position: relative; margin-bottom: 40px;" class="animate-on-scroll">
          <div style="position: absolute; left: -41px; top: 4px; width: 16px; height: 16px; border-radius: 50%; background: var(--brand); border: 4px solid var(--page-bg); box-shadow: 0 0 0 4px var(--brand-glow);"></div>
          <div style="font-size: 12px; font-weight: 700; color: var(--brand); text-transform: uppercase; letter-spacing: 0.5px;">Giai đoạn 1</div>
          <h3 style="font-size: 17px; font-weight: 700; color: var(--txt-primary); margin-top: 4px;">Khảo sát & Phân tích nghiệp vụ</h3>
          <p style="color: var(--txt-secondary); font-size: 13.5px; margin-top: 8px; line-height: 1.6;">Khảo sát quy trình quản lý thực tế tại các Ký túc xá lớn, xác định các điểm nghẽn về giấy tờ và xây dựng kiến trúc dữ liệu chuẩn hóa hệ thống quản lý phòng, sinh viên và hóa đơn.</p>
        </div>

        <div style="position: relative; margin-bottom: 40px;" class="animate-on-scroll">
          <div style="position: absolute; left: -41px; top: 4px; width: 16px; height: 16px; border-radius: 50%; background: #10b981; border: 4px solid var(--page-bg); box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);"></div>
          <div style="font-size: 12px; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: 0.5px;">Giai đoạn 2</div>
          <h3 style="font-size: 17px; font-weight: 700; color: var(--txt-primary); margin-top: 4px;">Xây dựng Core Backend & Layout</h3>
          <p style="color: var(--txt-secondary); font-size: 13.5px; margin-top: 8px; line-height: 1.6;">Triển khai mô hình Custom MVC hướng đối tượng PHP thuần. Hoàn thiện các chức năng Admin CRUD phòng ở, người dùng, sinh viên, tạo hợp đồng tự động, xử lý hóa đơn định kỳ.</p>
        </div>

        <div style="position: relative;" class="animate-on-scroll">
          <div style="position: absolute; left: -41px; top: 4px; width: 16px; height: 16px; border-radius: 50%; background: #a855f7; border: 4px solid var(--page-bg); box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.25);"></div>
          <div style="font-size: 12px; font-weight: 700; color: #a855f7; text-transform: uppercase; letter-spacing: 0.5px;">Giai đoạn 3</div>
          <h3 style="font-size: 17px; font-weight: 700; color: var(--txt-primary); margin-top: 4px;">Tối ưu UI/UX & Dark Mode</h3>
          <p style="color: var(--txt-secondary); font-size: 13.5px; margin-top: 8px; line-height: 1.6;">Nâng cấp toàn diện giao diện với premium design system, bo góc, bóng mờ, glassmorphism và hỗ trợ Dark Mode tối ưu. Tích hợp Fetch API và hệ thống Toast notification không load lại trang.</p>
        </div>

      </div>
    </div>

    <hr style="border: 0; border-top: 1px solid var(--border); margin: 60px 0;">

    <!-- Tech Stack -->
    <div style="text-align: center; margin-bottom: 40px;">
      <h2 style="font-size: 26px; font-weight: 800; color: var(--txt-primary); letter-spacing: -0.5px;">Công nghệ sử dụng</h2>
      <p style="color: var(--txt-muted); font-size: 14.5px; margin-top: 8px;">Kiến trúc MVC vững chắc được xây dựng trên nền tảng tối ưu hiệu năng</p>
    </div>

    <div class="stat-grid animate-on-scroll" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
      <div class="stat-card" style="--stat-color:#eab308;--stat-icon-bg:rgba(234,179,8,0.1)">
        <div class="stat-icon" style="font-size: 20px; color:#eab308; display:flex; align-items:center; justify-content:center">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
            <line x1="4" y1="22" x2="4" y2="15"/>
          </svg>
        </div>
        <div>
          <div class="stat-value" style="font-size: 18px;">PHP 8.x</div>
          <div class="stat-label">OOP / MVC Custom</div>
        </div>
      </div>
      <div class="stat-card" style="--stat-color:#3b82f6;--stat-icon-bg:rgba(59,130,246,0.1)">
        <div class="stat-icon" style="font-size: 20px; color:#3b82f6; display:flex; align-items:center; justify-content:center">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <ellipse cx="12" cy="5" rx="9" ry="3"/>
            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
            <path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/>
          </svg>
        </div>
        <div>
          <div class="stat-value" style="font-size: 18px;">MySQL</div>
          <div class="stat-label">PDO / Triggers</div>
        </div>
      </div>
      <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:rgba(16,185,129,0.1)">
        <div class="stat-icon" style="font-size: 20px; color:#10b981; display:flex; align-items:center; justify-content:center">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
          </svg>
        </div>
        <div>
          <div class="stat-value" style="font-size: 18px;">CSS Glass</div>
          <div class="stat-label">Vanilla Responsive</div>
        </div>
      </div>
      <div class="stat-card" style="--stat-color:#a855f7;--stat-icon-bg:rgba(168,85,247,0.1)">
        <div class="stat-icon" style="font-size: 20px; color:#a855f7; display:flex; align-items:center; justify-content:center">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
            <polyline points="2 17 12 22 22 17"/>
            <polyline points="2 12 12 17 22 12"/>
          </svg>
        </div>
        <div>
          <div class="stat-value" style="font-size: 18px;">Fetch API</div>
          <div class="stat-label">SPA Elements & Modals</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div style="background:var(--card-bg);padding:24px;text-align:center;border-top:1px solid var(--border); transition: background-color var(--t), border-color var(--t);">
    <p style="font-size:13px;color:var(--txt-muted)">
      © <?= date('Y') ?> KTX Management System. Được phát triển bởi nhóm sinh viên CNTT.
    </p>
  </div>
</div>
