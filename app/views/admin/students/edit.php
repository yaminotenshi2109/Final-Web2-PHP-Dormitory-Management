<?php
/**
 * admin/students/edit.php — Sửa sinh viên
 * Variables: $title, $student, $_errors, $_old, $_csrfToken
 */
$s = $student ?? [];
?>

<div class="page-header">
  <div><h1 class="page-title"> Sửa sinh viên: <?= htmlspecialchars($s['full_name'] ?? '') ?></h1><p class="page-subtitle">Cập nhật thông tin sinh viên</p></div>
  <a href="<?= getDynamicUrl('/admin/students') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header"><div class="card-title">Thông tin sinh viên</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/students/' . ($s['id'] ?? '')) ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
      <input type="hidden" name="_method" value="PUT">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="full_name">Họ và tên <span class="req">*</span></label>
          <input type="text" id="full_name" name="full_name" class="form-control" value="<?= htmlspecialchars($_old['full_name'] ?? $s['full_name'] ?? '') ?>" required>
          <?php if (!empty($_errors['full_name'] ?? '')): ?><div class="form-error"> <?= htmlspecialchars($_errors['full_name']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label class="form-label" for="student_code">Mã sinh viên <span class="req">*</span></label>
          <input type="text" id="student_code" name="student_code" class="form-control" value="<?= htmlspecialchars($_old['student_code'] ?? $s['student_code'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label" for="gender">Giới tính</label>
          <?php $g = $_old['gender'] ?? $s['gender'] ?? ''; ?>
          <select id="gender" name="gender" class="form-control" required>
            <option value="male" <?= $g === 'male' ? 'selected' : '' ?>>Nam</option>
            <option value="female" <?= $g === 'female' ? 'selected' : '' ?>>Nữ</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="dob">Ngày sinh</label>
          <input type="date" id="dob" name="dob" class="form-control" value="<?= htmlspecialchars($_old['dob'] ?? $s['dob'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="phone">Số điện thoại</label>
          <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($_old['phone'] ?? $s['phone'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="faculty">Khoa</label>
          <input type="text" id="faculty" name="faculty" class="form-control" value="<?= htmlspecialchars($_old['faculty'] ?? $s['faculty'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="program">Chương trình</label>
          <?php $prog = $_old['program'] ?? $s['program'] ?? 'Đại trà'; ?>
          <select id="program" name="program" class="form-control" required>
            <option value="Đại trà" <?= $prog === 'Đại trà' ? 'selected' : '' ?>>Đại trà</option>
            <option value="Chất lượng cao" <?= $prog === 'Chất lượng cao' ? 'selected' : '' ?>>Chất lượng cao</option>
            <option value="Tiên tiến" <?= $prog === 'Tiên tiến' ? 'selected' : '' ?>>Tiên tiến</option>
            <option value="Quốc tế" <?= $prog === 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="id_card">Số CCCD</label>
          <input type="text" id="id_card" name="id_card" class="form-control" value="<?= htmlspecialchars($_old['id_card'] ?? $s['id_card'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="hometown">Quê quán</label>
          <input type="text" id="hometown" name="hometown" class="form-control" value="<?= htmlspecialchars($_old['hometown'] ?? $s['hometown'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="priority_level">Mức ưu tiên</label>
        <?php $pl = $_old['priority_level'] ?? $s['priority_level'] ?? '0'; ?>
        <select id="priority_level" name="priority_level" class="form-control">
          <option value="0" <?= $pl == '0' ? 'selected' : '' ?>>Bình thường</option>
          <option value="1" <?= $pl == '1' ? 'selected' : '' ?>>Chính sách</option>
          <option value="2" <?= $pl == '2' ? 'selected' : '' ?>>Ưu tiên cao</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/students') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary"> Cập nhật</button>
      </div>
    </form>
  </div>
</div>
