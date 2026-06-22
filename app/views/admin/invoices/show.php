<?php
/**
 * app/views/admin/invoices/show.php
 * Chi tiết hóa đơn dành cho Admin
 */
/** @var array $invoice */
?>

<div class="invoice-page">
    <div class="page-header invoice-page-header">
        <div>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices" class="btn btn-secondary invoice-back-btn">
                ⬅ Quay lại danh sách
            </a>
            <h1 class="page-title">Chi tiết hóa đơn #<?= htmlspecialchars($invoice['id']) ?></h1>
            <p class="page-subtitle">Kỳ thanh toán: Tháng <?= $invoice['month'] ?>/<?= $invoice['year'] ?></p>
        </div>

        <div class="page-header-actions">
            <a href="/Final-Web2-PHP-Dormitory-Management/public/api/invoices/<?= $invoice['id'] ?>/pdf" target="_blank" class="btn btn-primary">
                 In / Tải PDF
            </a>
            <?php if ($invoice['status'] === 'unpaid' || $invoice['status'] === 'overdue'): ?>
                <button type="button" class="btn btn-success" onclick="openPaymentModal()">
                     Xác nhận thanh toán
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="invoice-grid">
        <div class="invoice-main">
            <section class="card invoice-section">
                <div class="card-header">
                    <h3 class="card-title">Thông tin chung</h3>
                </div>
                <div class="card-body invoice-meta-grid">
                    <div class="invoice-meta-item">
                        <span>Sinh viên</span>
                        <strong><?= htmlspecialchars($invoice['full_name']) ?></strong>
                        <span>MSSV: <?= htmlspecialchars($invoice['student_code']) ?></span>
                    </div>
                    <div class="invoice-meta-item">
                        <span>Phòng &amp; Tòa</span>
                        <strong>Phòng <?= htmlspecialchars($invoice['room_number']) ?></strong>
                        <span>Tòa: <?= htmlspecialchars($invoice['building_name']) ?></span>
                    </div>
                    <div class="invoice-meta-item">
                        <span>Hạn thanh toán</span>
                        <strong><?= date('d/m/Y', strtotime($invoice['due_date'])) ?></strong>
                    </div>
                    <div class="invoice-meta-item">
                        <span>Trạng thái</span>
                        <?php
                        $statusCls = match($invoice['status']) {
                            'paid' => 'badge-success',
                            'unpaid' => 'badge-warning',
                            'overdue' => 'badge-danger',
                            default => 'badge-neutral',
                        };
                        $statusText = match($invoice['status']) {
                            'paid' => 'Đã thanh toán',
                            'unpaid' => 'Chưa thanh toán',
                            'overdue' => 'Quá hạn',
                            default => 'Đã hủy',
                        };
                        ?>
                        <span class="badge <?= $statusCls ?>"><?= $statusText ?></span>
                    </div>
                </div>
            </section>

            <section class="card invoice-section invoice-details">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết các khoản phí</h3>
                </div>
                <div class="table-wrapper invoice-details-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Khoản phí</th>
                                <th style="text-align:right">Thành tiền (VND)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong> Tiền thuê phòng</strong>
                                    <span>Giá thuê phòng cơ bản hàng tháng</span>
                                </td>
                                <td style="text-align:right">
                                    <?= number_format((float)$invoice['base_rent'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Tiền điện sinh hoạt</strong>
                                    <span>Dựa trên chỉ số tiêu thụ của phòng</span>
                                </td>
                                <td style="text-align:right">
                                    <?= number_format((float)$invoice['electricity_fee'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Tiền nước sạch</strong>
                                    <span>Dựa trên khối lượng nước tiêu thụ</span>
                                </td>
                                <td style="text-align:right">
                                    <?= number_format((float)$invoice['water_fee'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php if ((float)$invoice['ac_fee'] > 0): ?>
                            <tr>
                                <td>
                                    <strong> Phụ phí điều hòa</strong>
                                    <span>Phí dịch vụ phòng điều hòa</span>
                                </td>
                                <td style="text-align:right">
                                    <?= number_format((float)$invoice['ac_fee'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php if ((float)$invoice['other_fee'] > 0): ?>
                            <tr>
                                <td>
                                    <strong> Chi phí dịch vụ khác</strong>
                                    <span>Phí vệ sinh, mạng internet hoặc phụ thu</span>
                                </td>
                                <td style="text-align:right">
                                    <?= number_format((float)$invoice['other_fee'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr class="invoice-summary-row">
                                <td>
                                    <strong>TỔNG CỘNG THÀNH TIỀN</strong>
                                    <span>Tổng tất cả các khoản chi phí học kỳ này</span>
                                </td>
                                <td style="text-align:right">
                                    <?= number_format((float)$invoice['total_amount'], 0, ',', '.') ?> VND
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <aside class="invoice-side">
            <section class="card invoice-section">
                <div class="card-header">
                    <h3 class="card-title">Thông tin thanh toán</h3>
                </div>
                <div class="card-body payment-state">
                    <?php if ($invoice['status'] === 'paid'): ?>
                        <div class="payment-status-card payment-status-paid">
                            <span class="payment-status-icon"></span>
                            <div>
                                <h4>Đã thanh toán</h4>
                                <p>Hóa đơn đã được thanh toán đầy đủ.</p>
                            </div>
                        </div>
                        <div class="invoice-info-box">
                            <div class="info-row">
                                <span>Thời gian nộp</span>
                                <strong><?= date('d/m/Y H:i:s', strtotime($invoice['paid_at'])) ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Phương thức</span>
                                <strong>
                                    <?= match($invoice['payment_method']) {
                                        'cash' => ' Tiền mặt',
                                        'transfer' => ' Chuyển khoản ngân hàng',
                                        'momo' => ' Ví Momo',
                                        default => 'Điện tử VNPAY',
                                    } ?>
                                </strong>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="payment-status-card payment-status-pending">
                            <span class="payment-status-icon">⏳</span>
                            <div>
                                <h4>Chờ thanh toán</h4>
                                <p>Hóa đơn đang chờ thanh toán của sinh viên hoặc xác nhận của bộ phận quản lý tài vụ.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="card invoice-section invoice-note-card">
                <div class="card-header">
                    <h4 class="card-title"> Hướng dẫn</h4>
                </div>
                <div class="card-body">
                    <p>• Nút <strong>In / Tải PDF</strong> sẽ tải xuống file PDF chuyên nghiệp để lưu trữ hoặc in ấn.</p>
                    <p>• Nếu thanh toán trực tiếp bằng tiền mặt, admin nhấn <strong>Xác nhận thanh toán</strong> để hoàn tất hóa đơn ngay lập tức.</p>
                    <p>• Đảm bảo chỉ số điện nước đã được đo đạc chính xác trước khi xuất hóa đơn.</p>
                </div>
            </section>
        </aside>
    </div>
</div>

<!-- CSRF Token for Ajax -->
<input type="hidden" id="csrf_token_val" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

<!-- Payment Modal -->
<div class="modal-overlay" id="paymentModalBackdrop" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title"> Xác nhận Thanh toán Hóa đơn</h3>
            <button type="button" class="modal-close" aria-label="Close" onclick="closePaymentModal()"></button>
        </div>
        <div class="modal-body">
            <p style="margin:0 0 18px;color:var(--txt-muted);font-size:.95rem;line-height:1.7;">
                Hành động này sẽ cập nhật trạng thái hóa đơn sang đã thanh toán.
            </p>
            <form id="paymentConfirmForm" onsubmit="submitPayment(event)">
                <div class="form-group">
                    <label class="form-label" for="payment_method">Phương thức thanh toán</label>
                    <select id="payment_method" class="form-control">
                        <option value="cash"> Tiền mặt (Trực tiếp)</option>
                        <option value="transfer"> Chuyển khoản ngân hàng</option>
                        <option value="momo"> Ví điện tử Momo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="transaction_id">Mã giao dịch (Nếu có)</label>
                    <input type="text" id="transaction_id" class="form-control" placeholder="Ví dụ: FT1234567890">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closePaymentModal()">Hủy bỏ</button>
                    <button type="submit" class="btn btn-success"> Xác nhận nộp</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPaymentModal() {
    document.getElementById('paymentModalBackdrop').style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModalBackdrop').style.display = 'none';
}

function submitPayment(e) {
    e.preventDefault();
    
    var method = document.getElementById('payment_method').value;
    var txId = document.getElementById('transaction_id').value;
    var csrf = document.getElementById('csrf_token_val').value;
    
    var data = {
        payment_method: method,
        transaction_id: txId,
        _csrf_token: csrf
    };
    
    fetch('/Final-Web2-PHP-Dormitory-Management/public/api/invoices/<?= $invoice['id'] ?>/pay', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrf
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(res => {
        if (res.success) {
            alert('Xác nhận thanh toán thành công!');
            window.location.reload();
        } else {
            alert('Lỗi: ' + res.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Đã xảy ra lỗi khi gửi yêu cầu.');
    });
}
</script>
