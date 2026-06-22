<?php
/**
 * admin/rooms/create.php — Form tạo phòng
 * Variables: $title, $buildings[], $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div>
    <h1 class="page-title"> Thêm phòng mới</h1>
    <p class="page-subtitle">Tạo phòng ở mới trong hệ thống</p>
  </div>
  <a href="<?= getDynamicUrl('/admin/rooms') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header"><div class="card-title">Thông tin phòng</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/rooms') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="building_id">Tòa nhà <span class="req">*</span></label>
          <select id="building_id" name="building_id" class="form-control" required>
            <option value="">— Chọn tòa nhà —</option>
            <?php foreach ($buildings ?? [] as $bl): ?>
              <option value="<?= $bl['id'] ?>" <?= ($_old['building_id'] ?? ($_GET['building_id'] ?? '')) == $bl['id'] ? 'selected' : '' ?>><?= htmlspecialchars($bl['name']) ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (!empty($_errors['building_id'] ?? '')): ?><div class="form-error"> <?= htmlspecialchars($_errors['building_id']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label class="form-label" for="room_number">Số phòng <span class="req">*</span></label>
          <input type="text" id="room_number" name="room_number" class="form-control" placeholder="101" value="<?= htmlspecialchars($_old['room_number'] ?? '') ?>" required>
          <?php if (!empty($_errors['room_number'] ?? '')): ?><div class="form-error"> <?= htmlspecialchars($_errors['room_number']) ?></div><?php endif; ?>
        </div>
      </div>

      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label" for="floor">Tầng <span class="req">*</span></label>
          <input type="number" id="floor" name="floor" class="form-control" min="1" max="30" value="<?= htmlspecialchars($_old['floor'] ?? '1') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="room_type">Loại phòng <span class="req">*</span></label>
          <select id="room_type" name="room_type" class="form-control" required>
            <?php $rt = $_old['room_type'] ?? 'standard'; ?>
            <option value="standard" <?= $rt === 'standard' ? 'selected' : '' ?>>Tiêu chuẩn</option>
            <option value="deluxe" <?= $rt === 'deluxe' ? 'selected' : '' ?>>Cao cấp</option>
            <option value="ac_standard" <?= $rt === 'ac_standard' ? 'selected' : '' ?>>Tiêu chuẩn (ML)</option>
            <option value="ac_deluxe" <?= $rt === 'ac_deluxe' ? 'selected' : '' ?>>Cao cấp (ML)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="capacity">Sức chứa <span class="req">*</span></label>
          <input type="number" id="capacity" name="capacity" class="form-control" min="1" max="12" value="<?= htmlspecialchars($_old['capacity'] ?? '4') ?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="price_per_month">Giá/tháng (VND) <span class="req">*</span></label>
          <input type="number" id="price_per_month" name="price_per_month" class="form-control" min="0" step="50000" placeholder="600000" value="<?= htmlspecialchars($_old['price_per_month'] ?? '') ?>" required>
          <?php if (!empty($_errors['price_per_month'] ?? '')): ?><div class="form-error"> <?= htmlspecialchars($_errors['price_per_month']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label class="form-label">Tiện nghi</label>
          <div style="padding-top:8px">
            <label class="form-check"><input type="checkbox" name="has_ac" value="1" <?= ($_old['has_ac'] ?? 0) ? 'checked' : '' ?>>
              <span style="font-size:14px"> Có điều hòa</span>
            </label>
          </div>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/rooms') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          Tạo phòng
        </button>
      </div>
    </form>
  </div>
</div>
