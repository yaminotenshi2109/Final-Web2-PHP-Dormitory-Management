<?php
/**
 * student/notifications/index.php — Thông báo (SV)
 * Variables: $title, $notifications[]
 */
?>

<div class="page-header">
  <div><h1 class="page-title">🔔 Thông báo</h1><p class="page-subtitle">Thông báo từ ban quản lý KTX</p></div>
  <?php if (!empty($notifications)): ?>
    <form method="POST" action="<?= getDynamicUrl('/student/notifications/mark-all-read') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
      <button type="submit" class="btn btn-ghost btn-sm">✅ Đánh dấu tất cả đã đọc</button>
    </form>
  <?php endif; ?>
</div>

<div class="card">
  <?php if (!empty($notifications)): ?>
    <div class="notif-list" style="padding:8px">
      <?php foreach ($notifications as $n): ?>
        <div class="notif-item <?= ($n['is_read'] ?? false) ? '' : 'unread' ?>">
          <div class="notif-dot"></div>
          <div class="notif-body">
            <div class="notif-title"><?= htmlspecialchars($n['title'] ?? '') ?></div>
            <div class="notif-msg"><?= htmlspecialchars($n['message'] ?? '') ?></div>
          </div>
          <div class="notif-time"><?= !empty($n['created_at']) ? date('d/m H:i', strtotime($n['created_at'])) : '' ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🔔</div><div class="empty-title">Chưa có thông báo</div><div class="empty-msg">Bạn sẽ nhận thông báo khi có tin mới.</div></div>
  <?php endif; ?>
</div>
