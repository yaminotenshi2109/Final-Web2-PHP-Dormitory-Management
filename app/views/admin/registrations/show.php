<?php
/**
 * admin/registrations/show.php — Chi tiết đăng ký
 * Variables: $title, $registration, $_csrfToken
 */
$r = $registration ?? [];
$statusMap = ['pending'=>['badge-warning','⏳ Chờ duyệt'],'approved'=>['badge-success','✅ Đã duyệt'],'rejected'=>['badge-danger','❌ Từ chối'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
$st = $r['status'] ?? 'pending'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">📋 Chi tiết đăng ký #<?= $r['id'] ?? '' ?></h1>
    <p class="page-subtitle">Đơn đăng ký phòng KTX</p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/registrations') ?>" class="btn btn-ghost">← Quay lại</a>
    <?php if ($st === 'pending'): ?>
      <form method="POST" action="<?= getDynamicUrl('/admin/registrations/' . ($r['id'] ?? '') . '/approve') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success" onclick="return confirm('Duyệt đơn này?')">✅ Duyệt</button></form>
      <form method="POST" action="<?= getDynamicUrl('/admin/registrations/' . ($r['id'] ?? '') . '/reject') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-danger" onclick="return confirm('Từ chối đơn này?')">❌ Từ chối</button></form>
    <?php endif; ?>
  </div>
</div>

<script>
function autoAllocate() {
    if (!confirm('Xác nhận tự động xếp phòng cho sinh viên này?')) return;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/Final-Web2-PHP-Dormitory-Management/public/api/registrations/<?= $id ?>/auto-allocate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': token
        },
        body: JSON.stringify({ method: 'auto' })
    })
    .then(r => r.json())
    .then(json => {
        if (json.success) {
            alert('🚀 Tự động xếp phòng thành công! Phòng ' + json.data.room_number + ' (' + json.data.building_name + ')');
            // Redirect to admin dashboard
            window.location.href = '/Final-Web2-PHP-Dormitory-Management/public/admin/dashboard';
        } else {
            alert('❌ Lỗi: ' + json.message);
        }
    })
    .catch(err => alert('Lỗi kết nối: ' + err.message));
}

function manualAllocate() {
    const roomId = document.getElementById('manualRoomSelect').value;
    if (!roomId) { alert('Vui lòng chọn phòng trống!'); return; }
    
    if (!confirm('Xác nhận gán sinh viên vào phòng đã chọn?')) return;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/Final-Web2-PHP-Dormitory-Management/public/api/registrations/<?= $id ?>/manual-allocate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': token
        },
        body: JSON.stringify({ room_id: roomId })
    })
    .then(r => r.json())
    .then(json => {
        if (json.success) {
            alert('✅ Gán phòng thủ công thành công!');
            // Redirect to admin dashboard
            window.location.href = '/Final-Web2-PHP-Dormitory-Management/public/admin/dashboard';
        } else {
            alert('❌ Lỗi: ' + json.message);
        }
    })
    .catch(err => alert('Lỗi kết nối: ' + err.message));
}

function rejectRegistration() {
    const reason = document.getElementById('rejectReasonInput').value.trim();
    if (!reason) { alert('Vui lòng nhập lý do từ chối đơn!'); return; }
    
    if (!confirm('Xác nhận từ chối đơn đăng ký này?')) return;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/Final-Web2-PHP-Dormitory-Management/public/api/registrations/<?= $id ?>/reject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': token
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(r => r.json())
    .then(json => {
        if (json.success) {
            alert('❌ Đã từ chối đơn đăng ký thành công!');
            // Redirect to admin registrations list
            window.location.href = '/Final-Web2-PHP-Dormitory-Management/public/admin/registrations';
        } else {
            alert('❌ Lỗi: ' + json.message);
        }
    })
    .catch(err => alert('Lỗi kết nối: ' + err.message));
}
</script>
