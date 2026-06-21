<?php
/**
 * student/invoices/index.php — Hóa đơn sinh viên
 * Variables: $title, $invoices[], $summary
 */
$statusMap = ['unpaid'=>['badge-warning','⏳ Chưa trả'],'paid'=>['badge-success','✅ Đã trả'],'overdue'=>['badge-danger','🔴 Quá hạn']];
?>

<div class="page-header">
  <div><h1 class="page-title">🧾 Hóa đơn</h1><p class="page-subtitle">Theo dõi hóa đơn tiền phòng, điện, nước</p></div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⏳</div><div><div class="stat-value"><?= number_format($summary['unpaid_total'] ?? 0, 0, ',', '.') ?>đ</div><div class="stat-label">Cần thanh toán</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($summary['paid_total'] ?? 0, 0, ',', '.') ?>đ</div><div class="stat-label">Đã thanh toán</div></div></div>
</div>

<?php if (!empty($invoices)): ?>
  <div style="display:flex;flex-direction:column;gap:12px">
    <?php foreach ($invoices as $inv): ?>
      <?php $st = $inv['status'] ?? 'unpaid'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
      <div class="invoice-card">
        <div class="invoice-icon">🧾</div>
        <div class="invoice-info">
          <div class="invoice-month">Tháng <?= ($inv['month'] ?? '') . '/' . ($inv['year'] ?? '') ?></div>
          <div class="invoice-detail">
            Phòng: <?= number_format($inv['base_rent'] ?? 0, 0, ',', '.') ?>đ
            • Điện: <?= number_format($inv['electricity_fee'] ?? 0, 0, ',', '.') ?>đ
            • Nước: <?= number_format($inv['water_fee'] ?? 0, 0, ',', '.') ?>đ
          </div>
          <div class="invoice-detail">Hạn: <?= !empty($inv['due_date']) ? date('d/m/Y', strtotime($inv['due_date'])) : '—' ?></div>
        </div>
        <div style="text-align:right">
          <div class="invoice-amount"><?= number_format($inv['total_amount'] ?? 0, 0, ',', '.') ?>đ</div>
          <span class="badge <?= $bClass ?>" style="margin-top:4px"><?= $bLabel ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="card">
    <div class="empty-state"><div class="empty-icon">🧾</div><div class="empty-title">Chưa có hóa đơn</div><div class="empty-msg">Hóa đơn sẽ xuất hiện sau khi bạn có hợp đồng.</div></div>
  </div>
<?php endif; ?>
