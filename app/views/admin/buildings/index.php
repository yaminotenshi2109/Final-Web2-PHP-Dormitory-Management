<?php
/**
 * admin/buildings/index.php — Danh sách tòa nhà
 * Variables: $title, $buildings[], $stats
 */
$statusMap = [
  'active'      => ['badge-success', '✅ Hoạt động'],
  'maintenance' => ['badge-warning', '🔧 Bảo trì'],
  'closed'      => ['badge-danger',  '🚫 Đóng cửa'],
];
$genderMap = [
  'male'   => '👨 Nam',
  'female' => '👩 Nữ',
  'mixed'  => '👥 Hỗn hợp',
];
?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <h1 class="page-title">🏢 Quản lý Tòa nhà</h1>
    <p class="page-subtitle">Quản lý các tòa nhà trong khu ký túc xá</p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/buildings/create') ?>" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Thêm tòa nhà
    </a>
  </div>
</div>

<!-- Stat Cards -->
<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff">
    <div class="stat-icon">🏢</div>
    <div>
      <div class="stat-value"><?= number_format($stats['total'] ?? count($buildings ?? [])) ?></div>
      <div class="stat-label">Tổng tòa nhà</div>
    </div>
  </div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5">
    <div class="stat-icon">✅</div>
    <div>
      <div class="stat-value"><?= number_format($stats['active'] ?? 0) ?></div>
      <div class="stat-label">Đang hoạt động</div>
    </div>
  </div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7">
    <div class="stat-icon">🚪</div>
    <div>
      <div class="stat-value"><?= number_format($stats['total_rooms'] ?? 0) ?></div>
      <div class="stat-label">Tổng phòng</div>
    </div>
  </div>
</div>

<!-- Buildings Table -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Danh sách tòa nhà</div>
  </div>

  <?php if (!empty($buildings)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead>
          <tr>
            <th>Tòa nhà</th>
            <th>Số tầng</th>
            <th>Giới tính</th>
            <th>Quản lý</th>
            <th>Trạng thái</th>
            <th style="text-align:right">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($buildings as $b): ?>
            <?php
              $status = $b['status'] ?? 'active';
              [$badgeClass, $statusLabel] = $statusMap[$status] ?? ['badge-neutral', $status];
            ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-md" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:14px">
                    <?= htmlspecialchars(mb_substr($b['name'] ?? 'T', 0, 2)) ?>
                  </div>
                  <div>
                    <div style="font-weight:700"><?= htmlspecialchars($b['name'] ?? '') ?></div>
                    <div class="sub"><?= htmlspecialchars($b['address'] ?? '') ?></div>
                  </div>
                </div>
              </td>
              <td><span style="font-weight:600"><?= $b['total_floors'] ?? 0 ?></span> tầng</td>
              <td><?= $genderMap[$b['gender_type'] ?? ''] ?? '—' ?></td>
              <td>
                <div style="font-weight:600;font-size:13px"><?= htmlspecialchars($b['manager_name'] ?? '—') ?></div>
                <div class="sub"><?= htmlspecialchars($b['manager_phone'] ?? '') ?></div>
              </td>
              <td><span class="badge <?= $badgeClass ?>"><?= $statusLabel ?></span></td>
              <td style="text-align:right">
                <div style="display:flex;gap:6px;justify-content:flex-end">
                  <a href="<?= getDynamicUrl('/admin/buildings/' . ($b['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Xem
                  </a>
                  <a href="<?= getDynamicUrl('/admin/buildings/' . ($b['id'] ?? '') . '/edit') ?>" class="btn btn-outline btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Sửa
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <div class="empty-icon">🏢</div>
      <div class="empty-title">Chưa có tòa nhà</div>
      <div class="empty-msg">Bắt đầu bằng cách thêm tòa nhà đầu tiên vào hệ thống.</div>
      <a href="<?= getDynamicUrl('/admin/buildings/create') ?>" class="btn btn-primary mt-16">Thêm tòa nhà</a>
    </div>
  <?php endif; ?>
</div>
