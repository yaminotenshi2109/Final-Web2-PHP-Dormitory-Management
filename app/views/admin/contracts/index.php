<?php
/**
 * admin/contracts/index.php — Hợp đồng
 * Variables: $title, $contracts[], $stats, $filters
 */
$statusMap = ['active'=>['badge-success','✅ Đang hiệu lực'],'expired'=>['badge-neutral','⏰ Hết hạn'],'terminated'=>['badge-danger','🚫 Chấm dứt'],'under_review'=>['badge-warning','⚠️ Đang xem xét']];
?>

<div class="page-header">
  <div><h1 class="page-title">📄 Quản lý Hợp đồng</h1><p class="page-subtitle">Theo dõi hợp đồng thuê phòng KTX</p></div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">📄</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng hợp đồng</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($stats['active'] ?? 0) ?></div><div class="stat-label">Đang hiệu lực</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⚠️</div><div><div class="stat-value"><?= number_format($stats['under_review'] ?? 0) ?></div><div class="stat-label">Đang xem xét</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">⏰</div><div><div class="stat-value"><?= number_format($stats['expired'] ?? 0) ?></div><div class="stat-label">Hết hạn</div></div></div>
</div>

<div class="card">
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tên sinh viên..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
    </div>
    <select class="form-control" style="width:auto;min-width:140px">
      <option value="">Tất cả trạng thái</option>
      <?php foreach ($statusMap as $k => $v): ?><option value="<?= $k ?>" <?= ($filters['status'] ?? '') === $k ? 'selected' : '' ?>><?= $v[1] ?></option><?php endforeach; ?>
    </select>
  </div>

  <?php if (!empty($contracts)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Phòng</th><th>Thời hạn</th><th>Phí/tháng</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($contracts as $c): ?>
            <?php $st = $c['status'] ?? 'active'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-sm"><?= mb_strtoupper(mb_substr($c['student_name'] ?? 'S', 0, 1)) ?></div>
                  <div><div style="font-weight:600"><?= htmlspecialchars($c['student_name'] ?? '') ?></div><div class="sub"><?= htmlspecialchars($c['student_code'] ?? '') ?></div></div>
                </div>
              </td>
              <td><span style="font-weight:700"><?= htmlspecialchars($c['room_number'] ?? '') ?></span><div class="sub"><?= htmlspecialchars($c['building_name'] ?? '') ?></div></td>
              <td><div style="font-size:13px"><?= !empty($c['start_date']) ? date('d/m/Y', strtotime($c['start_date'])) : '' ?></div><div class="sub">→ <?= !empty($c['end_date']) ? date('d/m/Y', strtotime($c['end_date'])) : '' ?></div></td>
              <td style="font-weight:700"><?= number_format($c['monthly_fee'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/contracts/' . ($c['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <?php if ($st === 'active'): ?>
                  <form method="POST" action="<?= getDynamicUrl('/admin/contracts/' . ($c['id'] ?? '') . '/terminate') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-danger-outline btn-sm" onclick="return confirm('Chấm dứt hợp đồng?')">Chấm dứt</button></form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">📄</div><div class="empty-title">Chưa có hợp đồng</div></div>
  <?php endif; ?>
</div>
