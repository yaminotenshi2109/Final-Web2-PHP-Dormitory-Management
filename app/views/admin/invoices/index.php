<?php
/**
 * admin/invoices/index.php — Hóa đơn
 * Variables: $title, $invoices[], $stats, $filters
 */
$statusMap = ['unpaid'=>['badge-warning','⏳ Chưa trả'],'paid'=>['badge-success','✅ Đã trả'],'overdue'=>['badge-danger','🔴 Quá hạn'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
?>

<div class="page-header">
  <div><h1 class="page-title">🧾 Quản lý Hóa đơn</h1><p class="page-subtitle">Theo dõi hóa đơn tiền phòng, điện, nước</p></div>
  <div class="page-actions">
    <form method="POST" action="<?= getDynamicUrl('/admin/invoices/generate') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-primary" onclick="return confirm('Tạo hóa đơn cho tháng này?')">⚡ Tạo hóa đơn tháng</button></form>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">🧾</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng hóa đơn</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⏳</div><div><div class="stat-value"><?= number_format($stats['unpaid'] ?? 0) ?></div><div class="stat-label">Chưa thanh toán</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">💰</div><div><div class="stat-value"><?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?>đ</div><div class="stat-label">Đã thu</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">🔴</div><div><div class="stat-value"><?= number_format($stats['overdue'] ?? 0) ?></div><div class="stat-label">Quá hạn</div></div></div>
</div>

<div class="card">
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tên sinh viên...">
    </div>
    <select class="form-control" style="width:auto;min-width:140px">
      <option value="">Tất cả trạng thái</option>
      <option value="unpaid" <?= ($filters['status'] ?? '') === 'unpaid' ? 'selected' : '' ?>>Chưa trả</option>
      <option value="paid" <?= ($filters['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Đã trả</option>
      <option value="overdue" <?= ($filters['status'] ?? '') === 'overdue' ? 'selected' : '' ?>>Quá hạn</option>
    </select>
  </div>

  <?php if (!empty($invoices)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Tháng</th><th>Tiền phòng</th><th>Điện</th><th>Nước</th><th>Tổng</th><th>Hạn nộp</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($invoices as $inv): ?>
            <?php $st = $inv['status'] ?? 'unpaid'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:8px">
                  <div class="avatar avatar-sm"><?= mb_strtoupper(mb_substr($inv['student_name'] ?? 'S', 0, 1)) ?></div>
                  <span style="font-weight:600"><?= htmlspecialchars($inv['student_name'] ?? '') ?></span>
                </div>
              </td>
              <td style="font-weight:600"><?= ($inv['month'] ?? '') . '/' . ($inv['year'] ?? '') ?></td>
              <td><?= number_format($inv['base_rent'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><?= number_format($inv['electricity_fee'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><?= number_format($inv['water_fee'] ?? 0, 0, ',', '.') ?>đ</td>
              <td style="font-weight:800;color:var(--brand)"><?= number_format($inv['total_amount'] ?? 0, 0, ',', '.') ?>đ</td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($inv['due_date']) ? date('d/m/Y', strtotime($inv['due_date'])) : '—' ?></td>
              <td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/invoices/' . ($inv['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <?php if ($st === 'unpaid' || $st === 'overdue'): ?>
                  <form method="POST" action="<?= getDynamicUrl('/admin/invoices/' . ($inv['id'] ?? '') . '/pay') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success btn-sm">💰 Đã trả</button></form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🧾</div><div class="empty-title">Chưa có hóa đơn</div></div>
  <?php endif; ?>
</div>
