<?php
$messages = $messages ?? $_flash ?? [];
if (empty($messages)) return;

$classes = [
    'success' => 'alert-success',
    'error'   => 'alert-error',
    'danger'  => 'alert-error',
    'warning' => 'alert-warning',
    'info'    => 'alert-info',
];
?>

<?php foreach ($messages as $msg): ?>
  <?php $cls = $classes[$msg['type'] ?? 'info'] ?? 'alert-info'; ?>
  <div class="alert <?= $cls ?>">
    <div class="alert-content">
      <p class="alert-msg"><?= htmlspecialchars($msg['message'] ?? '') ?></p>
    </div>
    <button class="alert-close" title="Đóng" aria-label="Đóng">×</button>
  </div>
<?php endforeach; ?>
