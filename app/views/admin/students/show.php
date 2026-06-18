<?php
/**
 * admin/students/show.php — Chi tiết sinh viên
 * Variables: $title, $student, $contracts[], $violations[], $invoices[]
 */
$s = $student ?? [];
$genderMap = ['male'=>'👨 Nam','female'=>'👩 Nữ'];
$priorityMap = [0=>'Bình thường',1=>'Chính sách',2=>'Ưu tiên cao'];
$priorityBadge = [0=>'badge-neutral',1=>'badge-info',2=>'badge-purple'];
$contractStatusMap = ['active'=>['badge-success','✅ Hiệu lực'],'expired'=>['badge-neutral','⏰ Hết hạn'],'terminated'=>['badge-danger','🚫 Chấm dứt']];
$violationStatusMap = ['active'=>['badge-danger','🔴 Chưa xử lý'],'appealed'=>['badge-warning','⚠️ Khiếu nại'],'dismissed'=>['badge-neutral','✅ Bác bỏ']];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🎓 <?= htmlspecialchars($s['full_name'] ?? '') ?></h1>
    <p class="page-subtitle">Mã SV: <?= htmlspecialchars($s['student_code'] ?? '') ?></p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/students') ?>" class="btn btn-ghost">← Quay lại</a>
    <a href="<?= getDynamicUrl('/admin/students/' . ($s['id'] ?? '') . '/edit') ?>" class="btn btn-outline">✏️ Sửa</a>
  </div>
</div>

<div class="grid-2 mb-24">
  <!-- Personal Info -->
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin cá nhân</div></div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border)">
        <div class="avatar avatar-xl"><?= mb_strtoupper(mb_substr($s['full_name'] ?? 'S', 0, 1)) ?></div>
        <div>
          <div style="font-size:20px;font-weight:800"><?= htmlspecialchars($s['full_name'] ?? '') ?></div>
          <div style="color:var(--txt-muted);font-size:13px;margin-top:2px"><?= htmlspecialchars($s['email'] ?? '') ?></div>
          <span class="badge <?= $priorityBadge[$s['priority_level'] ?? 0] ?? 'badge-neutral' ?>" style="margin-top:6px"><?= $priorityMap[$s['priority_level'] ?? 0] ?? '' ?></span>
        </div>
      </div>
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:8px 0;color:var(--txt-muted);width:130px">Mã sinh viên</td><td style="font-weight:600;font-family:monospace"><?= htmlspecialchars($s['student_code'] ?? '') ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Giới tính</td><td><?= $genderMap[$s['gender'] ?? ''] ?? '—' ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Ngày sinh</td><td><?= !empty($s['dob']) ? date('d/m/Y', strtotime($s['dob'])) : '—' ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">CCCD</td><td><?= htmlspecialchars($s['id_card'] ?? '') ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Quê quán</td><td><?= htmlspecialchars($s['hometown'] ?? '') ?></td></tr>
      </table>
    </div>
  </div>

  <!-- Academic Info -->
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin học tập</div></div>
    <div class="card-body">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:130px">Khoa / Viện</td><td style="font-weight:600"><?= htmlspecialchars($s['faculty'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Chương trình</td><td><?= htmlspecialchars($s['program'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Số điện thoại</td><td style="font-weight:600"><?= htmlspecialchars($s['phone'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Phòng hiện tại</td><td style="font-weight:700;color:var(--brand)"><?= htmlspecialchars($s['current_room'] ?? 'Chưa có') ?></td></tr>
      </table>

      <div style="margin-top:20px;padding:16px;background:var(--page-bg);border-radius:var(--radius-sm)">
        <div style="font-size:13px;font-weight:600;margin-bottom:8px">Điểm phạt tích lũy</div>
        <div style="display:flex;align-items:center;gap:12px">
          <div style="font-size:32px;font-weight:900;color:<?= ($s['total_penalty'] ?? 0) > 10 ? 'var(--danger)' : 'var(--success)' ?>"><?= $s['total_penalty'] ?? 0 ?></div>
          <div class="progress" style="flex:1;height:10px">
            <div class="progress-bar <?= ($s['total_penalty'] ?? 0) > 15 ? 'danger' : (($s['total_penalty'] ?? 0) > 8 ? 'warning' : 'success') ?>" style="width:<?= min(100, ($s['total_penalty'] ?? 0) / 20 * 100) ?>%"></div>
          </div>
          <span style="font-size:12px;color:var(--txt-muted)">/20</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contracts Timeline -->
<div class="card mb-24">
  <div class="card-header"><div class="card-title">📄 Hợp đồng</div></div>
  <?php if (!empty($contracts)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Phòng</th><th>Thời hạn</th><th>Phí/tháng</th><th>Trạng thái</th></tr></thead>
        <tbody>
          <?php foreach ($contracts as $c): ?>
            <?php $cst = $c['status'] ?? 'active'; [$cClass, $cLabel] = $contractStatusMap[$cst] ?? ['badge-neutral', $cst]; ?>
            <tr>
              <td style="font-weight:700"><?= htmlspecialchars($c['room_number'] ?? '') ?></td>
              <td><?= !empty($c['start_date']) ? date('d/m/Y', strtotime($c['start_date'])) : '' ?> → <?= !empty($c['end_date']) ? date('d/m/Y', strtotime($c['end_date'])) : '' ?></td>
              <td style="font-weight:600"><?= number_format($c['monthly_fee'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><span class="badge <?= $cClass ?>"><?= $cLabel ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state" style="padding:32px"><div class="empty-icon" style="font-size:36px">📄</div><div class="empty-title">Chưa có hợp đồng</div></div>
  <?php endif; ?>
</div>

<!-- Violations -->
<div class="card">
  <div class="card-header"><div class="card-title">⚠️ Vi phạm</div></div>
  <?php if (!empty($violations)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Loại</th><th>Điểm phạt</th><th>Ngày</th><th>Trạng thái</th></tr></thead>
        <tbody>
          <?php foreach ($violations as $v): ?>
            <?php $vst = $v['status'] ?? 'active'; [$vClass, $vLabel] = $violationStatusMap[$vst] ?? ['badge-neutral', $vst]; ?>
            <tr>
              <td style="font-weight:600"><?= htmlspecialchars($v['violation_type'] ?? '') ?></td>
              <td><span style="font-weight:800;color:var(--danger)"><?= $v['penalty_points'] ?? 0 ?></span></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($v['recorded_at']) ? date('d/m/Y', strtotime($v['recorded_at'])) : '—' ?></td>
              <td><span class="badge <?= $vClass ?>"><?= $vLabel ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state" style="padding:32px"><div class="empty-icon" style="font-size:36px">🎉</div><div class="empty-title">Không có vi phạm</div></div>
  <?php endif; ?>
</div>
