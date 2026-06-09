<?php
/**
 * admin/rooms/index.php — Danh sách phòng
 * Variables: $title, $rooms[], $buildings[], $stats, $filters, $pagination
 */
$statusMap = ['available'=>['badge-success','✅ Trống'],'full'=>['badge-danger','🔴 Đầy'],'maintenance'=>['badge-warning','🔧 Bảo trì'],'inactive'=>['badge-neutral','⚪ Không dùng']];
$typeMap = ['standard'=>'Tiêu chuẩn','deluxe'=>'Cao cấp','ac_standard'=>'Tiêu chuẩn (ML)','ac_deluxe'=>'Cao cấp (ML)'];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🚪 Quản lý Phòng</h1>
    <p class="page-subtitle">Danh sách phòng ở trong các tòa nhà KTX</p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/rooms/create') ?>" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Thêm phòng
    </a>
  </div>
</div>

<!-- Stats -->
<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff">
    <div class="stat-icon">🚪</div>
    <div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng phòng</div></div>
  </div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5">
    <div class="stat-icon">✅</div>
    <div><div class="stat-value"><?= number_format($stats['available'] ?? 0) ?></div><div class="stat-label">Còn trống</div></div>
  </div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2">
    <div class="stat-icon">🔴</div>
    <div><div class="stat-value"><?= number_format($stats['full'] ?? 0) ?></div><div class="stat-label">Đã đầy</div></div>
  </div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7">
    <div class="stat-icon">🔧</div>
    <div><div class="stat-value"><?= number_format($stats['maintenance'] ?? 0) ?></div><div class="stat-label">Bảo trì</div></div>
  </div>
</div>

<!-- Rooms Table -->
<div class="card">
  <!-- Filter bar -->
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo số phòng..." id="roomSearch" value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
    </div>
    <select class="form-control" style="width:auto;min-width:140px" id="filterBuilding">
      <option value="">Tất cả tòa nhà</option>
      <?php foreach ($buildings ?? [] as $bl): ?>
        <option value="<?= $bl['id'] ?>" <?= ($filters['building_id'] ?? '') == $bl['id'] ? 'selected' : '' ?>><?= htmlspecialchars($bl['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <select class="form-control" style="width:auto;min-width:120px" id="filterStatus">
      <option value="">Tất cả trạng thái</option>
      <option value="available" <?= ($filters['status'] ?? '') === 'available' ? 'selected' : '' ?>>Trống</option>
      <option value="full" <?= ($filters['status'] ?? '') === 'full' ? 'selected' : '' ?>>Đầy</option>
      <option value="maintenance" <?= ($filters['status'] ?? '') === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
    </select>
  </div>

  <?php if (!empty($rooms)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead>
          <tr>
            <th>Phòng</th>
            <th>Tòa nhà</th>
            <th>Tầng</th>
            <th>Loại phòng</th>
            <th>Sức chứa</th>
            <th>Giá/tháng</th>
            <th>Điều hòa</th>
            <th>Trạng thái</th>
            <th style="text-align:right">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rooms as $r): ?>
            <?php
              $rs = $r['status'] ?? 'available';
              [$rClass, $rLabel] = $statusMap[$rs] ?? ['badge-neutral', $rs];
              $occupancy = ($r['capacity'] ?? 1) > 0 ? round(($r['current_occupants'] ?? 0) / $r['capacity'] * 100) : 0;
            ?>
            <tr>
              <td style="font-weight:700;font-size:15px"><?= htmlspecialchars($r['room_number'] ?? '') ?></td>
              <td><?= htmlspecialchars($r['building_name'] ?? '—') ?></td>
              <td>Tầng <?= $r['floor'] ?? 0 ?></td>
              <td><?= $typeMap[$r['room_type'] ?? ''] ?? 'Standard' ?></td>
              <td>
                <div style="display:flex;align-items:center;gap:8px">
                  <span style="font-weight:600"><?= $r['current_occupants'] ?? 0 ?>/<?= $r['capacity'] ?? 0 ?></span>
                  <div class="progress" style="width:60px;height:6px">
                    <div class="progress-bar <?= $occupancy >= 100 ? 'danger' : ($occupancy >= 70 ? 'warning' : 'success') ?>" style="width:<?= $occupancy ?>%"></div>
                  </div>
                </div>
              </td>
              <td style="font-weight:600;color:var(--txt-primary)"><?= number_format($r['price_per_month'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><?= ($r['has_ac'] ?? 0) ? '<span style="color:var(--info)">❄️ Có</span>' : '<span style="color:var(--txt-muted)">—</span>' ?></td>
              <td><span class="badge <?= $rClass ?>"><?= $rLabel ?></span></td>
              <td style="text-align:right">
                <div style="display:flex;gap:6px;justify-content:flex-end">
                  <a href="<?= getDynamicUrl('/admin/rooms/' . ($r['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                  <a href="<?= getDynamicUrl('/admin/rooms/' . ($r['id'] ?? '') . '/edit') ?>" class="btn btn-outline btn-sm">Sửa</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (!empty($pagination)): ?>
      <div class="card-footer">
        <?php include __DIR__ . '/../../components/pagination.php'; ?>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <div class="empty-state">
      <div class="empty-icon">🚪</div>
      <div class="empty-title">Chưa có phòng nào</div>
      <div class="empty-msg">Thêm phòng mới để bắt đầu quản lý.</div>
      <a href="<?= getDynamicUrl('/admin/rooms/create') ?>" class="btn btn-primary mt-16">Thêm phòng</a>
    </div>
  <?php endif; ?>
</div>
