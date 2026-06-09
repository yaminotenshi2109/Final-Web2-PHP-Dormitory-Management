<?php
/**
 * admin/utilities/index.php — Chỉ số điện nước
 * Variables: $title, $readings[], $stats, $filters
 */
?>

<div class="page-header">
  <div><h1 class="page-title">⚡ Chỉ số Điện Nước</h1><p class="page-subtitle">Ghi nhận và theo dõi chỉ số điện, nước theo phòng</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/utilities/create') ?>" class="btn btn-primary">+ Nhập chỉ số mới</a>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⚡</div><div><div class="stat-value"><?= number_format($stats['total_readings'] ?? 0) ?></div><div class="stat-label">Tổng bản ghi</div></div></div>
  <div class="stat-card" style="--stat-color:#3b82f6;--stat-icon-bg:#eff6ff"><div class="stat-icon">💧</div><div><div class="stat-value"><?= number_format($stats['avg_water'] ?? 0, 1) ?> m³</div><div class="stat-label">TB nước/phòng</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">🔌</div><div><div class="stat-value"><?= number_format($stats['avg_elec'] ?? 0, 1) ?> kWh</div><div class="stat-label">TB điện/phòng</div></div></div>
</div>

<div class="card">
  <div class="filter-bar">
    <select class="form-control" style="width:auto;min-width:120px">
      <option value="">Tháng</option>
      <?php for ($m = 1; $m <= 12; $m++): ?><option value="<?= $m ?>" <?= ($filters['month'] ?? '') == $m ? 'selected' : '' ?>>Tháng <?= $m ?></option><?php endfor; ?>
    </select>
    <select class="form-control" style="width:auto;min-width:100px">
      <option value="">Năm</option>
      <?php for ($y = date('Y'); $y >= 2024; $y--): ?><option value="<?= $y ?>" <?= ($filters['year'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option><?php endfor; ?>
    </select>
  </div>

  <?php if (!empty($readings)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Phòng</th><th>Tháng/Năm</th><th>Điện đầu kỳ</th><th>Điện cuối kỳ</th><th>Tiêu thụ (kWh)</th><th>Nước đầu kỳ</th><th>Nước cuối kỳ</th><th>Tiêu thụ (m³)</th><th>Người ghi</th></tr></thead>
        <tbody>
          <?php foreach ($readings as $rd): ?>
            <?php $elecUsage = ($rd['elec_curr'] ?? 0) - ($rd['elec_prev'] ?? 0); $waterUsage = ($rd['water_curr'] ?? 0) - ($rd['water_prev'] ?? 0); ?>
            <tr>
              <td style="font-weight:700"><?= htmlspecialchars($rd['room_number'] ?? '') ?><div class="sub"><?= htmlspecialchars($rd['building_name'] ?? '') ?></div></td>
              <td><?= ($rd['month'] ?? '') . '/' . ($rd['year'] ?? '') ?></td>
              <td style="color:var(--txt-muted)"><?= number_format($rd['elec_prev'] ?? 0, 1) ?></td>
              <td style="font-weight:600"><?= number_format($rd['elec_curr'] ?? 0, 1) ?></td>
              <td style="font-weight:700;color:var(--warning)"><?= number_format($elecUsage, 1) ?></td>
              <td style="color:var(--txt-muted)"><?= number_format($rd['water_prev'] ?? 0, 1) ?></td>
              <td style="font-weight:600"><?= number_format($rd['water_curr'] ?? 0, 1) ?></td>
              <td style="font-weight:700;color:var(--info)"><?= number_format($waterUsage, 1) ?></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= htmlspecialchars($rd['recorder_name'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">⚡</div><div class="empty-title">Chưa có dữ liệu</div><div class="empty-msg">Nhập chỉ số điện nước để bắt đầu theo dõi.</div></div>
  <?php endif; ?>
</div>
