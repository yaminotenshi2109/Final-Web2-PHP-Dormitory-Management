<?php
/**
 * admin/violations/create.php — Ghi nhận vi phạm
 * Variables: $title, $students[], $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">⚠️ Ghi nhận vi phạm</h1><p class="page-subtitle">Tạo bản ghi vi phạm nội quy mới</p></div>
  <a href="<?= getDynamicUrl('/admin/violations') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:640px">
  <div class="card-header"><div class="card-title">Thông tin vi phạm</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/violations') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-group">
        <label class="form-label" for="student_id">Sinh viên <span class="req">*</span></label>
        <select id="student_id" name="student_id" class="form-control" required>
          <option value="">— Chọn sinh viên —</option>
          <?php foreach ($students ?? [] as $s): ?>
            <option value="<?= $s['id'] ?>" <?= ($_old['student_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= htmlspecialchars($s['full_name'] . ' — ' . $s['student_code']) ?></option>
          <?php endforeach; ?>
        </select>
        <?php if (!empty($_errors['student_id'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['student_id']) ?></div><?php endif; ?>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="violation_type">Loại vi phạm <span class="req">*</span></label>
          <select id="violation_type" name="violation_type" class="form-control" required>
            <option value="">— Chọn —</option>
            <option value="noise" <?= ($_old['violation_type'] ?? '') === 'noise' ? 'selected' : '' ?>>🔊 Gây ồn</option>
            <option value="unauthorized_item" <?= ($_old['violation_type'] ?? '') === 'unauthorized_item' ? 'selected' : '' ?>>🔌 Sử dụng thiết bị trái phép</option>
            <option value="smoking" <?= ($_old['violation_type'] ?? '') === 'smoking' ? 'selected' : '' ?>>🚬 Hút thuốc</option>
            <option value="curfew" <?= ($_old['violation_type'] ?? '') === 'curfew' ? 'selected' : '' ?>>🌙 Về muộn</option>
            <option value="damage" <?= ($_old['violation_type'] ?? '') === 'damage' ? 'selected' : '' ?>>💥 Gây hư hại tài sản</option>
            <option value="guests" <?= ($_old['violation_type'] ?? '') === 'guests' ? 'selected' : '' ?>>🚷 Đưa người lạ vào</option>
            <option value="other" <?= ($_old['violation_type'] ?? '') === 'other' ? 'selected' : '' ?>>📝 Khác</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="penalty_points">Điểm phạt <span class="req">*</span></label>
          <input type="number" id="penalty_points" name="penalty_points" class="form-control" min="1" max="20" value="<?= htmlspecialchars($_old['penalty_points'] ?? '2') ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Mô tả chi tiết <span class="req">*</span></label>
        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Mô tả cụ thể hành vi vi phạm..." required><?= htmlspecialchars($_old['description'] ?? '') ?></textarea>
        <?php if (!empty($_errors['description'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['description']) ?></div><?php endif; ?>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/violations') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-danger">⚠️ Ghi nhận vi phạm</button>
      </div>
    </form>
  </div>
</div>
