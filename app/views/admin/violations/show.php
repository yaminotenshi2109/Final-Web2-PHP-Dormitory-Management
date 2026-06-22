<?php
/**
 * admin/violations/show.php — Chi tiết vi phạm
 * Variables: $title, $violation, $_csrfToken
 */
$v = $violation ?? [];
$statusMap = ['active'=>['badge-danger',' Chưa xử lý'],'appealed'=>['badge-warning',' Đang khiếu nại'],'dismissed'=>['badge-neutral',' Đã bác bỏ']];
$st = $v['status'] ?? 'active'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st];
?>

<div class="page-header">
  <div><h1 class="page-title"> Vi phạm #<?= $v['id'] ?? '' ?></h1><p class="page-subtitle"><?= htmlspecialchars($v['violation_type'] ?? '') ?></p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/violations') ?>" class="btn btn-ghost">← Quay lại</a>
    <?php if ($st === 'active' || $st === 'appealed'): ?>
      <form method="POST" action="<?= getDynamicUrl('/admin/violations/' . ($v['id'] ?? '') . '/dismiss') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-outline" onclick="return confirm('Bác bỏ vi phạm?')"> Bác bỏ</button></form>
    <?php endif; ?>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Chi tiết vi phạm</div></div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border)">
        <div style="width:64px;height:64px;border-radius:50%;background:var(--danger-bg);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:28px;color:var(--danger)"><?= $v['penalty_points'] ?? 0 ?></div>
        <div><div style="font-size:20px;font-weight:800"><?= htmlspecialchars($v['violation_type'] ?? '') ?></div><div style="color:var(--txt-muted);font-size:13px">điểm phạt</div></div>
        <span class="badge <?= $bClass ?>" style="margin-left:auto"><?= $bLabel ?></span>
      </div>
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:120px">Mô tả</td><td><?= htmlspecialchars($v['description'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày ghi</td><td><?= !empty($v['recorded_at']) ? date('d/m/Y H:i', strtotime($v['recorded_at'])) : '—' ?></td></tr>
        <?php if (!empty($v['appeal_note'])): ?>
          <tr><td style="padding:10px 0;color:var(--txt-muted)">Lý do khiếu nại</td><td style="color:var(--warning)"><?= htmlspecialchars($v['appeal_note']) ?></td></tr>
        <?php endif; ?>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Sinh viên</div></div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:14px">
        <div class="avatar avatar-lg"><?= mb_strtoupper(mb_substr($v['full_name'] ?? 'S', 0, 1)) ?></div>
        <div><div style="font-weight:700;font-size:16px"><?= htmlspecialchars($v['full_name'] ?? '') ?></div><div style="color:var(--txt-muted);font-size:13px"><?= htmlspecialchars($v['student_code'] ?? '') ?></div></div>
      </div>
    </div>
  </div>
</div>
