<?php
/**
 * app/views/auth/register.php
 * ─────────────────────────────────────────────────────────────
 *  Register page — Premium glassmorphism design
 *  Variables: $_errors, $_old, $_csrfToken
 * ─────────────────────────────────────────────────────────────
 */
?><!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Đăng ký tài khoản sinh viên — KTX Management System">
  <title>Đăng ký — KTX Management System</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="auth-layout">
  <div class="auth-orb"></div>

  <div class="auth-card" style="max-width:520px">
    <!-- Logo -->
    <div class="auth-logo">
      <div class="auth-logo-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </div>
      <h1>Tạo tài khoản</h1>
      <p>Đăng ký để truy cập hệ thống KTX</p>
    </div>

    <!-- Error alert -->
    <?php if (!empty($_errors['register'] ?? '')): ?>
      <div class="alert alert-danger" style="margin-bottom:20px">
        <span class="alert-icon">❌</span>
        <div class="alert-content">
          <p class="alert-msg"><?= htmlspecialchars($_errors['register']) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Register Form -->
    <form id="registerForm" method="POST" action="<?= getDynamicUrl('/auth/register') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <!-- Username -->
      <div class="form-group">
        <label class="form-label" for="username">Tên đăng nhập <span class="req">*</span></label>
        <div class="input-group">
          <input type="text" id="username" name="username"
            class="form-control <?= !empty($_errors['username'] ?? '') ? 'is-invalid' : '' ?>"
            placeholder="vd: sv001"
            value="<?= htmlspecialchars($_old['username'] ?? '') ?>"
            autocomplete="username" required>
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </span>
        </div>
        <?php if (!empty($_errors['username'] ?? '')): ?>
          <div class="form-error">⚠ <?= htmlspecialchars($_errors['username']) ?></div>
        <?php endif; ?>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="email">Email <span class="req">*</span></label>
        <div class="input-group">
          <input type="email" id="email" name="email"
            class="form-control <?= !empty($_errors['email'] ?? '') ? 'is-invalid' : '' ?>"
            placeholder="your@student.edu.vn"
            value="<?= htmlspecialchars($_old['email'] ?? '') ?>"
            autocomplete="email" required>
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
          </span>
        </div>
        <?php if (!empty($_errors['email'] ?? '')): ?>
          <div class="form-error">⚠ <?= htmlspecialchars($_errors['email']) ?></div>
        <?php endif; ?>
      </div>

      <!-- Password row -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="password">Mật khẩu <span class="req">*</span></label>
          <div class="input-group">
            <div class="password-wrapper" style="width:100%">
              <input type="password" id="password" name="password"
                class="form-control <?= !empty($_errors['password'] ?? '') ? 'is-invalid' : '' ?>"
                placeholder="Tối thiểu 8 ký tự"
                autocomplete="new-password" required
                style="padding-left:40px" minlength="8">
              <button type="button" class="password-toggle" onclick="togglePw('password','eyePw1')" aria-label="Hiện mật khẩu">
                <svg id="eyePw1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <span class="input-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
          </div>
          <?php if (!empty($_errors['password'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['password']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="password_confirm">Xác nhận <span class="req">*</span></label>
          <div class="input-group">
            <div class="password-wrapper" style="width:100%">
              <input type="password" id="password_confirm" name="password_confirm"
                class="form-control <?= !empty($_errors['password_confirm'] ?? '') ? 'is-invalid' : '' ?>"
                placeholder="Nhập lại mật khẩu"
                autocomplete="new-password" required
                style="padding-left:40px" minlength="8">
              <button type="button" class="password-toggle" onclick="togglePw('password_confirm','eyePw2')" aria-label="Hiện mật khẩu">
                <svg id="eyePw2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <span class="input-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </span>
          </div>
          <?php if (!empty($_errors['password_confirm'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['password_confirm']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Divider: Student info -->
      <div class="auth-divider">Thông tin sinh viên</div>

      <!-- Full name + Student code -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="full_name">Họ và tên <span class="req">*</span></label>
          <input type="text" id="full_name" name="full_name"
            class="form-control <?= !empty($_errors['full_name'] ?? '') ? 'is-invalid' : '' ?>"
            placeholder="Nguyễn Văn A"
            value="<?= htmlspecialchars($_old['full_name'] ?? '') ?>" required>
          <?php if (!empty($_errors['full_name'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['full_name']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="student_code">Mã sinh viên <span class="req">*</span></label>
          <input type="text" id="student_code" name="student_code"
            class="form-control <?= !empty($_errors['student_code'] ?? '') ? 'is-invalid' : '' ?>"
            placeholder="SV20210001"
            value="<?= htmlspecialchars($_old['student_code'] ?? '') ?>" required>
          <?php if (!empty($_errors['student_code'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['student_code']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Gender + DOB -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="gender">Giới tính <span class="req">*</span></label>
          <select id="gender" name="gender" class="form-control" required>
            <option value="">— Chọn —</option>
            <option value="male" <?= ($_old['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Nam</option>
            <option value="female" <?= ($_old['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
          </select>
          <?php if (!empty($_errors['gender'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['gender']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="dob">Ngày sinh <span class="req">*</span></label>
          <input type="date" id="dob" name="dob"
            class="form-control <?= !empty($_errors['dob'] ?? '') ? 'is-invalid' : '' ?>"
            value="<?= htmlspecialchars($_old['dob'] ?? '') ?>" required>
          <?php if (!empty($_errors['dob'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['dob']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Faculty + Phone -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="faculty">Khoa / Viện <span class="req">*</span></label>
          <input type="text" id="faculty" name="faculty"
            class="form-control" placeholder="Công nghệ thông tin"
            value="<?= htmlspecialchars($_old['faculty'] ?? '') ?>" required>
          <?php if (!empty($_errors['faculty'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['faculty']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Số điện thoại <span class="req">*</span></label>
          <input type="tel" id="phone" name="phone"
            class="form-control" placeholder="0901234567"
            value="<?= htmlspecialchars($_old['phone'] ?? '') ?>" required>
          <?php if (!empty($_errors['phone'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['phone']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Program + ID Card + Hometown -->
      <div class="form-group">
        <label class="form-label" for="program">Chương trình học <span class="req">*</span></label>
        <select id="program" name="program" class="form-control" required>
          <option value="">— Chọn —</option>
          <option value="Đại trà" <?= ($_old['program'] ?? '') === 'Đại trà' ? 'selected' : '' ?>>Đại trà</option>
          <option value="Chất lượng cao" <?= ($_old['program'] ?? '') === 'Chất lượng cao' ? 'selected' : '' ?>>Chất lượng cao</option>
          <option value="Tiên tiến" <?= ($_old['program'] ?? '') === 'Tiên tiến' ? 'selected' : '' ?>>Tiên tiến</option>
          <option value="Quốc tế" <?= ($_old['program'] ?? '') === 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
        </select>
        <?php if (!empty($_errors['program'] ?? '')): ?>
          <div class="form-error">⚠ <?= htmlspecialchars($_errors['program']) ?></div>
        <?php endif; ?>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="id_card">Số CCCD <span class="req">*</span></label>
          <input type="text" id="id_card" name="id_card"
            class="form-control" placeholder="001234567890"
            value="<?= htmlspecialchars($_old['id_card'] ?? '') ?>" required>
          <?php if (!empty($_errors['id_card'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['id_card']) ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label" for="hometown">Quê quán <span class="req">*</span></label>
          <input type="text" id="hometown" name="hometown"
            class="form-control" placeholder="Hà Nội"
            value="<?= htmlspecialchars($_old['hometown'] ?? '') ?>" required>
          <?php if (!empty($_errors['hometown'] ?? '')): ?>
            <div class="form-error">⚠ <?= htmlspecialchars($_errors['hometown']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary" id="submitBtn" style="margin-top:8px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="8.5" cy="7" r="4"/>
          <line x1="20" y1="8" x2="20" y2="14"/>
          <line x1="23" y1="11" x2="17" y2="11"/>
        </svg>
        <span>Đăng ký</span>
      </button>
    </form>

    <!-- Login link -->
    <p class="auth-footer-text">
      Đã có tài khoản?
      <a href="<?= getDynamicUrl('/auth/login') ?>" class="auth-link">Đăng nhập</a>
    </p>
  </div>
</div>

<script>
  function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
      input.type = 'text';
      icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      input.type = 'password';
      icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  }

  document.getElementById('registerForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="loading"></span> <span>Đang xử lý...</span>';
  });

  document.getElementById('username').focus();
</script>
</body>
</html>
