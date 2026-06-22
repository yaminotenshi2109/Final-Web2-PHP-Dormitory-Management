<?php
/**
 * admin/reports/occupancy.php — Báo cáo lấp đầy
 * Variables: $title, $report, $buildingData[]
 */
?>

<div class="page-header">
  <div><h1 class="page-title"> Báo cáo Lấp đầy</h1><p class="page-subtitle">Thống kê tỷ lệ sử dụng phòng KTX</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/reports/revenue') ?>" class="btn btn-ghost"> Doanh thu</a>
    <a href="<?= getDynamicUrl('/admin/reports/violations') ?>" class="btn btn-ghost"> Vi phạm</a>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['total_rooms'] ?? 0) ?></div><div class="stat-label">Tổng phòng</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['total_beds'] ?? 0) ?></div><div class="stat-label">Tổng giường</div></div></div>
  <div class="stat-card" style="--stat-color:#8b5cf6;--stat-icon-bg:#ede9fe"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['occupied'] ?? 0) ?></div><div class="stat-label">Đang sử dụng</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['occupancy_rate'] ?? 0, 1) ?>%</div><div class="stat-label">Tỷ lệ lấp đầy</div></div></div>
</div>

<!-- Overall donut -->
<div class="grid-2 mb-24">
  <div class="card">
    <div class="card-header"><div class="card-title">Tổng quan lấp đầy</div></div>
    <div class="card-body" style="display:flex;align-items:center;justify-content:center;padding:40px">
      <div class="donut-ring" style="--pct:<?= ($report['occupancy_rate'] ?? 0) * 3.6 ?>deg;width:140px;height:140px">
        <div class="donut-value" style="font-size:28px"><?= number_format($report['occupancy_rate'] ?? 0, 1) ?>%</div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><div class="card-title">Theo tòa nhà</div></div>
    <div class="card-body">
      <div class="bar-chart">
        <?php foreach ($buildingData ?? [] as $bd): ?>
          <?php $pct = ($bd['capacity'] ?? 1) > 0 ? ($bd['occupied'] ?? 0) / $bd['capacity'] * 100 : 0; ?>
          <div class="bar-row">
            <div class="bar-label"><?= htmlspecialchars($bd['name'] ?? '') ?></div>
            <div class="bar-track"><div class="bar-fill" style="width:<?= $pct ?>%;background:linear-gradient(90deg,<?= $pct > 90 ? 'var(--danger),#f87171' : ($pct > 70 ? 'var(--warning),#fbbf24' : 'var(--success),#34d399') ?>)"></div></div>
            <div class="bar-value"><?= number_format($pct, 0) ?>%</div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- Details table -->
<div class="card">
  <div class="card-header"><div class="card-title">Chi tiết theo tòa nhà</div></div>
  <?php if (!empty($buildingData)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Tòa nhà</th><th>Tổng phòng</th><th>Sức chứa</th><th>Đang ở</th><th>Còn trống</th><th>Tỷ lệ</th></tr></thead>
        <tbody>
          <?php foreach ($buildingData as $bd): ?>
            <?php $pct = ($bd['capacity'] ?? 1) > 0 ? ($bd['occupied'] ?? 0) / $bd['capacity'] * 100 : 0; ?>
            <tr>
              <td style="font-weight:700"><?= htmlspecialchars($bd['name'] ?? '') ?></td>
              <td><?= $bd['rooms'] ?? 0 ?></td>
              <td><?= $bd['capacity'] ?? 0 ?></td>
              <td style="font-weight:600"><?= $bd['occupied'] ?? 0 ?></td>
              <td style="color:var(--success)"><?= ($bd['capacity'] ?? 0) - ($bd['occupied'] ?? 0) ?></td>
              <td>
                <div style="display:flex;align-items:center;gap:8px">
                  <div class="progress" style="width:80px;height:6px"><div class="progress-bar <?= $pct > 90 ? 'danger' : ($pct > 70 ? 'warning' : 'success') ?>" style="width:<?= $pct ?>%"></div></div>
                  <span style="font-weight:700;font-size:13px"><?= number_format($pct, 1) ?>%</span>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state" style="padding:40px"><div class="empty-icon" aria-hidden="true"></div><div class="empty-title">Chưa có dữ liệu</div></div>
  <?php endif; ?>
</div>
