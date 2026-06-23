<?php
/**
 * Admin - Tạo hóa đơn
 */
$currentYear = (int)date('Y');
$currentMonth = (int)date('n');
?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= htmlspecialchars($title ?? 'Tạo hóa đơn') ?></h1>
        <p class="page-subtitle">Hệ thống sẽ tự động tính toán tiền phòng, điện, nước và gửi thông báo cho sinh viên.</p>
    </div>
    <div class="page-actions">
        <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices" class="btn btn-outline">
            &larr; Quay lại
        </a>
    </div>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Tạo Hóa Đơn Cá Nhân</h3>
    </div>
    <div class="card-body">
        
        <form id="generateSingleForm" onsubmit="generateSingleInvoice(event)">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

            <div class="form-group">
                <label class="form-label" for="contract_id">Sinh viên (Hợp đồng đang hoạt động)</label>
                <select name="contract_id" id="contract_id" class="form-control" required>
                    <option value="">-- Chọn sinh viên --</option>
                    <?php foreach ($contracts ?? [] as $c): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= htmlspecialchars($c['full_name']) ?> (<?= htmlspecialchars($c['student_code']) ?>) - Phòng: <?= htmlspecialchars($c['room_number']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="single_month">Tháng</label>
                    <select name="month" id="single_month" class="form-control" required>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m === $currentMonth ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="single_year">Năm</label>
                    <select name="year" id="single_year" class="form-control" required>
                        <?php for ($y = $currentYear; $y >= $currentYear - 5; $y--): ?>
                            <option value="<?= $y ?>" <?= $y === $currentYear ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="elec_curr">Chỉ số Điện (cuối kỳ)</label>
                    <input type="number" step="0.01" name="elec_curr" id="elec_curr" class="form-control" required placeholder="Ví dụ: 1250.5">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="water_curr">Chỉ số Nước (cuối kỳ)</label>
                    <input type="number" step="0.01" name="water_curr" id="water_curr" class="form-control" required placeholder="Ví dụ: 250">
                </div>
            </div>

            <div id="resultMessageSingle" style="margin-top: 15px; display: none;" class="alert"></div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" id="btnSubmitSingle" class="btn btn-primary" style="width: 100%;">
                    Tạo Hóa Đơn & Nhập Chỉ Số
                </button>
            </div>
        </form>

    </div>
</div>

<script>
async function generateSingleInvoice(e) {
    e.preventDefault();
    
    const form = e.target;
    const btn = document.getElementById('btnSubmitSingle');
    const msg = document.getElementById('resultMessageSingle');
    
    btn.disabled = true;
    btn.innerHTML = 'Đang xử lý...';
    msg.style.display = 'none';
    
    try {
        const formData = new FormData(form);
        const data = new URLSearchParams(formData);
        
        const response = await fetch('/Final-Web2-PHP-Dormitory-Management/public/admin/invoices/generate-single', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            msg.className = 'alert alert-success';
            msg.innerHTML = `<strong>Thành công!</strong> Hóa đơn đã được tạo và gửi cho sinh viên.`;
            
            setTimeout(() => {
                window.location.href = '/Final-Web2-PHP-Dormitory-Management/public/admin/invoices';
            }, 2000);
        } else {
            msg.className = 'alert alert-danger';
            msg.innerHTML = result.message || 'Có lỗi xảy ra.';
        }
    } catch (error) {
        msg.className = 'alert alert-danger';
        msg.innerHTML = 'Không thể kết nối đến máy chủ.';
    } finally {
        msg.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = 'Tạo Hóa Đơn & Nhập Chỉ Số';
    }
}
</script>
