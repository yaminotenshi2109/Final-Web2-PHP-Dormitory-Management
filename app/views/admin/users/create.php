<?php
/**
 * admin/users/create.php — Tạo tài khoản
 * Variables: $title, $_errors, $_old, $_csrfToken
 *
 * @var string $title
 * @var array<string,string> $_errors
 * @var array<string,mixed> $_old
 * @var string $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">👤 Tạo tài khoản mới</h1><p class="page-subtitle">Tạo tài khoản người dùng hệ thống</p></div>
  <a href="<?= getDynamicUrl('/admin/users') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:560px">
  <div class="card-header"><div class="card-title">Thông tin tài khoản</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/users') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-group">
        <label class="form-label" for="username">Tên đăng nhập <span class="req">*</span></label>
        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($_old['username'] ?? '') ?>" required>
        <?php if (!empty($_errors['username'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['username']) ?></div><?php endif; ?>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email <span class="req">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($_old['email'] ?? '') ?>" required>
        <?php if (!empty($_errors['email'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['email']) ?></div><?php endif; ?>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Mật khẩu <span class="req">*</span></label>
        <input type="password" id="password" name="password" class="form-control" minlength="8" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="password_confirm">Xác nhận mật khẩu <span class="req">*</span></label>
        <input type="password" id="password_confirm" name="password_confirm" class="form-control" minlength="8" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="status">Trạng thái <span class="req">*</span></label>
        <select id="status" name="status" class="form-control" required>
          <option value="active" <?= ($_old['status'] ?? '') === 'active' ? 'selected' : '' ?>>✅ Hoạt động</option>
          <option value="inactive" <?= ($_old['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>🔴 Vô hiệu hóa</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label" for="role">Vai trò <span class="req">*</span></label>
        <select id="role" name="role" class="form-control" required>
          <option value="student" <?= ($_old['role'] ?? '') === 'student' ? 'selected' : '' ?>>🎓 Sinh viên</option>
          <option value="admin" <?= ($_old['role'] ?? '') === 'admin' ? 'selected' : '' ?>>👑 Admin</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/users') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">✅ Tạo tài khoản</button>
      </div>
    </form>
  </div>
</div>
