<?php
/**
 * student/maintenance/index.php — Bảo trì (SV)
 * Variables: $title, $requests[], $_csrfToken
 */
$statusMap = [
    'open'        => ['class' => 'badge-warning', 'label' => '⏳ Đang chờ'],
    'in_progress' => ['class' => 'badge-info',    'label' => '🔧 Đang xử lý'],
    'resolved'    => ['class' => 'badge-success', 'label' => '✅ Đã xử lý'],
    'closed'      => ['class' => 'badge-neutral', 'label' => '🔒 Đóng'],
    'rejected'    => ['class' => 'badge-danger',  'label' => '❌ Từ chối'],
];
$priorityMap = [
    'low'    => ['class' => 'badge-neutral', 'label' => 'Thấp'],
    'medium' => ['class' => 'badge-info',    'label' => 'Trung bình'],
    'high'   => ['class' => 'badge-warning', 'label' => 'Cao'],
    'urgent' => ['class' => 'badge-danger',  'label' => '🔥 Khẩn cấp'],
];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">🔧 Yêu cầu bảo trì</h1>
    <p class="page-subtitle">Gửi và theo dõi yêu cầu sửa chữa phòng ở</p>
  </div>
  <div class="page-actions">
    <button class="btn btn-primary" data-modal-open="newRequestModal">＋ Tạo yêu cầu mới</button>
  </div>
</div>

<?php if (!empty($requests)): ?>
  <div style="display:flex;flex-direction:column;gap:14px">
    <?php foreach ($requests as $rq): ?>
      <?php
        $st = $rq['status'] ?? 'open';
        $stInfo = $statusMap[$st] ?? ['class' => 'badge-neutral', 'label' => $st];
        $pr = $rq['priority'] ?? 'low';
        $prInfo = $priorityMap[$pr] ?? ['class' => 'badge-neutral', 'label' => $pr];
      ?>
      <div class="card">
        <div class="card-body" style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap">
          <div style="width:48px;height:48px;border-radius:var(--radius);background:var(--warning-bg,#fef3c7);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0">🔧</div>
          <div style="flex:1;min-width:200px">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px">
              <span style="font-weight:700;font-size:15px"><?= htmlspecialchars($rq['title'] ?? '') ?></span>
              <span class="badge <?= htmlspecialchars($prInfo['class']) ?>"><?= $prInfo['label'] ?></span>
              <span class="badge <?= htmlspecialchars($stInfo['class']) ?>"><?= $stInfo['label'] ?></span>
            </div>
            <?php if (!empty($rq['building_name']) || !empty($rq['room_number'])): ?>
              <div style="font-size:12px;color:var(--txt-muted,#6b7280);margin-bottom:4px">
                📍 <?= htmlspecialchars(($rq['building_name'] ?? '') . ' — Phòng ' . ($rq['room_number'] ?? '')) ?>
              </div>
            <?php endif; ?>
            <div style="color:var(--txt-muted,#6b7280);font-size:13px"><?= htmlspecialchars($rq['description'] ?? '') ?></div>
            <div style="display:flex;gap:12px;margin-top:8px;font-size:12px;color:var(--txt-muted,#6b7280);flex-wrap:wrap">
              <span>📅 Gửi: <?= !empty($rq['reported_at']) ? date('d/m/Y H:i', strtotime($rq['reported_at'])) : '—' ?></span>
              <?php if (!empty($rq['resolved_at'])): ?>
                <span>✅ Xử lý: <?= date('d/m/Y H:i', strtotime($rq['resolved_at'])) ?></span>
              <?php endif; ?>
            </div>
            <?php if (!empty($rq['admin_notes'])): ?>
              <div style="margin-top:8px;padding:8px 12px;background:var(--page-bg,#f9fafb);border-radius:6px;font-size:13px;border-left:3px solid var(--primary,#6366f1)">
                💬 <?= htmlspecialchars($rq['admin_notes']) ?>
              </div>
            <?php endif; ?>
          </div>
          <?php if ($st === 'open'): ?>
            <button class="btn btn-outline btn-sm btn-cancel-req"
                    data-id="<?= (int)$rq['id'] ?>"
                    data-title="<?= htmlspecialchars($rq['title'] ?? '') ?>"
                    style="align-self:flex-start;flex-shrink:0">
              Hủy yêu cầu
            </button>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="card">
    <div class="empty-state">
      <div class="empty-icon" aria-hidden="true">🔧</div>
      <div class="empty-title">Chưa có yêu cầu bảo trì</div>
      <div class="empty-msg">Nhấn <strong>"Tạo yêu cầu mới"</strong> để gửi yêu cầu khi phòng cần sửa chữa.</div>
    </div>
  </div>
<?php endif; ?>

