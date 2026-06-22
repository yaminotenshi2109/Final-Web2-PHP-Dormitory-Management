<?php
/**
 * student/maintenance/index.php — Bảo trì (SV)
 * Variables: $title, $requests[], $_csrfToken
 */
$statusMap = ['open'=>['badge-danger',' Mở'],'in_progress'=>['badge-warning',' Đang xử lý'],'resolved'=>['badge-success',' Đã xử lý'],'closed'=>['badge-neutral',' Đóng'],'rejected'=>['badge-neutral',' Từ chối']];
?>

<div class="page-header">
  <div><h1 class="page-title"> Yêu cầu bảo trì</h1><p class="page-subtitle">Gửi và theo dõi yêu cầu sửa chữa</p></div>
  <div class="page-actions">
    <button class="btn btn-primary" onclick="document.getElementById('newRequestModal').classList.add('open')">+ Tạo yêu cầu</button>
  </div>
</div>

<?php if (!empty($requests)): ?>
  <div style="display:flex;flex-direction:column;gap:12px">
    <?php foreach ($requests as $rq): ?>
      <?php $st = $rq['status'] ?? 'open'; [$sClass, $sLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
      <div class="card">
        <div class="card-body" style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap">
          <div style="width:48px;height:48px;border-radius:var(--radius);background:var(--warning-bg);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0"></div>
          <div style="flex:1;min-width:200px">
            <div style="font-weight:700;font-size:15px"><?= htmlspecialchars($rq['title'] ?? '') ?></div>
            <div style="color:var(--txt-muted);font-size:13px;margin-top:4px"><?= htmlspecialchars($rq['description'] ?? '') ?></div>
            <div style="display:flex;gap:12px;margin-top:8px;font-size:12px;color:var(--txt-muted)">
              <span> <?= !empty($rq['reported_at']) ? date('d/m/Y', strtotime($rq['reported_at'])) : '—' ?></span>
              <?php if (!empty($rq['resolved_at'])): ?><span> <?= date('d/m/Y', strtotime($rq['resolved_at'])) ?></span><?php endif; ?>
            </div>
            <?php if (!empty($rq['admin_notes'])): ?>
              <div style="margin-top:8px;padding:8px 12px;background:var(--page-bg);border-radius:var(--radius-sm);font-size:13px;color:var(--txt-secondary)">
                 <?= htmlspecialchars($rq['admin_notes']) ?>
              </div>
            <?php endif; ?>
          </div>
          <span class="badge <?= $sClass ?>"><?= $sLabel ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="card">
    <div class="empty-state"><div class="empty-icon" aria-hidden="true"></div><div class="empty-title">Chưa có yêu cầu</div><div class="empty-msg">Gửi yêu cầu bảo trì khi phòng cần sửa chữa.</div></div>
  </div>
<?php endif; ?>

<!-- New Request Modal -->
<div class="modal-overlay" id="newRequestModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title"> Tạo yêu cầu bảo trì</div>
      <button class="modal-close" onclick="this.closest('.modal-overlay').classList.remove('open')">×</button>
    </div>
    <form method="POST" action="<?= getDynamicUrl('/student/maintenance') ?>">
      <div class="modal-body">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
        <div class="form-group">
          <label class="form-label" for="title">Tiêu đề <span class="req">*</span></label>
          <input type="text" id="title" name="title" class="form-control" placeholder="VD: Hỏng điều hòa" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="priority">Mức độ</label>
          <select id="priority" name="priority" class="form-control">
            <option value="low">Thấp</option>
            <option value="medium" selected>Trung bình</option>
            <option value="high">Cao</option>
            <option value="urgent">Khẩn cấp</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="description">Mô tả chi tiết <span class="req">*</span></label>
          <textarea id="description" name="description" class="form-control" rows="4" placeholder="Mô tả chi tiết vấn đề cần sửa chữa..." required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-ghost" onclick="this.closest('.modal-overlay').classList.remove('open')">Hủy</button>
        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
      </div>
    </form>
  </div>
</div>
