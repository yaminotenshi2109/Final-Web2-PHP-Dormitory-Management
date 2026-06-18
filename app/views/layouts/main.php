<?php
/**
 * app/views/layouts/main.php
 * Simplified main layout (cleaned up from merge conflicts)
 * Variables available: $content, $_auth, $_flash, $_errors, $_old, $_csrfToken
 */

/**
 * @var string $content
 * @var array|null $_auth
 * @var array|null $_flash
 * @var array|null $_errors
 * @var array|null $_old
 * @var string|null $_csrfToken
 */

$role = $_auth['role'] ?? 'student';
$userName = $_auth['username'] ?? 'User';
$userInitial = strtoupper(mb_substr($userName, 0, 1));
$isAdmin = $role === 'admin';

// Normalize current URI
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$rootDir = rtrim(dirname($scriptDir), '/\\');
if ($scriptDir !== '' && $scriptDir !== '/' && str_starts_with($currentUri, $scriptDir)) {
  $currentUri = substr($currentUri, strlen($scriptDir));
} elseif ($rootDir !== '' && $rootDir !== '/' && $rootDir !== '\\' && str_starts_with($currentUri, $rootDir)) {
  $currentUri = substr($currentUri, strlen($rootDir));
}
$currentUri = '/' . trim($currentUri, '/') ?: '/';

function navLink(string $href, string $icon, string $label, string $current, string $badge = ''): string
{
  $dynamicHref = getDynamicUrl($href);
  $active = ($href !== '/' && str_starts_with($current, $href)) ? ' active' : ($current === $href ? ' active' : '');
  $badgeHtml = $badge ? "<span class=\"nav-badge\">{$badge}</span>" : '';
  return "<a href=\"{$dynamicHref}\" class=\"sidebar-link{$active}\">"
       . "<span class=\"nav-icon\">{$icon}</span><span>{$label}</span>{$badgeHtml}</a>";
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="<?= htmlspecialchars($_csrfToken ?? '') ?>">
  <title><?= htmlspecialchars($title ?? 'KTX Management') ?> — KTX System</title>
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
</head>
<body>

<?php // Flash messages helper ?>
<?php if (!empty($_flash)): ?>
  <div style="position:fixed;right:16px;top:16px;z-index:9999;max-width:420px">
    <?php foreach ($_flash as $f): ?>
      <?php $type = match ($f['type'] ?? 'info') {
        'success' => ['alert-success', '✅'],
        'error' => ['alert-error', '❌'],
        'warning' => ['alert-warning', '⚠️'],
        default => ['alert-info', 'ℹ️'],
      }; ?>
      <div class="alert <?= $type[0] ?>" style="margin-bottom:12px;">
        <span class="alert-icon"><?= $type[1] ?></span>
        <div class="alert-content"><p class="alert-msg"><?= htmlspecialchars($f['message'] ?? '') ?></p></div>
        <button class="alert-close">×</button>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php if (!empty($_auth)): ?>
  <div class="layout">
    <aside class="sidebar">
      <div class="sidebar-logo"><strong>KTX System</strong></div>
      <div class="sidebar-user"><div class="sidebar-avatar"><?= $userInitial ?></div>
        <div class="sidebar-user-info"><div><?= htmlspecialchars($userName) ?></div><div><?= $isAdmin? 'Quản trị viên' : 'Sinh viên' ?></div></div>
      </div>
      <nav class="sidebar-nav">
        <?php if ($isAdmin): ?>
          <?= navLink('/admin/dashboard','📊','Dashboard',$currentUri) ?>
          <?= navLink('/admin/users','👥','Người dùng',$currentUri) ?>
        <?php else: ?>
          <?= navLink('/student/dashboard','🏠','Trang chủ',$currentUri) ?>
          <?= navLink('/student/profile','👤','Hồ sơ',$currentUri) ?>
        <?php endif; ?>
      </nav>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <div class="topbar-left"><?= $isAdmin ? '⚙️ Admin' : '🎓 Sinh viên' ?> — <?= htmlspecialchars($title ?? '') ?></div>
        <div class="topbar-right"> <a href="#">🔔</a> <span><?= htmlspecialchars($userName) ?></span> </div>
      </header>

      <div class="page-content" style="padding:20px;">
        <?= $content ?>
      </div>
    </main>
  </div>
<?php else: ?>
  <div class="public-layout">
    <header class="public-header">
      <a href="<?= getDynamicUrl('/') ?>"><strong>KTX System</strong></a>
      <nav><a href="<?= getDynamicUrl('/') ?>">Trang chủ</a> <a href="<?= getDynamicUrl('/about') ?>">Giới thiệu</a></nav>
      <div class="public-actions"><a href="<?= getDynamicUrl('/auth/login') ?>">Đăng nhập</a></div>
    </header>

    <main class="public-content" style="padding:20px; max-width:1100px;margin:0 auto;">
      <?= $content ?>
    </main>
  </div>
<?php endif; ?>

<script>
// Simple client-side behavior for alerts
document.addEventListener('click', function (e) {
  if (e.target.matches('.alert-close')) {
    e.target.closest('.alert').remove();
  }
});
</script>
</body>
</html>
