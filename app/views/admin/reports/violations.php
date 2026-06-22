<?php
/**
 * admin/reports/violations.php — Báo cáo vi phạm
 * Variables: $title, $report, $typeData[], $monthlyData[]
 */
$months = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];
$maxVio = 1;
if (!empty($monthlyData)) { foreach ($monthlyData as $md) { $maxVio = max($maxVio, $md['count'] ?? 0); } }
?>

<div class="page-header">
  <div><h1 class="page-title"> Báo cáo Vi phạm</h1><p class="page-subtitle">Thống kê vi phạm nội quy KTX</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/reports/revenue') ?>" class="btn btn-ghost"> Doanh thu</a>
    <a href="<?= getDynamicUrl('/admin/reports/occupancy') ?>" class="btn btn-ghost"> Lấp đầy</a>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['total'] ?? 0) ?></div><div class="stat-label">Tổng vi phạm</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['total_points'] ?? 0) ?></div><div class="stat-label">Tổng điểm phạt</div></div></div>
  <div class="stat-card" style="--stat-color:#8b5cf6;--stat-icon-bg:#ede9fe"><div class="stat-icon"></div><div><div class="stat-value"><?= number_format($report['students_involved'] ?? 0) ?></div><div class="stat-label">SV vi phạm</div></div></div>
</div>

<div class="grid-2 mb-24">
  <!-- Monthly trend -->
  <div class="card">
    <div class="card-header"><div class="card-title"> Theo tháng</div></div>
    <div class="card-body">
      <div class="bar-chart">
        <?php foreach ($monthlyData ?? [] as $i => $md): ?>
          <?php $pct = ($md['count'] ?? 0) / $maxVio * 100; ?>
          <div class="bar-row">
            <div class="bar-label"><?= $months[$i] ?? '' ?></div>
            <div class="bar-track"><div class="bar-fill" style="width:<?= $pct ?>%;background:linear-gradient(90deg,#ef4444,#f87171)"></div></div>
            <div class="bar-value"><?= $md['count'] ?? 0 ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- By type -->
  <div class="card">
    <div class="card-header"><div class="card-title"> Theo loại vi phạm</div></div>
    <div class="card-body">
      <?php if (!empty($typeData)): ?>
        <div style="display:flex;flex-direction:column;gap:12px">
          <?php foreach ($typeData as $td): ?>
            <?php $typePct = ($report['total'] ?? 1) > 0 ? ($td['count'] ?? 0) / $report['total'] * 100 : 0; ?>
            <div>
              <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                <span style="font-size:13px;font-weight:600"><?= htmlspecialchars($td['type'] ?? '') ?></span>
                <span style="font-weight:700;color:var(--danger)"><?= $td['count'] ?? 0 ?> <span style="font-weight:400;color:var(--txt-muted);font-size:12px">(<?= number_format($typePct, 0) ?>%)</span></span>
              </div>
              <div class="progress"><div class="progress-bar danger" style="width:<?= $typePct ?>%"></div></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty-state" style="padding:32px"><div class="empty-title">Không có dữ liệu</div></div>
      <?php endif; ?>
    </div>
  </div>
</div>
