<?php
/**
 * admin/reports/revenue.php — Báo cáo doanh thu
 * Variables: $title, $report, $monthlyData[]
 */
$months = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];
$maxRevenue = 1;
if (!empty($monthlyData)) { foreach ($monthlyData as $md) { $maxRevenue = max($maxRevenue, $md['total'] ?? 0); } }
?>

<div class="page-header">
  <div><h1 class="page-title">📈 Báo cáo Doanh thu</h1><p class="page-subtitle">Thống kê doanh thu phòng KTX theo thời gian</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/reports/occupancy') ?>" class="btn btn-ghost">📊 Lấp đầy</a>
    <a href="<?= getDynamicUrl('/admin/reports/violations') ?>" class="btn btn-ghost">⚠️ Vi phạm</a>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">💰</div><div><div class="stat-value"><?= number_format($report['total_revenue'] ?? 0, 0, ',', '.') ?>đ</div><div class="stat-label">Tổng doanh thu</div></div></div>
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">🧾</div><div><div class="stat-value"><?= number_format($report['total_invoices'] ?? 0) ?></div><div class="stat-label">Tổng hóa đơn</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⏳</div><div><div class="stat-value"><?= number_format($report['unpaid_amount'] ?? 0, 0, ',', '.') ?>đ</div><div class="stat-label">Chưa thu</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">📉</div><div><div class="stat-value"><?= number_format($report['collection_rate'] ?? 0, 1) ?>%</div><div class="stat-label">Tỷ lệ thu</div></div></div>
</div>

<div class="grid-2 mb-24">
  <!-- Revenue Chart -->
  <div class="card">
    <div class="card-header"><div class="card-title">📊 Doanh thu theo tháng</div></div>
    <div class="card-body">
      <div class="bar-chart">
        <?php foreach ($monthlyData ?? [] as $i => $md): ?>
          <?php $pct = ($md['total'] ?? 0) / $maxRevenue * 100; ?>
          <div class="bar-row">
            <div class="bar-label"><?= $months[$i] ?? '' ?></div>
            <div class="bar-track"><div class="bar-fill" style="width:<?= $pct ?>%"></div></div>
            <div class="bar-value"><?= number_format(($md['total'] ?? 0) / 1000000, 1) ?>M</div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Revenue by type -->
  <div class="card">
    <div class="card-header"><div class="card-title">💵 Phân loại doanh thu</div></div>
    <div class="card-body">
      <div style="display:flex;flex-direction:column;gap:16px">
        <div>
          <div style="display:flex;justify-content:space-between;margin-bottom:6px">
            <span style="font-size:13px;font-weight:600">Tiền phòng</span>
            <span style="font-weight:700;color:var(--brand)"><?= number_format($report['rent_total'] ?? 0, 0, ',', '.') ?>đ</span>
          </div>
          <div class="progress"><div class="progress-bar" style="width:<?= ($report['rent_pct'] ?? 60) ?>%"></div></div>
        </div>
        <div>
          <div style="display:flex;justify-content:space-between;margin-bottom:6px">
            <span style="font-size:13px;font-weight:600">Tiền điện</span>
            <span style="font-weight:700;color:var(--warning)"><?= number_format($report['elec_total'] ?? 0, 0, ',', '.') ?>đ</span>
          </div>
          <div class="progress"><div class="progress-bar warning" style="width:<?= ($report['elec_pct'] ?? 25) ?>%"></div></div>
        </div>
        <div>
          <div style="display:flex;justify-content:space-between;margin-bottom:6px">
            <span style="font-size:13px;font-weight:600">Tiền nước</span>
            <span style="font-weight:700;color:var(--info)"><?= number_format($report['water_total'] ?? 0, 0, ',', '.') ?>đ</span>
          </div>
          <div class="progress"><div class="progress-bar" style="width:<?= ($report['water_pct'] ?? 15) ?>%;background:linear-gradient(90deg,var(--info),#67e8f9)"></div></div>
        </div>
      </div>
    </div>
  </div>
</div>
