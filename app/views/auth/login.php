<?php
/**
 * app/views/auth/login.php
 * ─────────────────────────────────────────────────────────────
 *  Login page — Premium glassmorphism design
 *  Variables: $_errors, $_old, $_csrfToken
 * ─────────────────────────────────────────────────────────────
 */
?><!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Đăng nhập hệ thống quản lý ký túc xá KTX">
  <title>Đăng nhập — KTX Management System</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="auth-layout">
  <!-- Floating orbs -->
  <div class="auth-orb"></div>

  <div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
      <div class="auth-logo-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </div>
      <h1>KTX System</h1>
      <p>Hệ thống quản lý ký túc xá</p>
    </div>

    <!-- Error alert -->
    <?php if (!empty($_errors['login'] ?? '')): ?>
      <div class="alert alert-danger" style="margin-bottom: 20px;">
        <span class="alert-icon">❌</span>
        <div class="alert-content">
          <p class="alert-msg"><?= htmlspecialchars($_errors['login']) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!empty($_flash ?? [])): ?>
      <?php foreach ($_flash as $f): ?>
        <?php
        $alertType = match($f['type'] ?? 'info') {
          'success' => ['alert-success', '✅'],
          'error'   => ['alert-error',   '❌'],
          'warning' => ['alert-warning', '⚠️'],
          default   => ['alert-info',    'ℹ️'],
        };
        ?>
        <div class="alert <?= $alertType[0] ?>" style="margin-bottom: 20px;">
          <span class="alert-icon"><?= $alertType[1] ?></span>
          <div class="alert-content">
            <p class="alert-msg"><?= htmlspecialchars($f['message']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <!-- Login Form -->
    <form id="loginForm" method="POST" action="<?= getDynamicUrl('/auth/login') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="email">Email hoặc tên đăng nhập</label>
        <div class="input-group">
          <input
            type="text"
            id="email"
            name="email"
            class="form-control <?= !empty($_errors['email'] ?? '') ? 'is-invalid' : '' ?>"
            placeholder="your@email.com"
            value="<?= htmlspecialchars($_old['email'] ?? '') ?>"
            autocomplete="email"
            required
          >
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
          </span>
        </div>
        <?php if (!empty($_errors['email'] ?? '')): ?>
          <div class="form-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?= htmlspecialchars($_errors['email']) ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="password">Mật khẩu</label>
        <div class="input-group">
          <div class="password-wrapper" style="width:100%">
            <input
              type="password"
              id="password"
              name="password"
              class="form-control <?= !empty($_errors['password'] ?? '') ? 'is-invalid' : '' ?>"
              placeholder="••••••••"
              autocomplete="current-password"
              required
              style="padding-left:40px"
            >
            <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Hiển thị mật khẩu">
              <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </span>
        </div>
        <?php if (!empty($_errors['password'] ?? '')): ?>
          <div class="form-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?= htmlspecialchars($_errors['password']) ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Remember me + Forgot password -->
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px">
        <label class="form-check" style="margin:0">
          <input type="checkbox" name="remember_me" id="rememberMe">
          <span style="font-size:13px; color:rgba(255,255,255,.6)">Nhớ tôi</span>
        </label>
        <a href="<?= getDynamicUrl('/auth/forgot-password') ?>" class="auth-link" style="font-size:13px">Quên mật khẩu?</a>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary" id="submitBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        <span>Đăng nhập</span>
      </button>
    </form>

    <!-- Divider -->
    <div class="auth-divider">hoặc</div>

    <!-- Register link -->
    <p class="auth-footer-text">
      Bạn chưa có tài khoản?
      <a href="<?= getDynamicUrl('/auth/register') ?>" class="auth-link">Đăng ký ngay</a>
    </p>

    <!-- Demo credentials -->
    <div style="margin-top:16px; padding:12px 14px; background:rgba(99,102,241,.1); border-radius:8px; border:1px solid rgba(99,102,241,.2)">
      <p style="font-size:12px; color:rgba(255,255,255,.5); margin-bottom:4px; font-weight:600">🔑 Tài khoản demo</p>
      <p style="font-size:12px; color:rgba(255,255,255,.4); margin:0">
        Admin: <strong style="color:rgba(255,255,255,.7)">admin@ktx.edu.vn / Admin@123</strong>
      </p>
      <p style="font-size:12px; color:rgba(255,255,255,.4); margin:0">
        SV: <strong style="color:rgba(255,255,255,.7)">nguyen.van.a@student.edu.vn / Student@123</strong>
      </p>
    </div>
  </div>
</div>

<script>
  // Password visibility toggle
  function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      input.type = 'password';
      icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  }

  // Auto-focus email
  document.getElementById('email').focus();

  // Form submit with loading state
  document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="loading"></span> <span>Đang đăng nhập...</span>';
  });
</script>
</body>
</html>
