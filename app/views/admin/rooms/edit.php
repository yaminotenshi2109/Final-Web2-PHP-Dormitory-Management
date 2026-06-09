<?php
/**
 * admin/rooms/edit.php — Sửa phòng
 * Variables: $title, $room, $buildings[], $_errors, $_old, $_csrfToken
 */
$r = $room ?? [];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">✏️ Sửa phòng <?= htmlspecialchars($r['room_number'] ?? '') ?></h1>
    <p class="page-subtitle">Cập nhật thông tin phòng</p>
  </div>
  <a href="<?= getDynamicUrl('/admin/rooms') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header"><div class="card-title">Thông tin phòng</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/rooms/' . ($r['id'] ?? '')) ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
      <input type="hidden" name="_method" value="PUT">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="building_id">Tòa nhà <span class="req">*</span></label>
          <select id="building_id" name="building_id" class="form-control" required>
            <?php foreach ($buildings ?? [] as $bl): ?>
              <option value="<?= $bl['id'] ?>" <?= ($_old['building_id'] ?? $r['building_id'] ?? '') == $bl['id'] ? 'selected' : '' ?>><?= htmlspecialchars($bl['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="room_number">Số phòng <span class="req">*</span></label>
          <input type="text" id="room_number" name="room_number" class="form-control" value="<?= htmlspecialchars($_old['room_number'] ?? $r['room_number'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label" for="floor">Tầng</label>
          <input type="number" id="floor" name="floor" class="form-control" min="1" value="<?= htmlspecialchars($_old['floor'] ?? $r['floor'] ?? '1') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="room_type">Loại phòng</label>
          <?php $rt = $_old['room_type'] ?? $r['room_type'] ?? 'standard'; ?>
          <select id="room_type" name="room_type" class="form-control" required>
            <option value="standard" <?= $rt === 'standard' ? 'selected' : '' ?>>Tiêu chuẩn</option>
            <option value="deluxe" <?= $rt === 'deluxe' ? 'selected' : '' ?>>Cao cấp</option>
            <option value="ac_standard" <?= $rt === 'ac_standard' ? 'selected' : '' ?>>Tiêu chuẩn (ML)</option>
            <option value="ac_deluxe" <?= $rt === 'ac_deluxe' ? 'selected' : '' ?>>Cao cấp (ML)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="capacity">Sức chứa</label>
          <input type="number" id="capacity" name="capacity" class="form-control" min="1" value="<?= htmlspecialchars($_old['capacity'] ?? $r['capacity'] ?? '4') ?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="price_per_month">Giá/tháng (VND)</label>
          <input type="number" id="price_per_month" name="price_per_month" class="form-control" min="0" step="50000" value="<?= htmlspecialchars($_old['price_per_month'] ?? $r['price_per_month'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Trạng thái</label>
          <?php $st = $_old['status'] ?? $r['status'] ?? 'available'; ?>
          <select id="status" name="status" class="form-control">
            <option value="available" <?= $st === 'available' ? 'selected' : '' ?>>Trống</option>
            <option value="full" <?= $st === 'full' ? 'selected' : '' ?>>Đầy</option>
            <option value="maintenance" <?= $st === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
            <option value="inactive" <?= $st === 'inactive' ? 'selected' : '' ?>>Không dùng</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-check">
          <input type="checkbox" name="has_ac" value="1" <?= ($_old['has_ac'] ?? $r['has_ac'] ?? 0) ? 'checked' : '' ?>>
          <span>❄️ Có điều hòa</span>
        </label>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/rooms') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">✅ Cập nhật</button>
      </div>
    </form>
  </div>
</div>
