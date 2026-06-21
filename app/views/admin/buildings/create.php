<?php
/**
 * admin/buildings/create.php — Form tạo tòa nhà
 * Variables: $title, $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🏢 Thêm tòa nhà mới</h1>
    <p class="page-subtitle">Tạo tòa nhà mới trong hệ thống KTX</p>
  </div>
  <a href="<?= getDynamicUrl('/admin/buildings') ?>" class="btn btn-ghost">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Quay lại
  </a>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header">
    <div class="card-title">Thông tin tòa nhà</div>
  </div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/buildings') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="name">Tên tòa nhà <span class="req">*</span></label>
          <input type="text" id="name" name="name" class="form-control <?= !empty($_errors['name'] ?? '') ? 'is-invalid' : '' ?>"
            placeholder="VD: A1, B2" value="<?= htmlspecialchars($_old['name'] ?? '') ?>" required>
          <?php if (!empty($_errors['name'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['name']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="total_floors">Số tầng <span class="req">*</span></label>
          <input type="number" id="total_floors" name="total_floors" class="form-control"
            min="1" max="30" value="<?= htmlspecialchars($_old['total_floors'] ?? '5') ?>" required>
          <?php if (!empty($_errors['total_floors'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['total_floors']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="gender_type">Giới tính cho phép <span class="req">*</span></label>
          <select id="gender_type" name="gender_type" class="form-control" required>
            <option value="male" <?= ($_old['gender_type'] ?? '') === 'male' ? 'selected' : '' ?>>👨 Nam</option>
            <option value="female" <?= ($_old['gender_type'] ?? '') === 'female' ? 'selected' : '' ?>>👩 Nữ</option>
            <option value="mixed" <?= ($_old['gender_type'] ?? '') === 'mixed' ? 'selected' : '' ?>>👥 Hỗn hợp</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="status">Trạng thái</label>
          <select id="status" name="status" class="form-control">
            <option value="active" <?= ($_old['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="maintenance" <?= ($_old['status'] ?? '') === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
            <option value="closed" <?= ($_old['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Đóng cửa</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="manager_name">Tên quản lý <span class="req">*</span></label>
          <input type="text" id="manager_name" name="manager_name" class="form-control"
            placeholder="Nguyễn Văn A" value="<?= htmlspecialchars($_old['manager_name'] ?? '') ?>" required>
          <?php if (!empty($_errors['manager_name'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['manager_name']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="manager_phone">SĐT quản lý <span class="req">*</span></label>
          <input type="tel" id="manager_phone" name="manager_phone" class="form-control"
            placeholder="0901234567" value="<?= htmlspecialchars($_old['manager_phone'] ?? '') ?>" required>
          <?php if (!empty($_errors['manager_phone'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['manager_phone']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="address">Địa chỉ <span class="req">*</span></label>
        <input type="text" id="address" name="address" class="form-control"
          placeholder="KTX Khu A, Đường Nguyễn Trãi, Hà Nội" value="<?= htmlspecialchars($_old['address'] ?? '') ?>" required>
        <?php if (!empty($_errors['address'] ?? '')): ?>
          <div class="form-error">⚠ <?= htmlspecialchars($_errors['address']) ?></div>
        <?php endif; ?>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/buildings') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          Tạo tòa nhà
        </button>
      </div>
    </form>
  </div>
</div>
