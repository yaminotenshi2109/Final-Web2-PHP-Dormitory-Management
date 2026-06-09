<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>500 — Lỗi máy chủ</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="error-page">
    <div class="error-content">
      <div class="error-code" style="background:linear-gradient(135deg,#ef4444,#dc2626)">500</div>
      <div class="error-title">Lỗi máy chủ</div>
      <p class="error-msg">Đã xảy ra lỗi không mong muốn. Hệ thống đang gặp sự cố. Vui lòng thử lại sau hoặc liên hệ quản trị viên.</p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a href="<?= getDynamicUrl('/') ?>" class="btn btn-primary">Trang chủ</a>
        <button onclick="location.reload()" class="btn btn-ghost">🔄 Thử lại</button>
      </div>
    </div>
  </div>
</body>
</html>
