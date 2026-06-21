<?php
/**
 * student/profile.php — Hồ sơ sinh viên
 * Variables: $title, $student, $user, $_errors, $_old, $_csrfToken
 */
$s = $student ?? [];
$u = $user ?? [];
$genderMap = ['male'=>'👨 Nam','female'=>'👩 Nữ'];
?>

<div class="page-header">
  <div><h1 class="page-title">👤 Hồ sơ cá nhân</h1><p class="page-subtitle">Xem và cập nhật thông tin cá nhân</p></div>
</div>

<div class="grid-2">
  <!-- Profile Card -->
  <div class="card">
    <div class="card-body" style="text-align:center;padding:32px">
      <div class="avatar avatar-xl" style="width:80px;height:80px;font-size:28px;margin:0 auto 16px"><?= mb_strtoupper(mb_substr($s['full_name'] ?? 'S', 0, 1)) ?></div>
      <div style="font-size:22px;font-weight:800;margin-bottom:4px"><?= htmlspecialchars($s['full_name'] ?? '') ?></div>
      <div style="color:var(--txt-muted);font-size:14px;margin-bottom:4px"><?= htmlspecialchars($u['email'] ?? '') ?></div>
      <div style="font-family:monospace;color:var(--brand);font-weight:600;margin-bottom:16px"><?= htmlspecialchars($s['student_code'] ?? '') ?></div>
      <span class="badge badge-info">🎓 Sinh viên</span>
    </div>
    <div class="card-body" style="border-top:1px solid var(--border)">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Giới tính</td><td style="text-align:right"><?= $genderMap[$s['gender'] ?? ''] ?? '—' ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày sinh</td><td style="text-align:right"><?= !empty($s['dob']) ? date('d/m/Y', strtotime($s['dob'])) : '—' ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">CCCD</td><td style="text-align:right"><?= htmlspecialchars($s['id_card'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">SĐT</td><td style="text-align:right;font-weight:600"><?= htmlspecialchars($s['phone'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Quê quán</td><td style="text-align:right"><?= htmlspecialchars($s['hometown'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Khoa</td><td style="text-align:right;font-weight:600"><?= htmlspecialchars($s['faculty'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Chương trình</td><td style="text-align:right"><?= htmlspecialchars($s['program'] ?? '') ?></td></tr>
      </table>
    </div>
  </div>

  <!-- Edit Form -->
  <div class="card">
    <div class="card-header"><div class="card-title">✏️ Cập nhật thông tin</div></div>
    <div class="card-body">
      <form method="POST" action="<?= getDynamicUrl('/student/profile') ?>">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

        <div class="form-group">
          <label class="form-label" for="phone">Số điện thoại</label>
          <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($_old['phone'] ?? $s['phone'] ?? '') ?>">
          <?php if (!empty($_errors['phone'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['phone']) ?></div><?php endif; ?>
        </div>

        <div style="padding-top:16px;border-top:1px solid var(--border);margin-top:24px">
          <div style="font-weight:700;font-size:14px;margin-bottom:16px">🔒 Đổi mật khẩu</div>

          <div class="form-group">
            <label class="form-label" for="current_password">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại">
            <?php if (!empty($_errors['current_password'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['current_password']) ?></div><?php endif; ?>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="new_password">Mật khẩu mới</label>
              <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Tối thiểu 8 ký tự" minlength="8">
              <?php if (!empty($_errors['new_password'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['new_password']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
              <label class="form-label" for="confirm_password">Xác nhận</label>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu">
            </div>
          </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
          <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
        </div>
      </form>
    </div>
  </div>
</div>
