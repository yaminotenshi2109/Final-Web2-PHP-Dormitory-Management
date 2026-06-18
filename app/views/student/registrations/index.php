<?php
/**
 * student/registrations/index.php — Đăng ký phòng (SV)
 * Variables: $title, $registrations[], $rooms_available[]
 */
$statusMap = ['pending'=>['badge-warning','⏳ Chờ duyệt'],'approved'=>['badge-success','✅ Đã duyệt'],'rejected'=>['badge-danger','❌ Từ chối'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
?>

<div class="page-header">
  <div><h1 class="page-title">📋 Đăng ký phòng</h1><p class="page-subtitle">Đơn đăng ký phòng KTX của bạn</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/student/registrations/create') ?>" class="btn btn-primary">+ Đăng ký mới</a>
  </div>
</div>

<?php if (!empty($registrations)): ?>
  <div style="display:flex;flex-direction:column;gap:12px">
    <?php foreach ($registrations as $reg): ?>
      <?php $st = $reg['status'] ?? 'pending'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
      <div class="card">
        <div class="card-body" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
          <div class="stat-icon" style="width:56px;height:56px;font-size:24px;background:var(--brand-light);color:var(--brand)">🚪</div>
          <div style="flex:1;min-width:200px">
            <div style="font-weight:700;font-size:16px">Phòng <?= htmlspecialchars($reg['room_number'] ?? '') ?> — <?= htmlspecialchars($reg['building_name'] ?? '') ?></div>
            <div style="color:var(--txt-muted);font-size:13px;margin-top:2px">Học kỳ <?= htmlspecialchars(($reg['semester'] ?? '') . '/' . ($reg['academic_year'] ?? '')) ?></div>
            <div style="color:var(--txt-muted);font-size:12px;margin-top:4px">Ngày nộp: <?= !empty($reg['registered_at']) ? date('d/m/Y H:i', strtotime($reg['registered_at'])) : '—' ?></div>
          </div>
          <span class="badge <?= $bClass ?>"><?= $bLabel ?></span>
          <?php if ($st === 'pending'): ?>
            <form method="POST" action="<?= getDynamicUrl('/student/registrations/' . ($reg['id'] ?? '') . '/cancel') ?>">
              <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
              <button type="submit" class="btn btn-danger-outline btn-sm" onclick="return confirm('Hủy đơn đăng ký?')">Hủy đơn</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="card">
    <div class="empty-state">
      <div class="empty-icon">📋</div>
      <div class="empty-title">Chưa có đơn đăng ký</div>
      <div class="empty-msg">Bạn chưa nộp đơn đăng ký phòng KTX nào.</div>
      <a href="<?= getDynamicUrl('/student/registrations/create') ?>" class="btn btn-primary mt-16">Đăng ký ngay</a>
    </div>
  </div>
<?php endif; ?>
