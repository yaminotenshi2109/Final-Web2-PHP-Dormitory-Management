<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hệ thống quản lý ký túc xá thông minh - Đăng nhập">
    <title><?= htmlspecialchars($title ?? 'Đăng nhập') ?> — KTX System</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
    <link rel="stylesheet" href="<?= getDynamicUrl('/assets/css/app.css') ?>">
</head>
<body>
<div class="auth-layout">
    <!-- Animated floating orbs -->
    <div class="auth-orb"></div>

    <!-- Animated grid pattern -->
    <svg class="auth-grid-pattern" viewBox="0 0 100 100" preserveAspectRatio="none" style="position:absolute;inset:0;width:100%;height:100%;opacity:.03;pointer-events:none">
        <defs>
            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.3"/>
            </pattern>
        </defs>
        <rect width="100" height="100" fill="url(#grid)"/>
    </svg>

    <!-- Floating particles -->
    <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none">
        <div style="position:absolute;width:4px;height:4px;background:rgba(99,102,241,.5);border-radius:50%;top:20%;left:30%;animation:particleFloat 6s ease-in-out infinite"></div>
        <div style="position:absolute;width:3px;height:3px;background:rgba(139,92,246,.4);border-radius:50%;top:60%;left:70%;animation:particleFloat 8s ease-in-out infinite 1s"></div>
        <div style="position:absolute;width:5px;height:5px;background:rgba(99,102,241,.3);border-radius:50%;top:40%;left:15%;animation:particleFloat 7s ease-in-out infinite 2s"></div>
        <div style="position:absolute;width:3px;height:3px;background:rgba(168,85,247,.35);border-radius:50%;top:75%;left:45%;animation:particleFloat 9s ease-in-out infinite 0.5s"></div>
        <div style="position:absolute;width:4px;height:4px;background:rgba(99,102,241,.25);border-radius:50%;top:15%;left:80%;animation:particleFloat 10s ease-in-out infinite 3s"></div>
    </div>

    <style>
        @keyframes particleFloat {
            0%, 100% { transform: translateY(0) translateX(0); opacity: .3; }
            25% { transform: translateY(-20px) translateX(10px); opacity: .7; }
            50% { transform: translateY(-40px) translateX(-5px); opacity: .5; }
            75% { transform: translateY(-20px) translateX(15px); opacity: .8; }
        }
    </style>

    <?= $content ?>
</div>

<script src="<?= getDynamicUrl('/assets/js/app.js') ?>"></script>
</body>
</html>
