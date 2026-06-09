<?php
/**
 * admin/utilities/create.php — Nhập chỉ số điện nước
 * Variables: $title, $rooms[], $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">⚡ Nhập chỉ số điện nước</h1><p class="page-subtitle">Ghi nhận chỉ số điện, nước theo phòng</p></div>
  <a href="<?= getDynamicUrl('/admin/utilities') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header"><div class="card-title">Chỉ số mới</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/utilities') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label" for="room_id">Phòng <span class="req">*</span></label>
          <select id="room_id" name="room_id" class="form-control" required>
            <option value="">— Chọn phòng —</option>
            <?php foreach ($rooms ?? [] as $r): ?>
              <option value="<?= $r['id'] ?>" <?= ($_old['room_id'] ?? '') == $r['id'] ? 'selected' : '' ?>><?= htmlspecialchars(($r['building_name'] ?? '') . ' — ' . ($r['room_number'] ?? '')) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="month">Tháng <span class="req">*</span></label>
          <select id="month" name="month" class="form-control" required>
            <?php for ($m = 1; $m <= 12; $m++): ?><option value="<?= $m ?>" <?= ($_old['month'] ?? date('n')) == $m ? 'selected' : '' ?>>Tháng <?= $m ?></option><?php endfor; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="year">Năm <span class="req">*</span></label>
          <input type="number" id="year" name="year" class="form-control" min="2024" value="<?= htmlspecialchars($_old['year'] ?? date('Y')) ?>" required>
        </div>
      </div>

      <div style="padding:16px;background:var(--page-bg);border-radius:var(--radius);margin-bottom:20px">
        <div style="font-weight:700;font-size:14px;margin-bottom:12px">⚡ Chỉ số điện (kWh)</div>
        <div class="form-row">
          <div class="form-group"><label class="form-label" for="elec_prev">Chỉ số đầu kỳ</label><input type="number" id="elec_prev" name="elec_prev" class="form-control" step="0.1" value="<?= htmlspecialchars($_old['elec_prev'] ?? '0') ?>" required></div>
          <div class="form-group"><label class="form-label" for="elec_curr">Chỉ số cuối kỳ</label><input type="number" id="elec_curr" name="elec_curr" class="form-control" step="0.1" value="<?= htmlspecialchars($_old['elec_curr'] ?? '') ?>" required></div>
        </div>
      </div>

      <div style="padding:16px;background:var(--page-bg);border-radius:var(--radius);margin-bottom:20px">
        <div style="font-weight:700;font-size:14px;margin-bottom:12px">💧 Chỉ số nước (m³)</div>
        <div class="form-row">
          <div class="form-group"><label class="form-label" for="water_prev">Chỉ số đầu kỳ</label><input type="number" id="water_prev" name="water_prev" class="form-control" step="0.1" value="<?= htmlspecialchars($_old['water_prev'] ?? '0') ?>" required></div>
          <div class="form-group"><label class="form-label" for="water_curr">Chỉ số cuối kỳ</label><input type="number" id="water_curr" name="water_curr" class="form-control" step="0.1" value="<?= htmlspecialchars($_old['water_curr'] ?? '') ?>" required></div>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/utilities') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">⚡ Lưu chỉ số</button>
      </div>
    </form>
  </div>
</div>
