<?php
/**
 * admin/invoices/show.php — Chi tiết hóa đơn
 * Variables: $title, $invoice, $_csrfToken
 */
$inv = $invoice ?? [];
$statusMap = ['unpaid'=>['badge-warning','⏳ Chưa trả'],'paid'=>['badge-success','✅ Đã trả'],'overdue'=>['badge-danger','🔴 Quá hạn'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
$st = $inv['status'] ?? 'unpaid'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st];
?>

<div class="page-header">
  <div><h1 class="page-title">🧾 Hóa đơn #<?= $inv['id'] ?? '' ?></h1><p class="page-subtitle">Tháng <?= ($inv['month'] ?? '') . '/' . ($inv['year'] ?? '') ?></p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/invoices') ?>" class="btn btn-ghost">← Quay lại</a>
    <?php if ($st === 'unpaid' || $st === 'overdue'): ?>
      <form method="POST" action="<?= getDynamicUrl('/admin/invoices/' . ($inv['id'] ?? '') . '/pay') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success" onclick="return confirm('Đánh dấu đã thanh toán?')">💰 Đánh dấu đã trả</button></form>
    <?php endif; ?>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Chi tiết hóa đơn</div></div>
    <div class="card-body">
      <div style="text-align:center;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--border)">
        <div style="font-size:36px;font-weight:900;color:var(--brand)"><?= number_format($inv['total_amount'] ?? 0, 0, ',', '.') ?> VND</div>
        <span class="badge <?= $bClass ?>" style="margin-top:8px"><?= $bLabel ?></span>
      </div>

      <div style="display:flex;flex-direction:column;gap:12px">
        <div style="display:flex;justify-content:space-between;padding:12px;background:var(--page-bg);border-radius:var(--radius-sm)">
          <span style="color:var(--txt-secondary)">🏠 Tiền phòng</span>
          <span style="font-weight:700"><?= number_format($inv['base_rent'] ?? 0, 0, ',', '.') ?>đ</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:12px;background:var(--page-bg);border-radius:var(--radius-sm)">
          <span style="color:var(--txt-secondary)">⚡ Tiền điện</span>
          <span style="font-weight:700"><?= number_format($inv['electricity_fee'] ?? 0, 0, ',', '.') ?>đ</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:12px;background:var(--page-bg);border-radius:var(--radius-sm)">
          <span style="color:var(--txt-secondary)">💧 Tiền nước</span>
          <span style="font-weight:700"><?= number_format($inv['water_fee'] ?? 0, 0, ',', '.') ?>đ</span>
        </div>
        <?php if (($inv['extra_fee'] ?? 0) > 0): ?>
        <div style="display:flex;justify-content:space-between;padding:12px;background:var(--page-bg);border-radius:var(--radius-sm)">
          <span style="color:var(--txt-secondary)">📎 Phụ phí</span>
          <span style="font-weight:700"><?= number_format($inv['extra_fee'] ?? 0, 0, ',', '.') ?>đ</span>
        </div>
        <?php endif; ?>
      </div>

      <div style="margin-top:16px;padding-top:12px;border-top:2px solid var(--border);display:flex;justify-content:space-between;font-weight:800;font-size:16px">
        <span>Tổng cộng</span>
        <span style="color:var(--brand)"><?= number_format($inv['total_amount'] ?? 0, 0, ',', '.') ?> VND</span>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin</div></div>
    <div class="card-body">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:120px">Sinh viên</td><td style="font-weight:600"><?= htmlspecialchars($inv['student_name'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Mã SV</td><td style="font-family:monospace"><?= htmlspecialchars($inv['student_code'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Phòng</td><td style="font-weight:700"><?= htmlspecialchars($inv['room_number'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Hạn nộp</td><td style="font-weight:600;color:<?= $st === 'overdue' ? 'var(--danger)' : 'var(--txt-primary)' ?>"><?= !empty($inv['due_date']) ? date('d/m/Y', strtotime($inv['due_date'])) : '—' ?></td></tr>
        <?php if (!empty($inv['paid_at'])): ?>
          <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày trả</td><td style="color:var(--success);font-weight:600"><?= date('d/m/Y H:i', strtotime($inv['paid_at'])) ?></td></tr>
        <?php endif; ?>
      </table>

      <?php if (!empty($inv['electricity_usage']) || !empty($inv['water_usage'])): ?>
        <div style="margin-top:20px;padding:16px;background:var(--page-bg);border-radius:var(--radius-sm)">
          <div style="font-weight:700;font-size:13px;margin-bottom:8px">📊 Chỉ số tiêu thụ</div>
          <div style="display:flex;gap:24px;font-size:14px">
            <div>⚡ <?= number_format($inv['electricity_usage'] ?? 0, 1) ?> kWh</div>
            <div>💧 <?= number_format($inv['water_usage'] ?? 0, 1) ?> m³</div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
