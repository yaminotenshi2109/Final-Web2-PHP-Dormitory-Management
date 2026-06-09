<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 — Không tìm thấy</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
  <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/main.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="error-page">
    <div class="error-content">
      <div class="error-code">404</div>
      <div class="error-title">Trang không tồn tại</div>
      <p class="error-msg">Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển. Vui lòng kiểm tra lại đường dẫn.</p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a href="<?= getDynamicUrl('/') ?>" class="btn btn-primary">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          Trang chủ
        </a>
        <button onclick="history.back()" class="btn btn-ghost">← Quay lại</button>
      </div>
    </div>
  </div>
</body>
</html>
