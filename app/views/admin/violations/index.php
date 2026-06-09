<?php
/**
 * admin/violations/index.php — Vi phạm
 * Variables: $title, $violations[], $stats, $filters
 */
$statusMap = ['active'=>['badge-danger','🔴 Chưa xử lý'],'appealed'=>['badge-warning','⚠️ Khiếu nại'],'dismissed'=>['badge-neutral','✅ Bác bỏ']];
?>

<div class="page-header">
  <div><h1 class="page-title">⚠️ Quản lý Vi phạm</h1><p class="page-subtitle">Ghi nhận và xử lý vi phạm nội quy KTX</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/violations/create') ?>" class="btn btn-primary">+ Ghi nhận vi phạm</a>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">⚠️</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng vi phạm</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">🔴</div><div><div class="stat-value"><?= number_format($stats['active'] ?? 0) ?></div><div class="stat-label">Chưa xử lý</div></div></div>
  <div class="stat-card" style="--stat-color:#8b5cf6;--stat-icon-bg:#ede9fe"><div class="stat-icon">📝</div><div><div class="stat-value"><?= number_format($stats['appealed'] ?? 0) ?></div><div class="stat-label">Khiếu nại</div></div></div>
</div>

<div class="card">
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tên SV, loại vi phạm...">
    </div>
    <select class="form-control" style="width:auto;min-width:140px">
      <option value="">Tất cả trạng thái</option>
      <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Chưa xử lý</option>
      <option value="appealed" <?= ($filters['status'] ?? '') === 'appealed' ? 'selected' : '' ?>>Khiếu nại</option>
      <option value="dismissed" <?= ($filters['status'] ?? '') === 'dismissed' ? 'selected' : '' ?>>Bác bỏ</option>
    </select>
  </div>

  <?php if (!empty($violations)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Loại vi phạm</th><th>Điểm phạt</th><th>Ngày ghi</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($violations as $v): ?>
            <?php $st = $v['status'] ?? 'active'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-sm"><?= mb_strtoupper(mb_substr($v['student_name'] ?? 'S', 0, 1)) ?></div>
                  <div><div style="font-weight:600"><?= htmlspecialchars($v['student_name'] ?? '') ?></div><div class="sub"><?= htmlspecialchars($v['student_code'] ?? '') ?></div></div>
                </div>
              </td>
              <td><span style="font-weight:600"><?= htmlspecialchars($v['violation_type'] ?? '') ?></span><div class="sub"><?= htmlspecialchars(mb_strimwidth($v['description'] ?? '', 0, 60, '...')) ?></div></td>
              <td><span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;background:var(--danger-bg);color:var(--danger);font-weight:800;font-size:14px"><?= $v['penalty_points'] ?? 0 ?></span></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($v['recorded_at']) ? date('d/m/Y', strtotime($v['recorded_at'])) : '—' ?></td>
              <td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/violations/' . ($v['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <?php if ($st === 'active'): ?>
                  <form method="POST" action="<?= getDynamicUrl('/admin/violations/' . ($v['id'] ?? '') . '/dismiss') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-outline btn-sm" onclick="return confirm('Bác bỏ vi phạm?')">Bác bỏ</button></form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🎉</div><div class="empty-title">Không có vi phạm</div><div class="empty-msg">Tuyệt vời! Không có vi phạm nào cần xử lý.</div></div>
  <?php endif; ?>
</div>
