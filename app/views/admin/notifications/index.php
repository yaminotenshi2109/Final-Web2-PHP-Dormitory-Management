<?php
/**
 * admin/notifications/index.php — Thông báo
 * Variables: $title, $notifications[], $stats
 */
?>

<div class="page-header">
  <div><h1 class="page-title">🔔 Quản lý Thông báo</h1><p class="page-subtitle">Gửi và quản lý thông báo cho sinh viên</p></div>
  <div class="page-actions"><a href="<?= getDynamicUrl('/admin/notifications/send') ?>" class="btn btn-primary">✉️ Gửi thông báo</a></div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">🔔</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng thông báo</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($stats['read'] ?? 0) ?></div><div class="stat-label">Đã đọc</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">📩</div><div><div class="stat-value"><?= number_format($stats['unread'] ?? 0) ?></div><div class="stat-label">Chưa đọc</div></div></div>
</div>

<div class="card">
  <?php if (!empty($notifications)): ?>
    <div class="notif-list" style="padding:8px">
      <?php foreach ($notifications as $n): ?>
        <div class="notif-item <?= ($n['is_read'] ?? false) ? '' : 'unread' ?>">
          <div class="notif-dot"></div>
          <div class="notif-body">
            <div class="notif-title"><?= htmlspecialchars($n['title'] ?? '') ?></div>
            <div class="notif-msg"><?= htmlspecialchars(mb_strimwidth($n['message'] ?? '', 0, 120, '...')) ?></div>
            <div style="display:flex;gap:8px;margin-top:6px;font-size:11px;color:var(--txt-muted)">
              <span>👤 <?= htmlspecialchars($n['target'] ?? 'Tất cả') ?></span>
              <span>•</span>
              <span>Loại: <?= htmlspecialchars($n['type'] ?? 'general') ?></span>
            </div>
          </div>
          <div class="notif-time"><?= !empty($n['created_at']) ? date('d/m H:i', strtotime($n['created_at'])) : '' ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🔔</div><div class="empty-title">Chưa có thông báo</div><div class="empty-msg">Gửi thông báo đầu tiên cho sinh viên.</div></div>
  <?php endif; ?>
</div>
