<?php
/**
 * student/violations/index.php — Vi phạm sinh viên
 * Variables: $title, $violations[], $totalPoints
 */
$statusMap = ['active'=>['badge-danger','🔴 Chưa xử lý'],'appealed'=>['badge-warning','⚠️ Đang khiếu nại'],'dismissed'=>['badge-neutral','✅ Đã bác bỏ']];
?>

<div class="page-header">
  <div><h1 class="page-title">⚠️ Vi phạm</h1><p class="page-subtitle">Danh sách vi phạm nội quy KTX</p></div>
</div>

<!-- Summary -->
<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2">
    <div class="stat-icon">⚠️</div>
    <div><div class="stat-value"><?= count($violations ?? []) ?></div><div class="stat-label">Tổng vi phạm</div></div>
  </div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7">
    <div class="stat-icon">📊</div>
    <div><div class="stat-value"><?= $totalPoints ?? 0 ?></div><div class="stat-label">Tổng điểm phạt</div></div>
  </div>
</div>

<?php if (!empty($violations)): ?>
  <div style="display:flex;flex-direction:column;gap:12px">
    <?php foreach ($violations as $v): ?>
      <?php $st = $v['status'] ?? 'active'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
      <div class="card">
        <div class="card-body" style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap">
          <div style="width:48px;height:48px;border-radius:50%;background:var(--danger-bg);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:18px;color:var(--danger);flex-shrink:0">
            <?= $v['penalty_points'] ?? 0 ?>
          </div>
          <div style="flex:1;min-width:200px">
            <div style="font-weight:700;font-size:15px"><?= htmlspecialchars($types[$v['violation_type']]['name'] ?? $v['violation_type']) ?></div>
            <div style="color:var(--txt-muted);font-size:13px;margin-top:4px"><?= htmlspecialchars($v['description'] ?? '') ?></div>
            <div style="color:var(--txt-muted);font-size:12px;margin-top:6px">📅 <?= !empty($v['recorded_at']) ? date('d/m/Y', strtotime($v['recorded_at'])) : '—' ?></div>
          </div>
          <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">
            <span class="badge <?= $bClass ?>"><?= $bLabel ?></span>
            <?php if ($st === 'active'): ?>
              <form method="POST" action="<?= getDynamicUrl('/student/violations/' . ($v['id'] ?? '') . '/appeal') ?>">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                <button type="submit" class="btn btn-outline btn-sm" onclick="return confirm('Gửi khiếu nại?')">📝 Khiếu nại</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="card">
    <div class="empty-state"><div class="empty-icon">🎉</div><div class="empty-title">Không có vi phạm</div><div class="empty-msg">Tuyệt vời! Bạn chưa vi phạm nội quy nào.</div></div>
  </div>
<?php endif; ?>
