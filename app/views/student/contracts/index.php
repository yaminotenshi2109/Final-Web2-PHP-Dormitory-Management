<?php
/**
 * student/contracts/index.php — Hợp đồng sinh viên
 * Variables: $title, $contracts[]
 */
$statusMap = ['active'=>['badge-success','✅ Đang hiệu lực'],'expired'=>['badge-neutral','⏰ Hết hạn'],'terminated'=>['badge-danger','🚫 Chấm dứt']];
?>

<div class="page-header">
  <div><h1 class="page-title">📄 Hợp đồng</h1><p class="page-subtitle">Hợp đồng thuê phòng KTX của bạn</p></div>
</div>

<?php if (!empty($contracts)): ?>
  <div style="display:flex;flex-direction:column;gap:12px">
    <?php foreach ($contracts as $c): ?>
      <?php $st = $c['status'] ?? 'active'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
      <div class="card">
        <div class="card-body">
          <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:16px">
            <div class="stat-icon" style="width:56px;height:56px;font-size:24px;background:var(--brand-light);color:var(--brand)">📄</div>
            <div style="flex:1;min-width:200px">
              <div style="font-weight:700;font-size:16px">Phòng <?= htmlspecialchars($c['room_number'] ?? '') ?> — <?= htmlspecialchars($c['building_name'] ?? '') ?></div>
              <div style="color:var(--txt-muted);font-size:13px;margin-top:2px">Phí: <strong style="color:var(--brand)"><?= number_format($c['monthly_fee'] ?? 0, 0, ',', '.') ?>đ</strong>/tháng</div>
            </div>
            <span class="badge <?= $bClass ?>"><?= $bLabel ?></span>
          </div>

          <div class="grid-3" style="gap:12px">
            <div style="padding:12px;background:var(--page-bg);border-radius:var(--radius-sm);text-align:center">
              <div style="font-size:12px;color:var(--txt-muted);margin-bottom:4px">Bắt đầu</div>
              <div style="font-weight:700"><?= !empty($c['start_date']) ? date('d/m/Y', strtotime($c['start_date'])) : '—' ?></div>
            </div>
            <div style="padding:12px;background:var(--page-bg);border-radius:var(--radius-sm);text-align:center">
              <div style="font-size:12px;color:var(--txt-muted);margin-bottom:4px">Kết thúc</div>
              <div style="font-weight:700"><?= !empty($c['end_date']) ? date('d/m/Y', strtotime($c['end_date'])) : '—' ?></div>
            </div>
            <div style="padding:12px;background:var(--page-bg);border-radius:var(--radius-sm);text-align:center">
              <div style="font-size:12px;color:var(--txt-muted);margin-bottom:4px">Đặt cọc</div>
              <div style="font-weight:700;color:var(--warning)"><?= number_format($c['deposit_amount'] ?? 0, 0, ',', '.') ?>đ</div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="card">
    <div class="empty-state"><div class="empty-icon">📄</div><div class="empty-title">Chưa có hợp đồng</div><div class="empty-msg">Bạn chưa có hợp đồng nào. Hãy đăng ký phòng trước.</div></div>
  </div>
<?php endif; ?>