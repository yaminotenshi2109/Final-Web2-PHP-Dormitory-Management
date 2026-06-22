<?php
/**
 * app/views/auth/forgot-password.php
 * ─────────────────────────────────────────────────────────────
 *  Forgot password page
 * ─────────────────────────────────────────────────────────────
 */
?><!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quên mật khẩu — KTX System</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'></text></svg>">
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="auth-layout">
  <div class="auth-orb"></div>

  <div class="auth-card">
    <!-- Back link -->
    <a href="<?= getDynamicUrl('/auth/login') ?>" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;margin-bottom:24px;transition:color .25s">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
      Quay lại đăng nhập
    </a>

    <!-- Logo -->
    <div class="auth-logo">
      <div class="auth-logo-icon" style="background:linear-gradient(135deg, #f59e0b, #ef4444);">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" width="28" height="28">
          <circle cx="12" cy="12" r="10"/>
          <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
          <line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
      </div>
      <h1>Quên mật khẩu</h1>
      <p>Nhập email để nhận link đặt lại mật khẩu</p>
    </div>

    <!-- Success message -->
    <?php if (!empty($success ?? '')): ?>
      <div class="alert alert-success" style="margin-bottom:20px">
        <div class="alert-content">
          <p class="alert-msg"><?= htmlspecialchars($success) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Error -->
    <?php if (!empty($_errors['email'] ?? '')): ?>
      <div class="alert alert-danger" style="margin-bottom:20px">
        <div class="alert-content">
          <p class="alert-msg"><?= htmlspecialchars($_errors['email']) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="<?= getDynamicUrl('/auth/forgot-password') ?>" id="forgotForm">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-group">
        <label class="form-label" for="email">Địa chỉ Email</label>
        <div class="input-group">
          <input type="email" id="email" name="email"
            class="form-control"
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
        <p class="form-hint">Chúng tôi sẽ gửi link đặt lại mật khẩu qua email.</p>
      </div>

      <button type="submit" class="btn btn-primary" id="submitBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
        <span>Gửi yêu cầu</span>
      </button>
    </form>

    <p class="auth-footer-text">
      Nhớ mật khẩu rồi?
      <a href="<?= getDynamicUrl('/auth/login') ?>" class="auth-link">Đăng nhập</a>
    </p>
  </div>
</div>

<script>
  document.getElementById('email').focus();
  document.getElementById('forgotForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="loading"></span> <span>Đang gửi...</span>';
  });
</script>
</body>
</html>
