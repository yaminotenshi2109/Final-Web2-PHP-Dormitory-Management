<?php
/**
 * admin/users/index.php — Quản lý tài khoản
 * Variables: $title, $users[], $stats, $filters
 */
$roleMap = ['admin'=>['badge-purple','👑 Admin'],'student'=>['badge-info','🎓 Sinh viên']];
$statusMap = ['active'=>['badge-success','✅ Hoạt động'],'inactive'=>['badge-neutral','⚪ Ngừng'],'banned'=>['badge-danger','🚫 Cấm']];
?>

<div class="page-header">
  <div><h1 class="page-title">👥 Quản lý Người dùng</h1><p class="page-subtitle">Quản lý tài khoản hệ thống</p></div>
  <div class="page-actions"><a href="<?= getDynamicUrl('/admin/users/create') ?>" class="btn btn-primary">+ Tạo tài khoản</a></div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">👥</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng tài khoản</div></div></div>
  <div class="stat-card" style="--stat-color:#8b5cf6;--stat-icon-bg:#ede9fe"><div class="stat-icon">👑</div><div><div class="stat-value"><?= number_format($stats['admins'] ?? 0) ?></div><div class="stat-label">Admin</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">🎓</div><div><div class="stat-value"><?= number_format($stats['students'] ?? 0) ?></div><div class="stat-label">Sinh viên</div></div></div>
</div>

<div class="card">
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tên, email...">
    </div>
    <select class="form-control" style="width:auto;min-width:120px">
      <option value="">Tất cả role</option>
      <option value="admin" <?= ($filters['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
      <option value="student" <?= ($filters['role'] ?? '') === 'student' ? 'selected' : '' ?>>Sinh viên</option>
    </select>
  </div>

  <?php if (!empty($users)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Người dùng</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th>Ngày tạo</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <?php $role = $u['role'] ?? 'student'; [$rClass, $rLabel] = $roleMap[$role] ?? ['badge-neutral', $role]; $st = $u['status'] ?? 'active'; [$sClass, $sLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-md"><?= mb_strtoupper(mb_substr($u['username'] ?? 'U', 0, 1)) ?></div>
                  <span style="font-weight:700"><?= htmlspecialchars($u['username'] ?? '') ?></span>
                </div>
              </td>
              <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
              <td><span class="badge <?= $rClass ?>"><?= $rLabel ?></span></td>
              <td><span class="badge <?= $sClass ?>"><?= $sLabel ?></span></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($u['created_at']) ? date('d/m/Y', strtotime($u['created_at'])) : '—' ?></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/users/' . ($u['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <a href="<?= getDynamicUrl('/admin/users/' . ($u['id'] ?? '') . '/edit') ?>" class="btn btn-outline btn-sm">Sửa</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">👥</div><div class="empty-title">Chưa có tài khoản</div></div>
  <?php endif; ?>
</div>