<!-- ══ Modal: Tạo yêu cầu mới ══ -->
<div class="modal-overlay" id="newRequestModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">🔧 Tạo yêu cầu bảo trì</div>
      <button class="modal-close" data-modal-close="newRequestModal" aria-label="Đóng">×</button>
    </div>
    <form id="form-maintenance" novalidate>
      <div class="modal-body" style="display:flex;flex-direction:column;gap:16px">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

        <div id="maint-alert" style="display:none"></div>

        <div class="form-group">
          <label class="form-label" for="m-title">Tiêu đề <span style="color:#ef4444">*</span></label>
          <input type="text" id="m-title" name="title" class="form-control"
                 placeholder="VD: Hỏng điều hòa, vòi nước bị rỉ..." required autofocus>
          <div id="err-m-title" style="display:none;color:#ef4444;font-size:12px;margin-top:4px"></div>
        </div>

        <div class="form-group">
          <label class="form-label" for="m-priority">Mức độ ưu tiên</label>
          <select id="m-priority" name="priority" class="form-control">
            <option value="low">🟢 Thấp — không ảnh hưởng sinh hoạt</option>
            <option value="medium" selected>🟡 Trung bình — gây bất tiện</option>
            <option value="high">🟠 Cao — ảnh hưởng nhiều</option>
            <option value="urgent">🔴 Khẩn cấp — cần xử lý ngay</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="m-description">Mô tả chi tiết <span style="color:#ef4444">*</span></label>
          <textarea id="m-description" name="description" class="form-control" rows="4"
                    placeholder="Mô tả chi tiết vấn đề: vị trí, tình trạng, ảnh hưởng..."></textarea>
          <div id="err-m-desc" style="display:none;color:#ef4444;font-size:12px;margin-top:4px"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-ghost" data-modal-close="newRequestModal">Hủy</button>
        <button type="submit" class="btn btn-primary" id="btn-submit-maint">🔧 Gửi yêu cầu</button>
      </div>
    </form>
  </div>
</div>

<script>
(function () {
    var apiUrl = '<?= getDynamicUrl('/student/maintenance') ?>';

    // ── Submit form ────────────────────────────────────────────
    document.getElementById('form-maintenance').addEventListener('submit', function (e) {
        e.preventDefault();

        var titleEl = document.getElementById('m-title');
        var descEl  = document.getElementById('m-description');
        var prioEl  = document.getElementById('m-priority');
        var alertEl = document.getElementById('maint-alert');
        var errT    = document.getElementById('err-m-title');
        var errD    = document.getElementById('err-m-desc');

        // Reset
        errT.style.display = errD.style.display = alertEl.style.display = 'none';
        errT.textContent = errD.textContent = '';

        var titleVal = titleEl.value.trim();
        var descVal  = descEl.value.trim();
        var valid = true;

        if (!titleVal) {
            errT.textContent = 'Vui lòng nhập tiêu đề.';
            errT.style.display = 'block';
            valid = false;
        }
        if (!descVal) {
            errD.textContent = 'Vui lòng nhập mô tả chi tiết.';
            errD.style.display = 'block';
            valid = false;
        }
        if (!valid) return;

        var btn = document.getElementById('btn-submit-maint');
        btn.disabled = true;
        btn.textContent = '⏳ Đang gửi...';

        ktxFetch(apiUrl, {
            method : 'POST',
            body   : JSON.stringify({
                _csrf_token : document.querySelector('[name="_csrf_token"]').value,
                title       : titleVal,
                description : descVal,
                priority    : prioEl.value,
            })
        })
        .then(function () {
            closeModal('newRequestModal');
            toast('✅ Gửi yêu cầu bảo trì thành công!', 'success');
            setTimeout(function () { location.reload(); }, 1400);
        })
        .catch(function (err) {
            var msg = (err && err.message) ? err.message : 'Có lỗi xảy ra. Vui lòng thử lại.';

            if (err && err.errors) {
                if (err.errors.title) {
                    errT.textContent = Array.isArray(err.errors.title) ? err.errors.title[0] : err.errors.title;
                    errT.style.display = 'block';
                }
                if (err.errors.description) {
                    errD.textContent = Array.isArray(err.errors.description) ? err.errors.description[0] : err.errors.description;
                    errD.style.display = 'block';
                }
            }

            alertEl.innerHTML = '<div class="alert alert-error"><div class="alert-content"><p class="alert-msg">' + msg + '</p></div></div>';
            alertEl.style.display = 'block';
            btn.disabled = false;
            btn.textContent = '🔧 Gửi yêu cầu';
        });
    });

    // ── Cancel buttons ─────────────────────────────────────────
    document.querySelectorAll('.btn-cancel-req').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id    = btn.getAttribute('data-id');
            var title = btn.getAttribute('data-title');
            if (!confirm('Hủy yêu cầu "' + title + '"?')) return;

            btn.disabled = true;
            btn.textContent = '⏳...';

            ktxFetch(apiUrl + '/' + id, {
                method : 'DELETE',
                body   : JSON.stringify({
                    _csrf_token: document.querySelector('[name="_csrf_token"]').value
                })
            })
            .then(function () {
                toast('✅ Đã hủy yêu cầu.', 'success');
                setTimeout(function () { location.reload(); }, 1000);
            })
            .catch(function (err) {
                var msg = (err && err.message) ? err.message : 'Lỗi khi hủy yêu cầu.';
                toast('❌ ' + msg, 'error');
                btn.disabled = false;
                btn.textContent = 'Hủy yêu cầu';
            });
        });
    });
})();
</script>
