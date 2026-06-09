<?php
/**
 * student/registrations/create.php — Tạo đơn đăng ký phòng
 * Variables: $title, $available_rooms[], $buildings[], $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">📋 Đăng ký phòng KTX</h1><p class="page-subtitle">Chọn phòng và gửi đơn đăng ký</p></div>
  <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="grid-2">
  <!-- Form -->
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin đăng ký</div></div>
    <div class="card-body">
      <form method="POST" action="<?= getDynamicUrl('/student/registrations') ?>">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

        <div class="form-group">
          <label class="form-label" for="building_id">Chọn tòa nhà <span class="req">*</span></label>
          <select id="building_id" name="building_id" class="form-control" required>
            <option value="">— Chọn tòa nhà —</option>
            <?php foreach ($buildings ?? [] as $bl): ?>
              <option value="<?= $bl['id'] ?>" <?= ($_old['building_id'] ?? '') == $bl['id'] ? 'selected' : '' ?>><?= htmlspecialchars($bl['name']) ?> (<?= ucfirst($bl['gender_type'] ?? '') ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="room_id">Chọn phòng <span class="req">*</span></label>
          <select id="room_id" name="room_id" class="form-control" required>
            <option value="">— Chọn phòng —</option>
            <?php foreach ($available_rooms ?? [] as $r): ?>
              <option value="<?= $r['id'] ?>" <?= ($_old['room_id'] ?? '') == $r['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($r['room_number']) ?> — Tầng <?= $r['floor'] ?? 0 ?> (<?= $r['current_occupants'] ?? 0 ?>/<?= $r['capacity'] ?? 0 ?>) — <?= number_format($r['price_per_month'] ?? 0, 0, ',', '.') ?>đ/tháng
              </option>
            <?php endforeach; ?>
          </select>
          <?php if (!empty($_errors['room_id'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['room_id']) ?></div><?php endif; ?>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="semester">Học kỳ <span class="req">*</span></label>
            <select id="semester" name="semester" class="form-control" required>
              <option value="1" <?= ($_old['semester'] ?? '') === '1' ? 'selected' : '' ?>>Học kỳ 1</option>
              <option value="2" <?= ($_old['semester'] ?? '') === '2' ? 'selected' : '' ?>>Học kỳ 2</option>
              <option value="3" <?= ($_old['semester'] ?? '') === '3' ? 'selected' : '' ?>>Hè</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="academic_year">Năm học <span class="req">*</span></label>
            <input type="text" id="academic_year" name="academic_year" class="form-control" placeholder="2025-2026" value="<?= htmlspecialchars($_old['academic_year'] ?? date('Y') . '-' . (date('Y') + 1)) ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="note">Ghi chú</label>
          <textarea id="note" name="note" class="form-control" placeholder="Lý do đăng ký, yêu cầu đặc biệt..." rows="3"><?= htmlspecialchars($_old['note'] ?? '') ?></textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
          <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-ghost">Hủy</a>
          <button type="submit" class="btn btn-primary">📋 Gửi đăng ký</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Info panel -->
  <div>
    <div class="card mb-16">
      <div class="card-header"><div class="card-title">ℹ️ Hướng dẫn</div></div>
      <div class="card-body" style="font-size:13px;line-height:1.8;color:var(--txt-secondary)">
        <ol style="padding-left:18px;list-style:decimal">
          <li>Chọn tòa nhà phù hợp với giới tính</li>
          <li>Chọn phòng còn trống</li>
          <li>Gửi đơn và chờ admin duyệt</li>
          <li>Sau khi được duyệt, hợp đồng sẽ được tạo tự động</li>
        </ol>
      </div>
    </div>
    <div class="alert alert-info">
      <span class="alert-icon">💡</span>
      <div class="alert-content"><p class="alert-msg">Đơn đăng ký sẽ được xử lý trong vòng 2-3 ngày làm việc.</p></div>
    </div>
  </div>
</div>
