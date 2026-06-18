<?php
/**
<<<<<<< HEAD
 * admin/contracts/show.php — Chi tiết hợp đồng
 * Variables: $title, $contract, $_csrfToken
=======
 * app/views/admin/contracts/show.php
 * Admin — Chi tiết hợp đồng
 * Variables: $title, $contract
 * @var string $title
 * @var array $contract
 * @var string $_csrfToken
>>>>>>> cab58fd2b4b300bab02822a36621ded10784ddfb
 */
$c = $contract ?? [];
$statusMap = ['active'=>['badge-success','✅ Hiệu lực'],'expired'=>['badge-neutral','⏰ Hết hạn'],'terminated'=>['badge-danger','🚫 Chấm dứt'],'under_review'=>['badge-warning','⚠️ Xem xét']];
$st = $c['status'] ?? 'active'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st];
?>

<div class="page-header">
  <div><h1 class="page-title">📄 Hợp đồng #<?= $c['id'] ?? '' ?></h1><p class="page-subtitle">Chi tiết hợp đồng thuê phòng</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/contracts') ?>" class="btn btn-ghost">← Quay lại</a>
    <?php if ($st === 'active'): ?>
      <form method="POST" action="<?= getDynamicUrl('/admin/contracts/' . ($c['id'] ?? '') . '/terminate') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-danger" onclick="return confirm('Chấm dứt hợp đồng?')">🚫 Chấm dứt</button></form>
    <?php endif; ?>
  </div>
</div>

<div class="grid-2 mb-24">
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin hợp đồng</div></div>
    <div class="card-body">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:130px">Trạng thái</td><td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Phòng</td><td style="font-weight:700;font-size:16px"><?= htmlspecialchars($c['room_number'] ?? '') ?> — <?= htmlspecialchars($c['building_name'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày bắt đầu</td><td style="font-weight:600"><?= !empty($c['start_date']) ? date('d/m/Y', strtotime($c['start_date'])) : '—' ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày kết thúc</td><td style="font-weight:600"><?= !empty($c['end_date']) ? date('d/m/Y', strtotime($c['end_date'])) : '—' ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Phí/tháng</td><td style="font-weight:800;font-size:18px;color:var(--brand)"><?= number_format($c['monthly_fee'] ?? 0, 0, ',', '.') ?> VND</td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Đặt cọc</td><td style="font-weight:600;color:var(--warning)"><?= number_format($c['deposit_amount'] ?? 0, 0, ',', '.') ?> VND</td></tr>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><div class="card-title">Sinh viên</div></div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px">
        <div class="avatar avatar-lg"><?= mb_strtoupper(mb_substr($c['student_name'] ?? 'S', 0, 1)) ?></div>
        <div>
          <div style="font-weight:700;font-size:16px"><?= htmlspecialchars($c['student_name'] ?? '') ?></div>
          <div style="color:var(--txt-muted);font-size:13px"><?= htmlspecialchars($c['student_code'] ?? '') ?></div>
        </div>
      </div>

      <!-- Timeline -->
      <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
        <div style="font-weight:700;font-size:14px;margin-bottom:12px">📋 Timeline</div>
        <div class="timeline">
          <div class="timeline-item"><div class="timeline-dot"></div><div class="timeline-time">Bắt đầu</div><div class="timeline-content"><?= !empty($c['start_date']) ? date('d/m/Y', strtotime($c['start_date'])) : '—' ?></div></div>
          <?php if (!empty($c['end_date'])): ?>
            <div class="timeline-item"><div class="timeline-dot" style="background:var(--warning)"></div><div class="timeline-time">Kết thúc</div><div class="timeline-content"><?= date('d/m/Y', strtotime($c['end_date'])) ?></div></div>
          <?php endif; ?>
          <?php if (!empty($c['terminated_at'])): ?>
            <div class="timeline-item"><div class="timeline-dot" style="background:var(--danger)"></div><div class="timeline-time">Chấm dứt</div><div class="timeline-content"><?= date('d/m/Y', strtotime($c['terminated_at'])) ?></div></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
