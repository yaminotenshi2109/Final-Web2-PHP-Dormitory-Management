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
      <option value="active">Chưa xử lý</option>
      <option value="appealed">Khiếu nại</option>
      <option value="dismissed">Bác bỏ</option>
    </select>
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

<!-- Pagination -->
<?php if (!empty($pagination) && ($pagination['total_pages'] ?? 1) > 1): ?>
    <div class="pagination">
        <?php
        $cur   = (int)($pagination['current_page'] ?? 1);
        $total = (int)($pagination['total_pages'] ?? 1);
        $qs    = http_build_query(array_filter([
            'search'   => $search   ?? '',
            'status'   => $status   ?? '',
            'severity' => $severity ?? '',
        ]));
        ?>
        <?php if ($cur > 1): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/violations?page=<?= $cur - 1 ?>&<?= $qs ?>" class="page-link">‹ Trước</a>
        <?php endif; ?>
        <?php for ($p = max(1, $cur - 2); $p <= min($total, $cur + 2); $p++): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/violations?page=<?= $p ?>&<?= $qs ?>"
               class="page-link <?= $p === $cur ? 'active' : '' ?>"><?= $p ?></a>
        <?php endfor; ?>
        <?php if ($cur < $total): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/violations?page=<?= $cur + 1 ?>&<?= $qs ?>" class="page-link">Sau ›</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Modal: Ghi nhận vi phạm -->
<div class="modal-overlay" id="modal-add-violation" data-modal-close="modal-add-violation" style="display:none">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
                <h3 class="card-title">⚠️ Ghi nhận vi phạm</h3>
                <button class="btn btn-ghost btn-sm" data-modal-close="modal-add-violation">✕</button>
            </div>
            <div class="card-body">
                <form id="form-add-violation" novalidate>
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

                    <div class="form-group">
                        <label class="form-label" for="fv-student-id">
                            Mã sinh viên (ID) <span style="color:#ef4444">*</span>
                        </label>
                        <input
                            type="number"
                            id="fv-student-id"
                            name="student_id"
                            class="form-control"
                            placeholder="Nhập ID sinh viên..."
                            min="1"
                            required
                        >
                        <div class="form-error" id="err-student-id" style="display:none"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fv-type">
                            Loại vi phạm <span style="color:#ef4444">*</span>
                        </label>
                        <select id="fv-type" name="violation_type" class="form-control" required>
                            <option value="">-- Chọn loại vi phạm --</option>
                            <?php foreach ($types ?? [] as $t): ?>
                                <option value="<?= htmlspecialchars(is_array($t) ? ($t['id'] ?? $t['name'] ?? $t) : $t) ?>">
                                    <?= htmlspecialchars(is_array($t) ? ($t['name'] ?? $t['label'] ?? $t) : $t) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error" id="err-type" style="display:none"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fv-desc">Mô tả chi tiết</label>
                        <textarea
                            id="fv-desc"
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Mô tả hành vi vi phạm..."
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fv-points">
                            Điểm trừ tùy chỉnh
                        </label>
                        <input
                            type="number"
                            id="fv-points"
                            name="override_points"
                            class="form-control"
                            placeholder="Để trống = áp dụng mặc định theo loại"
                            min="0"
                            max="100"
                        >
                        <div class="form-hint">Nếu để trống, hệ thống sẽ dùng điểm trừ mặc định của loại vi phạm.</div>
                    </div>

                    <div id="form-add-violation-alert" style="display:none"></div>
                </form>
            </div>
            <div class="card-footer" style="display:flex;justify-content:flex-end;gap:10px">
                <button class="btn btn-outline" data-modal-close="modal-add-violation">Hủy</button>
                <button class="btn btn-primary" id="btn-submit-violation">💾 Ghi nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    // Modal open/close
    document.querySelectorAll('[data-modal-open]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-modal-open');
            var modal = document.getElementById(id);
            if (modal) modal.style.display = 'flex';
        });
    });
    document.querySelectorAll('[data-modal-close]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-modal-close');
            var modal = document.getElementById(id);
            if (modal) modal.style.display = 'none';
        });
    });

    // Submit violation via ktxFetch
    var submitBtn = document.getElementById('btn-submit-violation');
    if (submitBtn) {
        submitBtn.addEventListener('click', function () {
            var form    = document.getElementById('form-add-violation');
            var alert   = document.getElementById('form-add-violation-alert');
            var errSid  = document.getElementById('err-student-id');
            var errType = document.getElementById('err-type');

            // Reset errors
            errSid.style.display  = 'none';
            errType.style.display = 'none';
            alert.style.display   = 'none';

            var data = {
                _csrf_token:    form.querySelector('[name="_csrf_token"]').value,
                student_id:     form.querySelector('[name="student_id"]').value.trim(),
                violation_type: form.querySelector('[name="violation_type"]').value,
                description:    form.querySelector('[name="description"]').value.trim(),
                override_points:form.querySelector('[name="override_points"]').value.trim(),
            };

            var valid = true;
            if (!data.student_id) {
                errSid.textContent = 'Vui lòng nhập ID sinh viên.';
                errSid.style.display = 'block';
                valid = false;
            }
            if (!data.violation_type) {
                errType.textContent = 'Vui lòng chọn loại vi phạm.';
                errType.style.display = 'block';
                valid = false;
            }
            if (!valid) return;

            submitBtn.disabled = true;
            submitBtn.textContent = '⏳ Đang lưu...';

            if (!data.override_points) delete data.override_points;

            ktxFetch('POST', '/Final-Web2-PHP-Dormitory-Management/public/api/violations', data)
                .then(function (res) {
                    if (res && res.success) {
                        alert.innerHTML = '<div class="alert alert-success">✅ Ghi nhận vi phạm thành công!</div>';
                        alert.style.display = 'block';
                        setTimeout(function () { location.reload(); }, 1200);
                    } else {
                        throw new Error((res && res.message) ? res.message : 'Có lỗi xảy ra.');
                    }
                })
                .catch(function (err) {
                    alert.innerHTML = '<div class="alert alert-danger">❌ ' + (err.message || 'Có lỗi xảy ra.') + '</div>';
                    alert.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = '💾 Ghi nhận';
                });
        });
    }
})();
</script>
