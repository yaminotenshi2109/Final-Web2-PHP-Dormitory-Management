<?php
/**
 * admin/students/create.php — Thêm sinh viên
 * Variables: $title, $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">🎓 Thêm sinh viên mới</h1><p class="page-subtitle">Tạo hồ sơ sinh viên trong hệ thống</p></div>
  <a href="<?= getDynamicUrl('/admin/students') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header"><div class="card-title">Thông tin sinh viên</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/students') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="full_name">Họ và tên <span class="req">*</span></label>
          <input type="text" id="full_name" name="full_name" class="form-control <?= !empty($_errors['full_name'] ?? '') ? 'is-invalid' : '' ?>" placeholder="Nguyễn Văn A" value="<?= htmlspecialchars($_old['full_name'] ?? '') ?>" required>
          <?php if (!empty($_errors['full_name'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['full_name']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label class="form-label" for="student_code">Mã sinh viên <span class="req">*</span></label>
          <input type="text" id="student_code" name="student_code" class="form-control" placeholder="SV20210001" value="<?= htmlspecialchars($_old['student_code'] ?? '') ?>" required>
          <?php if (!empty($_errors['student_code'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['student_code']) ?></div><?php endif; ?>
        </div>
      </div>

      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label" for="gender">Giới tính <span class="req">*</span></label>
          <select id="gender" name="gender" class="form-control" required>
            <option value="">— Chọn —</option>
            <option value="male" <?= ($_old['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Nam</option>
            <option value="female" <?= ($_old['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="dob">Ngày sinh <span class="req">*</span></label>
          <input type="date" id="dob" name="dob" class="form-control" value="<?= htmlspecialchars($_old['dob'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="phone">Số điện thoại <span class="req">*</span></label>
          <input type="tel" id="phone" name="phone" class="form-control" placeholder="0901234567" value="<?= htmlspecialchars($_old['phone'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="faculty">Khoa <span class="req">*</span></label>
          <input type="text" id="faculty" name="faculty" class="form-control" placeholder="Công nghệ thông tin" value="<?= htmlspecialchars($_old['faculty'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="program">Chương trình <span class="req">*</span></label>
          <select id="program" name="program" class="form-control" required>
            <option value="Đại trà" <?= ($_old['program'] ?? '') === 'Đại trà' ? 'selected' : '' ?>>Đại trà</option>
            <option value="Chất lượng cao" <?= ($_old['program'] ?? '') === 'Chất lượng cao' ? 'selected' : '' ?>>Chất lượng cao</option>
            <option value="Tiên tiến" <?= ($_old['program'] ?? '') === 'Tiên tiến' ? 'selected' : '' ?>>Tiên tiến</option>
            <option value="Quốc tế" <?= ($_old['program'] ?? '') === 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="id_card">Số CCCD <span class="req">*</span></label>
          <input type="text" id="id_card" name="id_card" class="form-control" placeholder="001234567890" value="<?= htmlspecialchars($_old['id_card'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="hometown">Quê quán <span class="req">*</span></label>
          <input type="text" id="hometown" name="hometown" class="form-control" placeholder="Hà Nội" value="<?= htmlspecialchars($_old['hometown'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="priority_level">Mức ưu tiên</label>
        <select id="priority_level" name="priority_level" class="form-control">
          <option value="0" <?= ($_old['priority_level'] ?? '0') === '0' ? 'selected' : '' ?>>Bình thường</option>
          <option value="1" <?= ($_old['priority_level'] ?? '') === '1' ? 'selected' : '' ?>>Chính sách</option>
          <option value="2" <?= ($_old['priority_level'] ?? '') === '2' ? 'selected' : '' ?>>Ưu tiên cao</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/students') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">✅ Tạo sinh viên</button>
      </div>
    </form>
  </div>
</div>
