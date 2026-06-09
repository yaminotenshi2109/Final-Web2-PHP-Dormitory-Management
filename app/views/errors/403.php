<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>403 — Truy cập bị từ chối</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="error-page">
    <div class="error-content">
      <div class="error-code" style="background:linear-gradient(135deg,#ef4444,#f59e0b)">403</div>
      <div class="error-title">Truy cập bị từ chối</div>
      <p class="error-msg">Bạn không có quyền truy cập trang này. Nếu bạn cho rằng đây là lỗi, vui lòng liên hệ quản trị viên.</p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a href="<?= getDynamicUrl('/') ?>" class="btn btn-primary">Trang chủ</a>
        <button onclick="history.back()" class="btn btn-ghost">← Quay lại</button>
      </div>
    </div>
  </div>
</body>
</html>
