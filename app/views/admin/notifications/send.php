<?php
/**
 * admin/notifications/send.php — Gửi thông báo
 * Variables: $title, $students[], $_errors, $_old, $_csrfToken
 */
?>

<div class="page-header">
  <div><h1 class="page-title">✉️ Gửi thông báo</h1><p class="page-subtitle">Gửi thông báo đến sinh viên KTX</p></div>
  <a href="<?= getDynamicUrl('/admin/notifications') ?>" class="btn btn-ghost">← Quay lại</a>
</div>

<div class="card" style="max-width:640px">
  <div class="card-header"><div class="card-title">Nội dung thông báo</div></div>
  <div class="card-body">
    <form method="POST" action="<?= getDynamicUrl('/admin/notifications') ?>">
      <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">

      <div class="form-group">
        <label class="form-label" for="target">Đối tượng <span class="req">*</span></label>
        <select id="target" name="target" class="form-control" required>
          <option value="all">📢 Tất cả sinh viên</option>
          <option value="building">🏢 Theo tòa nhà</option>
          <option value="individual">👤 Cá nhân</option>
        </select>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="title">Tiêu đề <span class="req">*</span></label>
          <input type="text" id="title" name="title" class="form-control" placeholder="Tiêu đề thông báo" value="<?= htmlspecialchars($_old['title'] ?? '') ?>" required>
          <?php if (!empty($_errors['title'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['title']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label class="form-label" for="type">Loại <span class="req">*</span></label>
          <select id="type" name="type" class="form-control">
            <option value="general">📋 Chung</option>
            <option value="important">⚠️ Quan trọng</option>
            <option value="urgent">🔴 Khẩn cấp</option>
            <option value="payment">💰 Thanh toán</option>
            <option value="maintenance">🔧 Bảo trì</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="message">Nội dung <span class="req">*</span></label>
        <textarea id="message" name="message" class="form-control" rows="6" placeholder="Nội dung chi tiết thông báo..." required><?= htmlspecialchars($_old['message'] ?? '') ?></textarea>
        <?php if (!empty($_errors['message'] ?? '')): ?><div class="form-error">⚠ <?= htmlspecialchars($_errors['message']) ?></div><?php endif; ?>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
        <a href="<?= getDynamicUrl('/admin/notifications') ?>" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">✉️ Gửi thông báo</button>
      </div>
    </form>
  </div>
</div>
