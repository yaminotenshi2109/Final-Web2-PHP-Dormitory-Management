<?php
/**
 * admin/rooms/show.php — Chi tiết phòng
 * Variables: $title, $room, $amenities[], $students[]
 */
$r = $room ?? [];
$statusMap = ['available'=>['badge-success',' Trống'],'full'=>['badge-danger',' Đầy'],'maintenance'=>['badge-warning',' Bảo trì'],'inactive'=>['badge-neutral','Không dùng']];
$typeMap = ['standard'=>'Tiêu chuẩn','deluxe'=>'Cao cấp','ac_standard'=>'Tiêu chuẩn (ML)','ac_deluxe'=>'Cao cấp (ML)'];
$conditionMap = ['new'=>'badge-info','good'=>'badge-success','fair'=>'badge-warning','damaged'=>'badge-danger','broken'=>'badge-danger'];
$rs = $r['status'] ?? 'available';
[$rClass, $rLabel] = $statusMap[$rs] ?? ['badge-neutral', $rs];
$occupancy = ($r['capacity'] ?? 1) > 0 ? round(($r['current_occupants'] ?? 0) / $r['capacity'] * 100) : 0;
?>

<div class="page-header">
  <div>
    <h1 class="page-title"> Phòng <?= htmlspecialchars($r['room_number'] ?? '') ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars($r['building_name'] ?? '') ?> — Tầng <?= $r['floor'] ?? 0 ?></p>
  </div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/rooms') ?>" class="btn btn-ghost">← Quay lại</a>
    <a href="<?= getDynamicUrl('/admin/rooms/' . ($r['id'] ?? '') . '/edit') ?>" class="btn btn-outline"> Sửa</a>
  </div>
</div>

<div class="grid-2 mb-24">
  <!-- Room Info -->
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin phòng</div></div>
    <div class="card-body">
      <table style="width:100%;font-size:14px">
        <tr><td style="padding:10px 0;color:var(--txt-muted);width:140px">Số phòng</td><td style="font-weight:700;font-size:18px"><?= htmlspecialchars($r['room_number'] ?? '') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Tòa nhà</td><td style="font-weight:600"><?= htmlspecialchars($r['building_name'] ?? '—') ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Tầng</td><td>Tầng <?= $r['floor'] ?? 0 ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Loại phòng</td><td><?= $typeMap[$r['room_type'] ?? ''] ?? 'Standard' ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Điều hòa</td><td><?= ($r['has_ac'] ?? 0) ? ' Có' : '— Không' ?></td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Giá/tháng</td><td style="font-weight:700;font-size:16px;color:var(--brand)"><?= number_format($r['price_per_month'] ?? 0, 0, ',', '.') ?> VND</td></tr>
        <tr><td style="padding:10px 0;color:var(--txt-muted)">Trạng thái</td><td><span class="badge <?= $rClass ?>"><?= $rLabel ?></span></td></tr>
      </table>
    </div>
  </div>

  <!-- Occupancy -->
  <div class="card">
    <div class="card-header"><div class="card-title">Tình trạng sử dụng</div></div>
    <div class="card-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px">
      <div class="donut-ring" style="--pct:<?= $occupancy * 3.6 ?>deg;width:120px;height:120px;margin-bottom:16px">
        <div class="donut-value" style="font-size:24px"><?= $occupancy ?>%</div>
      </div>
      <div style="font-size:28px;font-weight:800;margin-bottom:4px"><?= $r['current_occupants'] ?? 0 ?> / <?= $r['capacity'] ?? 0 ?></div>
      <div style="color:var(--txt-muted);font-size:13px">sinh viên đang ở</div>
    </div>
  </div>
</div>

<!-- Amenities -->
<div class="card mb-24">
  <div class="card-header">
    <div class="card-title"> Trang thiết bị</div>
  </div>
  <?php if (!empty($amenities)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead>
          <tr><th>Thiết bị</th><th>Số lượng</th><th>Tình trạng</th><th>Kiểm tra lần cuối</th></tr>
        </thead>
        <tbody>
          <?php foreach ($amenities as $a): ?>
            <tr>
              <td style="font-weight:600"><?= htmlspecialchars($a['amenity_name'] ?? '') ?></td>
              <td><?= $a['quantity'] ?? 0 ?></td>
              <td><span class="badge <?= $conditionMap[$a['condition'] ?? 'good'] ?? 'badge-neutral' ?>"><?= ucfirst($a['condition'] ?? 'good') ?></span></td>
              <td style="color:var(--txt-muted)"><?= !empty($a['last_checked']) ? date('d/m/Y', strtotime($a['last_checked'])) : '—' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state" style="padding:40px"><div class="empty-icon" aria-hidden="true"></div><div class="empty-title">Chưa có thiết bị</div></div>
  <?php endif; ?>
</div>

<!-- Students in room -->
<div class="card">
  <div class="card-header"><div class="card-title"> Sinh viên đang ở</div></div>
  <?php if (!empty($students)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Mã SV</th><th>Khoa</th><th>SĐT</th></tr></thead>
        <tbody>
          <?php foreach ($students as $s): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="avatar avatar-sm"><?= mb_strtoupper(mb_substr($s['full_name'] ?? 'S', 0, 1)) ?></div>
                  <span style="font-weight:600"><?= htmlspecialchars($s['full_name'] ?? '') ?></span>
                </div>
              </td>
              <td style="font-family:monospace"><?= htmlspecialchars($s['student_code'] ?? '') ?></td>
              <td><?= htmlspecialchars($s['faculty'] ?? '') ?></td>
              <td><?= htmlspecialchars($s['phone'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state" style="padding:40px"><div class="empty-icon" aria-hidden="true"></div><div class="empty-title">Chưa có sinh viên</div></div>
  <?php endif; ?>
</div>
