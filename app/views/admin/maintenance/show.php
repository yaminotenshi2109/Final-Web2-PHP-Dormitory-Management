<?php
/**
 * admin/maintenance/show.php — Chi tiết bảo trì
 * Variables: $title, $request, $_csrfToken
 */
$rq = $request ?? [];
$statusMap = ['open'=>['badge-danger','🔴 Mở'],'in_progress'=>['badge-warning','🔧 Đang xử lý'],'resolved'=>['badge-success','✅ Đã xử lý'],'closed'=>['badge-neutral','✔️ Đóng'],'rejected'=>['badge-neutral','❌ Từ chối']];
$priorityMap = ['low'=>['badge-info','Thấp'],'medium'=>['badge-warning','Trung bình'],'high'=>['badge-danger','Cao'],'urgent'=>['badge-danger','🔥 Khẩn cấp']];
$st = $rq['status'] ?? 'open'; [$sClass, $sLabel] = $statusMap[$st] ?? ['badge-neutral', $st];
$pr = $rq['priority'] ?? 'medium'; [$pClass, $pLabel] = $priorityMap[$pr] ?? ['badge-neutral', $pr];
?>

<div class="page-header">
  <div><h1 class="page-title">🔧 Yêu cầu #<?= $rq['id'] ?? '' ?></h1><p class="page-subtitle"><?= htmlspecialchars($rq['title'] ?? '') ?></p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/maintenance') ?>" class="btn btn-ghost">← Quay lại</a>
    <?php if ($st === 'open'): ?>
      <form method="POST" action="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '') . '/in-progress') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-outline">🔧 Bắt đầu xử lý</button></form>
    <?php endif; ?>
    <?php if ($st === 'open' || $st === 'in_progress'): ?>
      <form method="POST" action="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '') . '/resolve') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success">✅ Đã xử lý</button></form>
    <?php endif; ?>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-header"><div class="card-title">Chi tiết yêu cầu</div></div>
    <div class="card-body">
      <div style="display:flex;gap:8px;margin-bottom:16px"><span class="badge <?= $sClass ?>"><?= $sLabel ?></span><span class="badge <?= $pClass ?>"><?= $pLabel ?></span></div>
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:120px">Tiêu đề</td><td style="font-weight:700"><?= htmlspecialchars($rq['title'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Mô tả</td><td><?= nl2br(htmlspecialchars($rq['description'] ?? '')) ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Phòng</td><td style="font-weight:600"><?= htmlspecialchars($rq['room_number'] ?? '') ?> — <?= htmlspecialchars($rq['building_name'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày báo</td><td><?= !empty($rq['reported_at']) ? date('d/m/Y H:i', strtotime($rq['reported_at'])) : '—' ?></td></tr>
        <?php if (!empty($rq['resolved_at'])): ?>
          <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày xử lý</td><td style="color:var(--success)"><?= date('d/m/Y H:i', strtotime($rq['resolved_at'])) ?></td></tr>
        <?php endif; ?>
      </table>
    </div>
  </div>

  <div>
    <div class="card mb-16">
      <div class="card-header"><div class="card-title">Người báo cáo</div></div>
      <div class="card-body">
        <div style="display:flex;align-items:center;gap:14px">
          <div class="avatar avatar-lg"><?= mb_strtoupper(mb_substr($rq['reporter_name'] ?? 'U', 0, 1)) ?></div>
          <div><div style="font-weight:700"><?= htmlspecialchars($rq['reporter_name'] ?? '') ?></div><div style="color:var(--txt-muted);font-size:13px"><?= htmlspecialchars($rq['reporter_code'] ?? '') ?></div></div>
        </div>
      </div>
    </div>

    <!-- Admin notes form -->
    <div class="card">
      <div class="card-header"><div class="card-title">💬 Ghi chú xử lý</div></div>
      <div class="card-body">
        <form method="POST" action="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '') . '/note') ?>">
          <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
          <div class="form-group">
            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Ghi chú kết quả xử lý..."><?= htmlspecialchars($rq['admin_notes'] ?? '') ?></textarea>
          </div>
          <button type="submit" class="btn btn-outline btn-sm">💾 Lưu ghi chú</button>
        </form>
      </div>
    </div>
  </div>
</div>
