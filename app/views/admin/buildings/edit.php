<?php
/**
 * admin/buildings/edit.php — Sửa tòa nhà
 * Variables: $title, $building, $_errors, $_old, $_csrfToken
 */
$b = $building ?? [];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">✏️ Sửa tòa nhà: <?= htmlspecialchars($b['name'] ?? '') ?></h1>
    <p class="page-subtitle">Cập nhật thông tin tòa nhà</p>
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
    <form method="POST" action="<?= getDynamicUrl('/admin/buildings/' . ($b['id'] ?? '')) ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
      <input type="hidden" name="_method" value="PUT">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="name">Tên tòa nhà <span class="req">*</span></label>
          <input type="text" id="name" name="name" class="form-control <?= !empty($_errors['name'] ?? '') ? 'is-invalid' : '' ?>"
            value="<?= htmlspecialchars($_old['name'] ?? $b['name'] ?? '') ?>" required>
          <?php if (!empty($_errors['name'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['name']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label class="form-label" for="total_floors">Số tầng <span class="req">*</span></label>
          <input type="number" id="total_floors" name="total_floors" class="form-control"
            min="1" max="30" value="<?= htmlspecialchars($_old['total_floors'] ?? $b['total_floors'] ?? '5') ?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="gender_type">Giới tính cho phép <span class="req">*</span></label>
          <select id="gender_type" name="gender_type" class="form-control" required>
            <?php $gt = $_old['gender_type'] ?? $b['gender_type'] ?? 'mixed'; ?>
            <option value="male" <?= $gt === 'male' ? 'selected' : '' ?>>👨 Nam</option>
            <option value="female" <?= $gt === 'female' ? 'selected' : '' ?>>👩 Nữ</option>
            <option value="mixed" <?= $gt === 'mixed' ? 'selected' : '' ?>>👥 Hỗn hợp</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Trạng thái</label>
          <?php $st = $_old['status'] ?? $b['status'] ?? 'active'; ?>
          <select id="status" name="status" class="form-control">
            <option value="active" <?= $st === 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="maintenance" <?= $st === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
            <option value="closed" <?= $st === 'closed' ? 'selected' : '' ?>>Đóng cửa</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="manager_name">Tên quản lý <span class="req">*</span></label>
          <input type="text" id="manager_name" name="manager_name" class="form-control"
            value="<?= htmlspecialchars($_old['manager_name'] ?? $b['manager_name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="manager_phone">SĐT quản lý <span class="req">*</span></label>
          <input type="tel" id="manager_phone" name="manager_phone" class="form-control"
            value="<?= htmlspecialchars($_old['manager_phone'] ?? $b['manager_phone'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="address">Địa chỉ <span class="req">*</span></label>
        <input type="text" id="address" name="address" class="form-control"
          value="<?= htmlspecialchars($_old['address'] ?? $b['address'] ?? '') ?>" required>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/buildings') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          Cập nhật
        </button>
      </div>
    </form>
  </div>
</div>
