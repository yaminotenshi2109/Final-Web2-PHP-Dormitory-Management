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
    <div class="card-header" style="border-bottom: none; padding-bottom: 0;">
        <ul class="nav-tabs" style="display: flex; list-style: none; padding: 0; margin: 0; border-bottom: 2px solid #e2e8f0;">
            <li style="margin-right: 20px; padding-bottom: 10px; cursor: pointer; font-weight: bold; color: var(--primary); border-bottom: 2px solid var(--primary);" id="tab-batch" onclick="switchTab('batch')">
                Tạo Hàng Loạt
            </li>
            <li style="padding-bottom: 10px; cursor: pointer; color: var(--text-muted);" id="tab-single" onclick="switchTab('single')">
                Tạo Cá Nhân
            </li>
        </ul>
    </div>
    <div class="card-body" style="padding-top: 20px;">
        
        <!-- Batch Form -->
        <div id="form-batch">
            <form id="generateInvoiceForm" onsubmit="generateInvoices(event)">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                
                <div class="form-group">
                    <label class="form-label" for="month">Tháng</label>
                    <select name="month" id="month" class="form-control" required>
                        <option value="">-- Chọn tháng --</option>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m === $currentMonth ? 'selected' : '' ?>>
                                Tháng <?= $m ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="year">Năm</label>
                    <select name="year" id="year" class="form-control" required>
                        <option value="">-- Chọn năm --</option>
                        <?php for ($y = $currentYear; $y >= $currentYear - 5; $y--): ?>
                            <option value="<?= $y ?>" <?= $y === $currentYear ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div id="resultMessageBatch" style="margin-top: 15px; display: none;" class="alert"></div>

                <div class="form-actions" style="margin-top: 20px;">
                    <button type="submit" id="btnSubmitBatch" class="btn btn-primary" style="width: 100%;">
                        Thực hiện Tạo Hóa Đơn Hàng Loạt
                    </button>
                </div>
            </form>
        </div>

        <!-- Single Form -->
        <div id="form-single" style="display: none;">
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
</div>

<script>
function switchTab(tab) {
    document.getElementById('form-batch').style.display = tab === 'batch' ? 'block' : 'none';
    document.getElementById('form-single').style.display = tab === 'single' ? 'block' : 'none';
    
    const tabBatch = document.getElementById('tab-batch');
    const tabSingle = document.getElementById('tab-single');
    
    if (tab === 'batch') {
        tabBatch.style.fontWeight = 'bold';
        tabBatch.style.color = 'var(--primary)';
        tabBatch.style.borderBottom = '2px solid var(--primary)';
        
        tabSingle.style.fontWeight = 'normal';
        tabSingle.style.color = 'var(--text-muted)';
        tabSingle.style.borderBottom = 'none';
    } else {
        tabSingle.style.fontWeight = 'bold';
        tabSingle.style.color = 'var(--primary)';
        tabSingle.style.borderBottom = '2px solid var(--primary)';
        
        tabBatch.style.fontWeight = 'normal';
        tabBatch.style.color = 'var(--text-muted)';
        tabBatch.style.borderBottom = 'none';
    }
}

async function generateInvoices(e) {
    e.preventDefault();
    
    const form = e.target;
    const btn = document.getElementById('btnSubmitBatch');
    const msg = document.getElementById('resultMessageBatch');
    
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    if (!month || !year) {
        msg.className = 'alert alert-danger';
        msg.innerHTML = 'Vui lòng chọn tháng và năm.';
        msg.style.display = 'block';
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = 'Đang xử lý...';
    msg.style.display = 'none';
    
    try {
        const formData = new FormData(form);
        const data = new URLSearchParams(formData);
        
        const response = await fetch('/Final-Web2-PHP-Dormitory-Management/public/admin/invoices/generate', {
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
            let html = `<strong>Thành công!</strong> Đã tạo ${result.data.total_invoices} hóa đơn.`;
            if (result.data.errors && result.data.errors.length > 0) {
                html += `<br><small>Có một số lỗi: ${result.data.errors.join(', ')}</small>`;
            }
            msg.innerHTML = html;
            
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
        btn.innerHTML = 'Thực hiện Tạo Hóa Đơn Hàng Loạt';
    }
}

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
