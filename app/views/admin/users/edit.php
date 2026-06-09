<?php
/**
 * admin/users/edit.php — Sửa tài khoản
 * Variables: $title, $user, $_errors, $_old, $_csrfToken
 */
$u = $user ?? [];
?>

<div class="page-header">
  <div><h1 class="page-title">✏️ Sửa tài khoản: <?= htmlspecialchars($u['username'] ?? '') ?></h1></div>
  <a href="<?= getDynamicUrl('/admin/users') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:560px">
  <div class="card-header"><div class="card-title">Thông tin tài khoản</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/users/' . ($u['id'] ?? '')) ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
      <input type="hidden" name="_method" value="PUT">

      <div class="form-group">
        <label class="form-label" for="username">Tên đăng nhập <span class="req">*</span></label>
        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($_old['username'] ?? $u['username'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email <span class="req">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($_old['email'] ?? $u['email'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Mật khẩu mới <small style="color:var(--txt-muted);font-weight:400">(bỏ trống nếu không đổi)</small></label>
        <input type="password" id="password" name="password" class="form-control" minlength="8">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="role">Vai trò</label>
          <?php $role = $_old['role'] ?? $u['role'] ?? 'student'; ?>
          <select id="role" name="role" class="form-control">
            <option value="student" <?= $role === 'student' ? 'selected' : '' ?>>🎓 Sinh viên</option>
            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>👑 Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Trạng thái</label>
          <?php $st = $_old['status'] ?? $u['status'] ?? 'active'; ?>
          <select id="status" name="status" class="form-control">
            <option value="active" <?= $st === 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="inactive" <?= $st === 'inactive' ? 'selected' : '' ?>>Ngừng</option>
            <option value="banned" <?= $st === 'banned' ? 'selected' : '' ?>>Cấm</option>
          </select>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/users') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">✅ Cập nhật</button>
      </div>
    </form>
  </div>
</div>
