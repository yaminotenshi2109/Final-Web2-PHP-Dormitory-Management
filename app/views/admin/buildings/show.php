<?php
/**
 * admin/buildings/show.php — Chi tiết tòa nhà
 * Variables: $title, $building, $rooms[]
 */
$b = $building ?? [];
$statusMap = ['active'=>['badge-success','✅ Hoạt động'],'maintenance'=>['badge-warning','🔧 Bảo trì'],'closed'=>['badge-danger','🚫 Đóng cửa']];
$genderMap = ['male'=>'👨 Nam','female'=>'👩 Nữ','mixed'=>'👥 Hỗn hợp'];
$roomStatusMap = ['available'=>['badge-success','Trống'],'full'=>['badge-danger','Đầy'],'maintenance'=>['badge-warning','Bảo trì'],'inactive'=>['badge-neutral','Không sử dụng']];
$status = $b['status'] ?? 'active';
[$bClass, $bLabel] = $statusMap[$status] ?? ['badge-neutral', $status];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🏢 Tòa nhà <?= htmlspecialchars($b['name'] ?? '') ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars($b['address'] ?? '') ?></p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/buildings') ?>" class="btn btn-ghost">← Quay lại</a>
    <a href="<?= getDynamicUrl('/admin/buildings/' . ($b['id'] ?? '') . '/edit') ?>" class="btn btn-outline">✏️ Sửa</a>
  </div>
</div>

<!-- Building Info -->
<div class="grid-2 mb-24">
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin chung</div></div>
    <div class="card-body">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:8px 0;color:var(--txt-muted);width:140px">Tên tòa nhà</td><td style="padding:8px 0;font-weight:600"><?= htmlspecialchars($b['name'] ?? '') ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Số tầng</td><td style="padding:8px 0;font-weight:600"><?= $b['total_floors'] ?? 0 ?> tầng</td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Giới tính</td><td style="padding:8px 0"><?= $genderMap[$b['gender_type'] ?? ''] ?? '—' ?></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Trạng thái</td><td style="padding:8px 0"><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td></tr>
        <tr><td style="padding:8px 0;color:var(--txt-muted)">Địa chỉ</td><td style="padding:8px 0"><?= htmlspecialchars($b['address'] ?? '') ?></td></tr>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><div class="card-title">Quản lý tòa nhà</div></div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px">
        <div class="avatar avatar-lg">👤</div>
        <div>
          <div style="font-weight:700;font-size:16px"><?= htmlspecialchars($b['manager_name'] ?? '—') ?></div>
          <div style="color:var(--txt-muted);font-size:13px">Quản lý tòa nhà</div>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:8px;color:var(--txt-secondary);font-size:14px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <?= htmlspecialchars($b['manager_phone'] ?? '—') ?>
      </div>
    </div>
  </div>
</div>

<!-- Rooms List -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">🚪 Danh sách phòng</div>
      <div class="card-subtitle"><?= count($rooms ?? []) ?> phòng trong tòa nhà</div>
    </div>
    <a href="<?= getDynamicUrl('/admin/rooms/create?building_id=' . ($b['id'] ?? '')) ?>" class="btn btn-primary btn-sm">+ Thêm phòng</a>
  </div>

  <?php if (!empty($rooms)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead>
          <tr>
            <th>Phòng</th>
            <th>Tầng</th>
            <th>Loại</th>
            <th>Sức chứa</th>
            <th>Giá/tháng</th>
            <th>Trạng thái</th>
            <th style="text-align:right">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rooms as $r): ?>
            <?php
              $rs = $r['status'] ?? 'available';
              [$rClass, $rLabel] = $roomStatusMap[$rs] ?? ['badge-neutral', $rs];
            ?>
            <tr>
              <td style="font-weight:700"><?= htmlspecialchars($r['room_number'] ?? '') ?></td>
              <td>Tầng <?= $r['floor'] ?? 0 ?></td>
              <td><?= htmlspecialchars(ucfirst($r['room_type'] ?? 'standard')) ?></td>
              <td>
                <span style="font-weight:600"><?= $r['current_occupants'] ?? 0 ?></span>
                <span style="color:var(--txt-muted)">/ <?= $r['capacity'] ?? 0 ?></span>
              </td>
              <td style="font-weight:600"><?= number_format($r['price_per_month'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><span class="badge <?= $rClass ?>"><?= $rLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/rooms/' . ($r['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state" style="padding:40px">
      <div class="empty-icon">🚪</div>
      <div class="empty-title">Chưa có phòng</div>
      <div class="empty-msg">Tòa nhà này chưa có phòng nào.</div>
    </div>
  <?php endif; ?>
</div>
