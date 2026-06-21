<?php
/**
 * app/views/student/invoices/show.php
 * Student — Chi tiết hóa đơn
 *
 * @var string $title
 * @var array<string,mixed> $invoice
 */

$id = (int)$invoice['id'];
$month = (int)$invoice['month'];
$year = (int)$invoice['year'];
$baseRent = (float)$invoice['base_rent'];
$elec = (float)$invoice['electricity_fee'];
$water = (float)$invoice['water_fee'];
$total = (float)$invoice['total_amount'];
$status = $invoice['status'] ?? 'unpaid';

$statusBadge = match($status) {
    'paid'    => '<span class="badge badge-success">Đã thanh toán</span>',
    'unpaid'  => '<span class="badge badge-warning">Chưa thanh toán</span>',
    'overdue' => '<span class="badge badge-danger">Quá hạn</span>',
    default   => '<span class="badge badge-neutral">' . htmlspecialchars($status) . '</span>'
};
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🧾 Chi tiết hóa đơn</h1>
    <p class="page-subtitle">Hóa đơn tháng <?= $month ?>/<?= $year ?> cho Phòng <?= htmlspecialchars($invoice['room_number']) ?></p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/student/invoices') ?>" class="btn btn-ghost btn-sm">← Quay lại danh sách</a>
  </div>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
  <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h3 class="card-title">🧾 Hóa đơn số #<?= $id ?></h3>
    <?= $statusBadge ?>
  </div>
  
  <div class="card-body" style="display:flex;flex-direction:column;gap:18px;">
    
    <!-- Big total amount card -->
    <div style="text-align:center;background:var(--bg-neutral);padding:24px;border-radius:var(--radius-sm);border:1px solid var(--border);">
      <div style="font-size:11px;color:var(--txt-muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Tổng cộng cần thanh toán</div>
      <strong style="font-size:28px;color:#ef4444;"><?= number_format($total) ?> ₫</strong>
    </div>

    <!-- Breakdown details -->
    <div>
      <h4 style="font-weight:700;color:var(--txt-secondary);margin-bottom:12px;text-transform:uppercase;font-size:12px;letter-spacing:.5px;">📊 Chi tiết các khoản phí</h4>
      <div style="display:flex;flex-direction:column;gap:10px;font-size:14px;">
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);">
          <span style="color:var(--txt-muted);">1. Tiền phòng cơ bản:</span>
          <strong><?= number_format($baseRent) ?> ₫</strong>
        </div>
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);">
          <span style="color:var(--txt-muted);">2. Tiền điện tiêu thụ:</span>
          <strong><?= number_format($elec) ?> ₫</strong>
        </div>
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);">
          <span style="color:var(--txt-muted);">3. Tiền nước tiêu thụ:</span>
          <strong><?= number_format($water) ?> ₫</strong>
        </div>
      </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:12px;font-size:13.5px;margin-top:10px;border-top:1px solid var(--border);padding-top:16px;">
      <div style="display:flex;justify-content:space-between;">
        <span style="color:var(--txt-muted);">Hạn nộp:</span>
        <strong style="color:var(--txt-primary);"><?= !empty($invoice['due_date']) ? date('d/m/Y', strtotime($invoice['due_date'])) : '--' ?></strong>
      </div>
      <?php if ($status === 'paid' && !empty($invoice['paid_at'])): ?>
        <div style="display:flex;justify-content:space-between;">
          <span style="color:var(--txt-muted);">Ngày đóng tiền:</span>
          <strong style="color:var(--txt-primary);"><?= date('d/m/Y H:i', strtotime($invoice['paid_at'])) ?></strong>
        </div>
      <?php endif; ?>
    </div>
  </div>
  
  <div class="card-footer" style="display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;">
    <a href="<?= getDynamicUrl('/student/invoices/' . $id . '/pdf') ?>" target="_blank" rel="noreferrer noopener" class="btn btn-outline" style="display:inline-flex;align-items:center;gap:6px;">
      📥 Tải hóa đơn (PDF)
    </a>
    <?php if ($status !== 'paid'): ?>
      <button class="btn btn-primary" onclick="window.ktx.openModal('paymentModal')">💳 Thanh toán trực tuyến</button>
    <?php endif; ?>
  </div>
</div>

<!-- Payment Modal -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal" style="max-width: 440px;">
        <div class="modal-header">
            <h3 class="modal-title">💳 Thanh toán hóa đơn</h3>
            <button class="modal-close-btn" onclick="window.ktx.closeModal('paymentModal')">&times;</button>
        </div>
        <div class="modal-body" style="display:flex; flex-direction:column; gap:16px; align-items:center; text-align:center;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(99, 102, 241, 0.1); color: var(--brand); display: flex; align-items: center; justify-content: center; margin-bottom: 8px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2" ry="2"/>
                    <line x1="2" y1="10" x2="22" y2="10"/>
                </svg>
            </div>
            
            <p style="font-size:14px; color:var(--txt-secondary); line-height:1.5;">
                Vui lòng chuyển khoản ngân hàng hoặc nộp trực tiếp tại <strong>Văn phòng Ban Quản lý KTX (Phòng 101 - Tòa A)</strong>.
            </p>
            
            <div style="width:100%; text-align:left; background:var(--page-bg); border:1px solid var(--border); border-radius:var(--radius-sm); padding:16px; display:flex; flex-direction:column; gap:8px; font-size:13.5px; margin-top:8px; transition: background-color var(--t), border-color var(--t);">
                <div>Ngân hàng: <strong>BIDV (Chi nhánh Gia Định)</strong></div>
                <div>Số tài khoản: <strong>1241 0000 987654</strong></div>
                <div>Chủ tài khoản: <strong>BQL KTX STUDENT SYSTEM</strong></div>
                <div>Số tiền: <strong style="color:var(--danger);"><?= number_format($total) ?> ₫</strong></div>
                <div>Cú pháp chuyển khoản: <br>
                    <code style="display:inline-block; margin-top:4px; padding:4px 8px; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; font-weight:700; font-family:monospace; color:var(--brand); transition: background-color var(--t), border-color var(--t);">
                        KTX<?= htmlspecialchars($invoice['room_number']) ?> T<?= $month ?> <?= $id ?>
                    </code>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex; gap:12px; justify-content:flex-end; width:100%;">
            <button onclick="window.ktx.closeModal('paymentModal')" class="btn btn-outline" style="flex:1;">Đóng</button>
            <button onclick="copySyntax()" class="btn btn-primary" style="flex:1;">Sao chép cú pháp</button>
        </div>
    </div>
</div>

<script>
function copySyntax() {
    const text = 'KTX<?= htmlspecialchars($invoice['room_number']) ?> T<?= $month ?> <?= $id ?>';
    navigator.clipboard.writeText(text).then(() => {
        window.ktx?.toast('Đã sao chép cú pháp chuyển khoản.', 'success');
    }).catch(err => {
        window.ktx?.toast('Không thể sao chép tự động.', 'error');
    });
}
</script>
