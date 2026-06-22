<?php /** app/views/home/about.php */ ?>

<div class="landing">

  <section class="landing-hero landing-section">
    <div class="landing-container" style="text-align:center">
      <div class="landing-eyebrow" style="margin-inline:auto">
        <span class="landing-eyebrow-dot"></span>
        Về chúng tôi
      </div>
      <h1 class="landing-title" style="max-width:640px;margin-inline:auto">KTX Management<br><em>System</em></h1>
      <p class="landing-lead" style="margin-inline:auto">
        Giải pháp quản lý ký túc xá thông minh — kiến tạo không gian sống tiện nghi, hiện đại và kết nối cho cộng đồng sinh viên.
      </p>
    </div>
  </section>

  <section class="landing-section" style="padding-top:0">
    <div class="landing-container">
      <div class="landing-split">
        <div>
          <h2 class="landing-split-title">Tầm nhìn &amp; Sứ mệnh</h2>
          <p class="landing-split-text">
            Chúng tôi xây dựng KTX System nhằm giải quyết các rào cản trong quy trình quản lý vận hành truyền thống — từ đăng ký phòng, hợp đồng đến thanh toán điện nước.
          </p>
          <p class="landing-split-text">
            Ban quản lý tối ưu hiệu suất vận hành, giảm thủ tục giấy tờ. Sinh viên trải nghiệm dịch vụ trực quan, nhanh chóng và minh bạch ngay trên điện thoại hoặc máy tính.
          </p>
        </div>
        <div class="landing-features-grid" style="grid-template-columns:1fr;gap:16px">
          <article class="landing-feature landing-feature--plain"><h3>An toàn &amp; Bảo mật</h3><p>Dữ liệu cá nhân, lịch sử thanh toán và hợp đồng được bảo vệ nghiêm ngặt.</p></article>
          <article class="landing-feature landing-feature--plain"><h3>Tiện lợi &amp; Nhanh chóng</h3><p>Mọi thủ tục đăng ký, khiếu nại và thanh toán thực hiện trực tuyến.</p></article>
          <article class="landing-feature landing-feature--plain"><h3>Trực quan &amp; Minh bạch</h3><p>Theo dõi chi tiết điện, nước, hóa đơn và lịch sử vi phạm rõ ràng.</p></article>
        </div>
      </div>
    </div>
  </section>

  <section class="landing-features landing-section">
    <div class="landing-container">
      <div class="landing-section-head">
        <h2>Công nghệ sử dụng</h2>
        <p>Kiến trúc MVC vững chắc trên nền tảng PHP thuần, tối ưu hiệu năng.</p>
      </div>
      <div class="landing-features-grid">
        <article class="landing-feature landing-feature--plain"><h3>PHP 8.x</h3><p>OOP / MVC Custom — kiến trúc rõ ràng, dễ mở rộng.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>MySQL</h3><p>PDO, triggers và schema chuẩn hóa cho dữ liệu nhất quán.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Vanilla CSS</h3><p>Giao diện responsive, không phụ thuộc framework nặng.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Fetch API</h3><p>Tương tác AJAX mượt mà cho các thao tác CRUD và thông báo.</p></article>
      </div>
    </div>
  </section>

  <section class="landing-cta landing-section">
    <div class="landing-container">
      <div class="landing-section-head">
        <h2>Khám phá hệ thống</h2>
        <p>Trải nghiệm đầy đủ tính năng quản lý ký túc xá thông minh.</p>
        <a href="<?= getDynamicUrl('/auth/login') ?>" class="landing-btn landing-btn-primary">Đăng nhập</a>
      </div>
    </div>
  </section>

</div>
