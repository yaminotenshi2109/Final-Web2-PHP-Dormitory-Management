<?php
/**
 * admin/registrations/index.php — Đăng ký phòng
 * Variables: $title, $registrations[], $stats, $filters
 */
$statusMap = ['pending'=>['badge-warning','⏳ Chờ duyệt'],'approved'=>['badge-success','✅ Đã duyệt'],'rejected'=>['badge-danger','❌ Từ chối'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">📋 Đăng ký phòng</h1>
    <p class="page-subtitle">Quản lý đơn đăng ký phòng của sinh viên</p>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">📋</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng đơn</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⏳</div><div><div class="stat-value"><?= number_format($stats['pending'] ?? 0) ?></div><div class="stat-label">Chờ duyệt</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($stats['approved'] ?? 0) ?></div><div class="stat-label">Đã duyệt</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">❌</div><div><div class="stat-value"><?= number_format($stats['rejected'] ?? 0) ?></div><div class="stat-label">Từ chối</div></div></div>
</div>

<!-- Tabs -->
<div class="tabs mb-0">
  <a href="<?= getDynamicUrl('/admin/registrations') ?>" class="tab-link <?= empty($filters['status'] ?? '') ? 'active' : '' ?>">Tất cả</a>
  <a href="<?= getDynamicUrl('/admin/registrations?status=pending') ?>" class="tab-link <?= ($filters['status'] ?? '') === 'pending' ? 'active' : '' ?>">⏳ Chờ duyệt <?php if (($stats['pending'] ?? 0) > 0): ?><span class="nav-badge" style="margin-left:4px"><?= $stats['pending'] ?></span><?php endif; ?></a>
  <a href="<?= getDynamicUrl('/admin/registrations?status=approved') ?>" class="tab-link <?= ($filters['status'] ?? '') === 'approved' ? 'active' : '' ?>">✅ Đã duyệt</a>
  <a href="<?= getDynamicUrl('/admin/registrations?status=rejected') ?>" class="tab-link <?= ($filters['status'] ?? '') === 'rejected' ? 'active' : '' ?>">❌ Từ chối</a>
</div>

<div class="card" style="border-top-left-radius:0;border-top-right-radius:0">
  <?php if (!empty($registrations)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Phòng</th><th>Học kỳ</th><th>Ngày nộp</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($registrations as $reg): ?>
            <?php $st = $reg['status'] ?? 'pending'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-sm"><?= mb_strtoupper(mb_substr($reg['student_name'] ?? 'S', 0, 1)) ?></div>
                  <div><div style="font-weight:600"><?= htmlspecialchars($reg['student_name'] ?? '') ?></div><div class="sub"><?= htmlspecialchars($reg['student_code'] ?? '') ?></div></div>
                </div>
              </td>
              <td><span style="font-weight:700"><?= htmlspecialchars($reg['room_number'] ?? '') ?></span> <span class="sub"><?= htmlspecialchars($reg['building_name'] ?? '') ?></span></td>
              <td><?= htmlspecialchars(($reg['semester'] ?? '') . '/' . ($reg['academic_year'] ?? '')) ?></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($reg['registered_at']) ? date('d/m/Y H:i', strtotime($reg['registered_at'])) : '—' ?></td>
              <td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td>
              <td style="text-align:right">
                <div style="display:flex;gap:6px;justify-content:flex-end">
                  <?php if ($st === 'pending'): ?>
                    <form method="POST" action="<?= getDynamicUrl('/admin/registrations/' . ($reg['id'] ?? '') . '/approve') ?>" style="display:inline">
                      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                      <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Duyệt đơn này?')">✅ Duyệt</button>
                    </form>
                    <form method="POST" action="<?= getDynamicUrl('/admin/registrations/' . ($reg['id'] ?? '') . '/reject') ?>" style="display:inline">
                      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                      <button type="submit" class="btn btn-danger-outline btn-sm" onclick="return confirm('Từ chối đơn này?')">❌ Từ chối</button>
                    </form>
                  <?php endif; ?>
                  <a href="<?= getDynamicUrl('/admin/registrations/' . ($reg['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">📋</div><div class="empty-title">Không có đơn đăng ký</div><div class="empty-msg">Chưa có đơn nào phù hợp với bộ lọc.</div></div>
  <?php endif; ?>
</div>
