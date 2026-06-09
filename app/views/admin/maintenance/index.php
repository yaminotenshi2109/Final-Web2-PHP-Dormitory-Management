<?php
/**
 * admin/maintenance/index.php — Bảo trì
 * Variables: $title, $requests[], $stats, $filters
 */
$statusMap = ['open'=>['badge-danger','🔴 Mở'],'in_progress'=>['badge-warning','🔧 Đang xử lý'],'resolved'=>['badge-success','✅ Đã xử lý'],'closed'=>['badge-neutral','✔️ Đóng'],'rejected'=>['badge-neutral','❌ Từ chối']];
$priorityMap = ['low'=>['badge-info','Thấp'],'medium'=>['badge-warning','Trung bình'],'high'=>['badge-danger','Cao'],'urgent'=>['badge-danger','🔥 Khẩn cấp']];
?>

<div class="page-header">
  <div><h1 class="page-title">🔧 Quản lý Bảo trì</h1><p class="page-subtitle">Theo dõi yêu cầu sửa chữa, bảo trì phòng</p></div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">🔴</div><div><div class="stat-value"><?= number_format($stats['open'] ?? 0) ?></div><div class="stat-label">Đang mở</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">🔧</div><div><div class="stat-value"><?= number_format($stats['in_progress'] ?? 0) ?></div><div class="stat-label">Đang xử lý</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($stats['resolved'] ?? 0) ?></div><div class="stat-label">Đã xử lý</div></div></div>
</div>

<div class="card">
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tiêu đề, phòng...">
    </div>
    <select class="form-control" style="width:auto;min-width:140px">
      <option value="">Tất cả trạng thái</option>
      <option value="open" <?= ($filters['status'] ?? '') === 'open' ? 'selected' : '' ?>>Đang mở</option>
      <option value="in_progress" <?= ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>Đang xử lý</option>
      <option value="resolved" <?= ($filters['status'] ?? '') === 'resolved' ? 'selected' : '' ?>>Đã xử lý</option>
    </select>
    <select class="form-control" style="width:auto;min-width:120px">
      <option value="">Mức độ</option>
      <option value="urgent" <?= ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' ?>>Khẩn cấp</option>
      <option value="high" <?= ($filters['priority'] ?? '') === 'high' ? 'selected' : '' ?>>Cao</option>
      <option value="medium" <?= ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' ?>>TB</option>
      <option value="low" <?= ($filters['priority'] ?? '') === 'low' ? 'selected' : '' ?>>Thấp</option>
    </select>
  </div>

  <?php if (!empty($requests)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Tiêu đề</th><th>Phòng</th><th>Người báo</th><th>Mức độ</th><th>Ngày báo</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($requests as $rq): ?>
            <?php $st = $rq['status'] ?? 'open'; [$sClass, $sLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; $pr = $rq['priority'] ?? 'medium'; [$pClass, $pLabel] = $priorityMap[$pr] ?? ['badge-neutral', $pr]; ?>
            <tr>
              <td><div style="font-weight:600"><?= htmlspecialchars($rq['title'] ?? '') ?></div><div class="sub"><?= htmlspecialchars(mb_strimwidth($rq['description'] ?? '', 0, 50, '...')) ?></div></td>
              <td style="font-weight:700"><?= htmlspecialchars($rq['room_number'] ?? '') ?><div class="sub"><?= htmlspecialchars($rq['building_name'] ?? '') ?></div></td>
              <td><?= htmlspecialchars($rq['reporter_name'] ?? '') ?></td>
              <td><span class="badge <?= $pClass ?>"><?= $pLabel ?></span></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($rq['reported_at']) ? date('d/m/Y', strtotime($rq['reported_at'])) : '—' ?></td>
              <td><span class="badge <?= $sClass ?>"><?= $sLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <?php if ($st === 'open' || $st === 'in_progress'): ?>
                  <form method="POST" action="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '') . '/resolve') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success btn-sm">✅ Xử lý</button></form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🔧</div><div class="empty-title">Không có yêu cầu bảo trì</div></div>
  <?php endif; ?>
</div>
