<?php
/**
 * student/registrations/create.php — Tạo đơn đăng ký phòng
 * Variables: $title, $available_rooms[], $buildings[], $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">📋 Đăng ký phòng KTX</h1><p class="page-subtitle">Chọn phòng và gửi đơn đăng ký</p></div>
  <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="grid-2">
  <!-- Form -->
  <div class="card">
    <div class="card-header"><div class="card-title">Thông tin đăng ký</div></div>
    <div class="card-body">
      <form method="POST" action="<?= getDynamicUrl('/student/registrations') ?>">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

        <div class="form-group">
          <label class="form-label" for="building_id">Chọn tòa nhà <span class="req">*</span></label>
          <select id="building_id" name="building_id" class="form-control" required>
            <option value="">— Chọn tòa nhà —</option>
            <?php foreach ($buildings ?? [] as $bl): ?>
              <option value="<?= $bl['id'] ?>" <?= ($_old['building_id'] ?? '') == $bl['id'] ? 'selected' : '' ?>><?= htmlspecialchars($bl['name']) ?> (<?= ucfirst($bl['gender_type'] ?? '') ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="room_id">Chọn phòng <span class="req">*</span></label>
          <select id="room_id" name="room_id" class="form-control" required>
            <option value="">— Chọn phòng —</option>
            <?php foreach ($available_rooms ?? [] as $r): ?>
              <option value="<?= $r['id'] ?>" <?= ($_old['room_id'] ?? '') == $r['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($r['room_number']) ?> — Tầng <?= $r['floor'] ?? 0 ?> (<?= $r['current_occupants'] ?? 0 ?>/<?= $r['capacity'] ?? 0 ?>) — <?= number_format($r['price_per_month'] ?? 0, 0, ',', '.') ?>đ/tháng
              </option>
            <?php endforeach; ?>
          </select>
          <?php if (!empty($_errors['room_id'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['room_id']) ?></div><?php endif; ?>
        </div>

<<<<<<< HEAD
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="semester">Học kỳ <span class="req">*</span></label>
            <select id="semester" name="semester" class="form-control" required>
              <option value="1" <?= ($_old['semester'] ?? '') === '1' ? 'selected' : '' ?>>Học kỳ 1</option>
              <option value="2" <?= ($_old['semester'] ?? '') === '2' ? 'selected' : '' ?>>Học kỳ 2</option>
              <option value="3" <?= ($_old['semester'] ?? '') === '3' ? 'selected' : '' ?>>Hè</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="academic_year">Năm học <span class="req">*</span></label>
            <input type="text" id="academic_year" name="academic_year" class="form-control" placeholder="2025-2026" value="<?= htmlspecialchars($_old['academic_year'] ?? date('Y') . '-' . (date('Y') + 1)) ?>" required>
          </div>
=======
            <form action="/Final-Web2-PHP-Dormitory-Management/public/student/registrations" method="POST" id="registrationForm">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="_method" value="POST">

                <!-- Preferred Building -->
                <div class="form-group">
                    <label class="form-label" for="preferred_building_id">
                        🏢 Tòa nhà ưu tiên
                        <span style="font-weight:400;color:#94a3b8;font-size:12px;">(Tuỳ chọn)</span>
                    </label>
                    <select class="form-control <?= isset($errors['preferred_building_id']) ? 'is-invalid' : '' ?>"
                            id="preferred_building_id"
                            name="preferred_building_id">
                        <option value="">— Không có ưu tiên —</option>
                        <?php foreach ($buildings as $building): ?>
                            <option value="<?= (int)($building['id'] ?? 0) ?>"
                                <?= (oldValue($old, 'preferred_building_id') == ($building['id'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($building['name'] ?? '') ?>
                                <?php if (!empty($building['gender_type'])): ?>
                                    (<?= htmlspecialchars($building['gender_type']) ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= fieldError($errors, 'preferred_building_id') ?>
                    <div class="form-hint">Chọn tòa nhà bạn muốn ở nếu có. BQL sẽ cố gắng đáp ứng theo điều kiện thực tế.</div>
                </div>

                <!-- Preferred Room Type -->
                <div class="form-group">
                    <label class="form-label" for="preferred_room_type">
                        🛏️ Loại phòng ưu tiên
                        <span style="font-weight:400;color:#94a3b8;font-size:12px;">(Tuỳ chọn)</span>
                    </label>
                    <select class="form-control <?= isset($errors['preferred_room_type']) ? 'is-invalid' : '' ?>"
                            id="preferred_room_type"
                            name="preferred_room_type">
                        <option value="">— Không có ưu tiên —</option>
                        <option value="standard"    <?= oldValue($old, 'preferred_room_type') === 'standard'    ? 'selected' : '' ?>>
                            Phòng thường (Standard)
                        </option>
                        <option value="deluxe"      <?= oldValue($old, 'preferred_room_type') === 'deluxe'      ? 'selected' : '' ?>>
                            Phòng cao cấp (Deluxe)
                        </option>
                        <option value="ac_standard" <?= oldValue($old, 'preferred_room_type') === 'ac_standard' ? 'selected' : '' ?>>
                            Phòng thường có điều hoà (AC Standard)
                        </option>
                        <option value="ac_deluxe"   <?= oldValue($old, 'preferred_room_type') === 'ac_deluxe'   ? 'selected' : '' ?>>
                            Phòng cao cấp có điều hoà (AC Deluxe)
                        </option>
                    </select>
                    <?= fieldError($errors, 'preferred_room_type') ?>
                    <div class="form-hint">Loại phòng sẽ ảnh hưởng đến mức giá thuê hàng tháng.</div>
                </div>

                <!-- Room Type Info Cards -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px;">
                    <div style="background:#f8fafc;border-radius:10px;padding:12px;border:1px solid #e2e8f0;">
                        <div style="font-weight:700;font-size:13px;color:#1e293b;margin-bottom:4px;">🛏️ Phòng thường</div>
                        <div style="font-size:12px;color:#64748b;">Phòng cơ bản, không có điều hoà. Phù hợp với sinh viên tiết kiệm.</div>
                    </div>
                    <div style="background:#f8fafc;border-radius:10px;padding:12px;border:1px solid #e2e8f0;">
                        <div style="font-weight:700;font-size:13px;color:#1e293b;margin-bottom:4px;">⭐ Phòng cao cấp</div>
                        <div style="font-size:12px;color:#64748b;">Tiện nghi đầy đủ hơn, diện tích rộng hơn phòng thường.</div>
                    </div>
                    <div style="background:#eff6ff;border-radius:10px;padding:12px;border:1px solid #bfdbfe;">
                        <div style="font-weight:700;font-size:13px;color:#1e40af;margin-bottom:4px;">❄️ AC Standard</div>
                        <div style="font-size:12px;color:#3b82f6;">Phòng thường có trang bị điều hoà nhiệt độ.</div>
                    </div>
                    <div style="background:#eff6ff;border-radius:10px;padding:12px;border:1px solid #bfdbfe;">
                        <div style="font-weight:700;font-size:13px;color:#1e40af;margin-bottom:4px;">❄️⭐ AC Deluxe</div>
                        <div style="font-size:12px;color:#3b82f6;">Phòng cao cấp có điều hoà, tiện nghi tốt nhất.</div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label class="form-label" for="notes">
                        📝 Ghi chú / Yêu cầu đặc biệt
                        <span style="font-weight:400;color:#94a3b8;font-size:12px;">(Tuỳ chọn)</span>
                    </label>
                    <textarea class="form-control <?= isset($errors['notes']) ? 'is-invalid' : '' ?>"
                              id="notes"
                              name="notes"
                              rows="4"
                              maxlength="500"
                              placeholder="Ví dụ: Tôi có nhu cầu đặc biệt về sức khoẻ, muốn ở cùng bạn cùng lớp..."
                              oninput="updateCharCount(this)"><?= oldValue($old, 'notes') ?></textarea>
                    <?= fieldError($errors, 'notes') ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px;">
                        <div class="form-hint">Ghi rõ yêu cầu đặc biệt (nếu có) để BQL xem xét.</div>
                        <span id="charCount" style="font-size:12px;color:#94a3b8;">0/500</span>
                    </div>
                </div>

                <!-- Notice -->
                <div style="background:#fefce8;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;margin-bottom:24px;font-size:13px;color:#713f12;display:flex;gap:10px;">
                    <span style="flex-shrink:0;">💡</span>
                    <div>
                        <strong>Lưu ý:</strong> Sau khi gửi đơn, BQL sẽ xem xét và phân phòng trong thời gian sớm nhất.
                        Bạn sẽ nhận được thông báo qua hệ thống khi có kết quả.
                        Mỗi sinh viên chỉ được có <strong>một đơn đăng ký</strong> đang chờ xử lý tại một thời điểm.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="flex:1;min-width:120px;">
                        ✅ Gửi đơn đăng ký
                    </button>
                    <a href="/Final-Web2-PHP-Dormitory-Management/public/student/registrations" class="btn btn-outline" style="flex:1;min-width:120px;text-align:center;">
                        ✕ Huỷ bỏ
                    </a>
                </div>
            </form>
>>>>>>> cab58fd2b4b300bab02822a36621ded10784ddfb
        </div>

        <div class="form-group">
          <label class="form-label" for="note">Ghi chú</label>
          <textarea id="note" name="note" class="form-control" placeholder="Lý do đăng ký, yêu cầu đặc biệt..." rows="3"><?= htmlspecialchars($_old['note'] ?? '') ?></textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
          <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-ghost">Hủy</a>
          <button type="submit" class="btn btn-primary">📋 Gửi đăng ký</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Info panel -->
  <div>
    <div class="card mb-16">
      <div class="card-header"><div class="card-title">ℹ️ Hướng dẫn</div></div>
      <div class="card-body" style="font-size:13px;line-height:1.8;color:var(--txt-secondary)">
        <ol style="padding-left:18px;list-style:decimal">
          <li>Chọn tòa nhà phù hợp với giới tính</li>
          <li>Chọn phòng còn trống</li>
          <li>Gửi đơn và chờ admin duyệt</li>
          <li>Sau khi được duyệt, hợp đồng sẽ được tạo tự động</li>
        </ol>
      </div>
    </div>
    <div class="alert alert-info">
      <span class="alert-icon">💡</span>
      <div class="alert-content"><p class="alert-msg">Đơn đăng ký sẽ được xử lý trong vòng 2-3 ngày làm việc.</p></div>
    </div>
  </div>
</div>
