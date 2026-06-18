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

<<<<<<< HEAD
<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin đăng ký</div></div>
    <div class="card-body">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:130px">Trạng thái</td><td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Phòng</td><td style="font-weight:700;font-size:16px"><?= htmlspecialchars($r['room_number'] ?? '') ?> — <?= htmlspecialchars($r['building_name'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Học kỳ</td><td>HK<?= htmlspecialchars($r['semester'] ?? '') ?> / <?= htmlspecialchars($r['academic_year'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày nộp</td><td><?= !empty($r['registered_at']) ? date('d/m/Y H:i', strtotime($r['registered_at'])) : '—' ?></td></tr>
        <?php if (!empty($r['reviewed_at'])): ?>
          <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày duyệt</td><td><?= date('d/m/Y H:i', strtotime($r['reviewed_at'])) ?></td></tr>
        <?php endif; ?>
        <?php if (!empty($r['note'])): ?>
          <tr><td style="padding:10px 0;color:var(--txt-muted)">Ghi chú</td><td><?= htmlspecialchars($r['note']) ?></td></tr>
        <?php endif; ?>
        <?php if (!empty($r['reject_reason'])): ?>
          <tr><td style="padding:10px 0;color:var(--txt-muted)">Lý do từ chối</td><td style="color:var(--danger)"><?= htmlspecialchars($r['reject_reason']) ?></td></tr>
        <?php endif; ?>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin sinh viên</div></div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px">
        <div class="avatar avatar-lg"><?= mb_strtoupper(mb_substr($r['student_name'] ?? 'S', 0, 1)) ?></div>
        <div>
          <div style="font-weight:700;font-size:16px"><?= htmlspecialchars($r['student_name'] ?? '') ?></div>
          <div style="color:var(--txt-muted);font-size:13px"><?= htmlspecialchars($r['student_code'] ?? '') ?></div>
        </div>
      </div>
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:8px 0;color:var(--txt-muted);width:100px">Khoa</td><td><?= htmlspecialchars($r['faculty'] ?? '') ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Giới tính</td><td><?= ($r['gender'] ?? '') === 'male' ? '👨 Nam' : '👩 Nữ' ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">SĐT</td><td><?= htmlspecialchars($r['phone'] ?? '') ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Ưu tiên</td><td><?= ['Bình thường', 'Chính sách', 'Ưu tiên cao'][$r['priority_level'] ?? 0] ?? 'N/A' ?></td></tr>
      </table>
    </div>
  </div>
</div>
=======
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
>>>>>>> cab58fd2b4b300bab02822a36621ded10784ddfb
