<?php
/**
 * admin/students/index.php — Danh sách sinh viên
 * Variables: $title, $students[], $stats, $filters, $pagination
 */
$genderMap = ['male'=>'👨 Nam','female'=>'👩 Nữ'];
$priorityMap = [0=>'Bình thường',1=>'Chính sách',2=>'Ưu tiên cao'];
$priorityBadge = [0=>'badge-neutral',1=>'badge-info',2=>'badge-purple'];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🎓 Quản lý Sinh viên</h1>
    <p class="page-subtitle">Danh sách sinh viên trong hệ thống KTX</p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/students/create') ?>" class="btn btn-primary">+ Thêm sinh viên</a>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#8b5cf6;--stat-icon-bg:#ede9fe">
    <div class="stat-icon">🎓</div>
    <div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng sinh viên</div></div>
  </div>
  <div class="stat-card" style="--stat-color:#3b82f6;--stat-icon-bg:#eff6ff">
    <div class="stat-icon">👨</div>
    <div><div class="stat-value"><?= number_format($stats['male'] ?? 0) ?></div><div class="stat-label">Nam</div></div>
  </div>
  <div class="stat-card" style="--stat-color:#ec4899;--stat-icon-bg:#fce7f3">
    <div class="stat-icon">👩</div>
    <div><div class="stat-value"><?= number_format($stats['female'] ?? 0) ?></div><div class="stat-label">Nữ</div></div>
  </div>
</div>

<div class="card">
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tên, mã SV..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
    </div>
    <select class="form-control" style="width:auto;min-width:130px">
      <option value="">Tất cả giới tính</option>
      <option value="male" <?= ($filters['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Nam</option>
      <option value="female" <?= ($filters['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
    </select>
  </div>

  <?php if (!empty($students)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Mã SV</th><th>Giới tính</th><th>Khoa</th><th>SĐT</th><th>Ưu tiên</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($students as $s): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-md"><?= mb_strtoupper(mb_substr($s['full_name'] ?? 'S', 0, 1)) ?></div>
                  <div>
                    <div style="font-weight:700"><?= htmlspecialchars($s['full_name'] ?? '') ?></div>
                    <div class="sub"><?= htmlspecialchars($s['email'] ?? '') ?></div>
                  </div>
                </div>
              </td>
              <td style="font-family:monospace;font-weight:600"><?= htmlspecialchars($s['student_code'] ?? '') ?></td>
              <td><?= $genderMap[$s['gender'] ?? ''] ?? '—' ?></td>
              <td><?= htmlspecialchars($s['faculty'] ?? '') ?></td>
              <td><?= htmlspecialchars($s['phone'] ?? '') ?></td>
              <td><span class="badge <?= $priorityBadge[$s['priority_level'] ?? 0] ?? 'badge-neutral' ?>"><?= $priorityMap[$s['priority_level'] ?? 0] ?? 'N/A' ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/students/' . ($s['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <a href="<?= getDynamicUrl('/admin/students/' . ($s['id'] ?? '') . '/edit') ?>" class="btn btn-outline btn-sm">Sửa</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php if (!empty($pagination)): ?>
      <div class="card-footer"><?php include __DIR__ . '/../../components/pagination.php'; ?></div>
    <?php endif; ?>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🎓</div><div class="empty-title">Chưa có sinh viên</div><div class="empty-msg">Sinh viên sẽ xuất hiện khi đăng ký tài khoản.</div></div>
  <?php endif; ?>
</div>
