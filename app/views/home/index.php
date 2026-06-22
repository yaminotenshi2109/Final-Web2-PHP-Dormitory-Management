<?php
/**
 * app/views/home/index.php — Minimal landing page
 */
$isAuth = !empty($_auth);
$dashUrl = $isAuth
    ? getDynamicUrl($_auth['role'] === 'admin' ? '/admin/dashboard' : '/student/dashboard')
    : '';
$roleLabel = $isAuth
    ? ($_auth['role'] === 'admin' ? 'Quản trị viên' : 'Sinh viên')
    : '';
?>

<div class="landing">

  <section class="landing-hero landing-section">
    <div class="landing-container">
      <div class="landing-hero-grid <?= $isAuth ? '' : 'is-centered' ?>">
        <div class="landing-hero-copy">
          <div class="landing-eyebrow">
            <span class="landing-eyebrow-dot"></span>
            KTX Management System
          </div>
          <h1 class="landing-title">Quản lý ký túc xá<br><em>đơn giản &amp; minh bạch</em></h1>
          <p class="landing-lead">
            Theo dõi phòng ở, hợp đồng, hóa đơn điện nước và vi phạm — tất cả trong một nền tảng dành cho sinh viên và ban quản lý.
          </p>
          <div class="landing-actions">
            <?php if ($isAuth): ?>
              <a href="<?= $dashUrl ?>" class="landing-btn landing-btn-primary">Vào trang quản lý</a>
            <?php else: ?>
              <a href="<?= getDynamicUrl('/auth/login') ?>" class="landing-btn landing-btn-primary">Đăng nhập</a>
            <?php endif; ?>
            <a href="#features" class="landing-btn landing-btn-ghost">Xem tính năng</a>
          </div>
        </div>

        <?php if ($isAuth): ?>
          <div class="landing-welcome-card">
            <h3>Chào mừng trở lại</h3>
            <p>Bạn đang đăng nhập với vai trò <span class="landing-welcome-role"><?= htmlspecialchars($roleLabel) ?></span></p>
            <a href="<?= $dashUrl ?>" class="landing-btn landing-btn-primary" style="width:100%">Tiếp tục làm việc</a>
          </div>
        <?php else: ?>
          <div class="landing-preview" aria-hidden="true">
            <div class="landing-preview-bar">
              <span class="landing-preview-dot"></span>
              <span class="landing-preview-dot"></span>
              <span class="landing-preview-dot"></span>
            </div>
            <div class="landing-preview-body">
              <div class="landing-preview-stat-row">
                <div class="landing-preview-stat"><strong>240</strong><span>Phòng ở</span></div>
                <div class="landing-preview-stat"><strong>95%</strong><span>Lấp đầy</span></div>
                <div class="landing-preview-stat"><strong>800+</strong><span>Sinh viên</span></div>
              </div>
              <div class="landing-preview-chart"></div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="landing-stats">
    <div class="landing-stats-row">
      <div class="landing-stat"><span class="landing-stat-value">240+</span><span class="landing-stat-label">Phòng ở tiện nghi</span></div>
      <div class="landing-stat"><span class="landing-stat-value">95%</span><span class="landing-stat-label">Tỷ lệ lấp đầy</span></div>
      <div class="landing-stat"><span class="landing-stat-value">800+</span><span class="landing-stat-label">Sinh viên lưu trú</span></div>
    </div>
  </section>

  <section class="landing-features landing-section" id="features">
    <div class="landing-container">
      <div class="landing-section-head">
        <h2>Tính năng cốt lõi</h2>
        <p>Mọi quy trình quản lý ký túc xá được tích hợp gọn gàng trên một giao diện thống nhất.</p>
      </div>
      <div class="landing-features-grid">
        <article class="landing-feature landing-feature--plain"><h3>Quản lý phòng ở</h3><p>Theo dõi tình trạng phòng, sức chứa và trang thiết bị theo thời gian thực.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Hóa đơn tự động</h3><p>Tính tiền phòng, điện, nước theo chỉ số thực tế và lưu trữ lịch sử thanh toán.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Theo dõi vi phạm</h3><p>Ghi nhận điểm vi phạm nội quy và cho phép sinh viên khiếu nại trực tuyến.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Hợp đồng số</h3><p>Tạo hợp đồng tự động khi duyệt đăng ký và theo dõi ngày hết hạn, gia hạn.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Quản lý bảo trì</h3><p>Sinh viên gửi yêu cầu sửa chữa; ban quản lý phân loại và xử lý theo mức ưu tiên.</p></article>
        <article class="landing-feature landing-feature--plain"><h3>Thông báo tức thì</h3><p>Nhận cập nhật khi đăng ký được duyệt, có hóa đơn mới hoặc sắp hết hạn hợp đồng.</p></article>
      </div>
    </div>
  </section>

  <section class="landing-calc landing-section" id="estimator">
    <div class="landing-container">
      <div class="landing-section-head">
        <h2>Ước tính chi phí thuê phòng</h2>
        <p>Chọn loại phòng và mức sử dụng điện nước để dự tính chi phí hàng tháng.</p>
      </div>
      <div class="landing-calc-card">
        <div class="landing-calc-form">
          <h3>Tùy chọn phòng</h3>
          <div class="landing-field">
            <label for="roomType">Loại phòng</label>
            <select id="roomType" onchange="calculateCost()">
              <option value="1500000">Standard — 1.500.000đ/tháng</option>
              <option value="2200000">Deluxe — 2.200.000đ/tháng</option>
            </select>
          </div>
          <div class="landing-field">
            <label class="landing-checkbox"><input type="checkbox" id="hasAC" onchange="calculateCost()">
              <span>Điều hòa nhiệt độ (+300.000đ/tháng)</span>
            </label>
          </div>
          <div class="landing-field">
            <label for="elecUse">Điện tiêu thụ (kWh/tháng)</label>
            <input type="number" id="elecUse" min="0" value="60" oninput="calculateCost()">
            <span class="landing-field-hint">Đơn giá: 3.500đ/kWh</span>
          </div>
          <div class="landing-field">
            <label for="waterUse">Nước sử dụng (m³/tháng)</label>
            <input type="number" id="waterUse" min="0" value="6" oninput="calculateCost()">
            <span class="landing-field-hint">Đơn giá: 15.000đ/m³</span>
          </div>
        </div>
        <div class="landing-calc-result">
          <span class="landing-calc-total-label">Tổng phí dự kiến / tháng</span>
          <div class="landing-calc-total" id="totalDisplay">1.500.000đ</div>
          <div class="landing-calc-breakdown">
            <div class="landing-calc-line"><span>Phòng</span><strong id="roomCostDisplay">1.500.000đ</strong></div>
            <div class="landing-calc-line"><span>Điều hòa</span><strong id="acCostDisplay">0đ</strong></div>
            <div class="landing-calc-line"><span>Điện</span><strong id="elecCostDisplay">0đ</strong></div>
            <div class="landing-calc-line"><span>Nước</span><strong id="waterCostDisplay">0đ</strong></div>
          </div>
          <p class="landing-calc-note">* Mức ước lượng tham khảo. Chỉ số thực tế sẽ được ghi nhận và xuất hóa đơn cuối tháng.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="landing-cta landing-section">
    <div class="landing-container">
      <div class="landing-section-head">
        <?php if ($isAuth): ?>
          <h2>Sẵn sàng quản lý</h2>
          <p>Truy cập bảng điều khiển để theo dõi phòng ở, hóa đơn và hợp đồng của bạn.</p>
          <a href="<?= $dashUrl ?>" class="landing-btn landing-btn-primary">Vào trang quản lý</a>
        <?php else: ?>
          <h2>Bắt đầu ngay hôm nay</h2>
          <p>Đăng nhập để trải nghiệm đầy đủ hệ thống quản lý ký túc xá thông minh.</p>
          <a href="<?= getDynamicUrl('/auth/login') ?>" class="landing-btn landing-btn-primary">Đăng nhập hệ thống</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

</div>

<script>
function calculateCost() {
  const roomBase = parseFloat(document.getElementById('roomType').value);
  const acFee = document.getElementById('hasAC').checked ? 300000 : 0;
  const elecCost = (parseFloat(document.getElementById('elecUse').value) || 0) * 3500;
  const waterCost = (parseFloat(document.getElementById('waterUse').value) || 0) * 15000;
  const total = roomBase + acFee + elecCost + waterCost;
  const fmt = (val) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val).replace(/₫/g, 'đ').trim();
  document.getElementById('roomCostDisplay').textContent = fmt(roomBase);
  document.getElementById('acCostDisplay').textContent = fmt(acFee);
  document.getElementById('elecCostDisplay').textContent = fmt(elecCost);
  document.getElementById('waterCostDisplay').textContent = fmt(waterCost);
  document.getElementById('totalDisplay').textContent = fmt(total);
}
document.addEventListener('DOMContentLoaded', calculateCost);
</script>
