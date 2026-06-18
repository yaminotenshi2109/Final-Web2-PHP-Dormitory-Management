<?php
// Views: student/dashboard.php
// Variables: $title, $student, $contract, $unpaid_invoices, $active_violations, $recent_notifications
$studentName   = $student['full_name']    ?? 'Sinh viên';
$studentCode   = $student['student_code'] ?? '';
$faculty       = $student['faculty']      ?? '';
$priorityLevel = $student['priority_level'] ?? '';

// Generate initials from name
$nameParts = explode(' ', trim($studentName));
$initials  = '';
if (count($nameParts) >= 2) {
    $initials = mb_strtoupper(mb_substr($nameParts[0], 0, 1) . mb_substr(end($nameParts), 0, 1));
} else {
    $initials = mb_strtoupper(mb_substr($studentName, 0, 2));
}

$unpaidInvoices   = (int)($unpaid_invoices ?? 0);
$activeViolations = (int)($active_violations ?? 0);
$recentNotifs     = $recent_notifications ?? [];

$hasContract = !empty($contract);
?>

<!-- Welcome Banner -->
<div class="card mb-24" style="background:var(--brand-gradient);border:none;color:#fff;padding:32px;position:relative;overflow:hidden">
    <!-- Decorative circles -->
    <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.08)"></div>
    <div style="position:absolute;bottom:-40px;right:60px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05)"></div>

    <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;position:relative;z-index:1">
        <div class="avatar avatar-xl" style="flex-shrink:0;width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;letter-spacing:1px;border:2px solid rgba(255,255,255,0.3);backdrop-filter:blur(4px)">
            <?= htmlspecialchars($initials) ?>
        </div>
        <div style="flex:1;min-width:200px">
            <h2 style="font-size:24px;font-weight:800;margin:0 0 6px 0;line-height:1.2;letter-spacing:-.5px">
                Xin chào, <?= htmlspecialchars($studentName) ?>! 👋
            </h2>
            <p style="opacity:.75;margin:0;font-size:14px;display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                <span>Mã SV: <strong><?= htmlspecialchars($studentCode) ?></strong></span>
                <?php if ($faculty): ?> <span>•</span> <span><?= htmlspecialchars($faculty) ?></span><?php endif; ?>
                <?php if ($priorityLevel): ?> <span>•</span> <span>Ưu tiên: <strong><?= htmlspecialchars($priorityLevel) ?></strong></span><?php endif; ?>
            </p>
        </div>
        <div style="flex-shrink:0">
            <a href="<?= getDynamicUrl('/student/profile') ?>" class="btn" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);font-size:13px;backdrop-filter:blur(4px)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Hồ sơ của tôi
            </a>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="stat-grid mb-24">
    <!-- Hoá đơn chưa thanh toán -->
    <div class="stat-card" style="--stat-color:<?= $unpaidInvoices > 0 ? '#ef4444' : '#22c55e' ?>;--stat-icon-bg:<?= $unpaidInvoices > 0 ? '#fef2f2' : '#f0fdf4' ?>;">
        <div class="stat-icon"><?= $unpaidInvoices > 0 ? '💳' : '✅' ?></div>
        <div class="stat-body">
            <div class="stat-value" data-count="<?= $unpaidInvoices ?>"><?= $unpaidInvoices ?></div>
            <div class="stat-label">Hóa đơn chưa thanh toán</div>
        </div>
        <a href="<?= getDynamicUrl('/student/invoices') ?>" style="font-size:12px;color:var(--stat-color);text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-top:8px;font-weight:600">
            Xem hóa đơn
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>

    <!-- Vi phạm đang hiệu lực -->
    <div class="stat-card" style="--stat-color:<?= $activeViolations > 0 ? '#f59e0b' : '#22c55e' ?>;--stat-icon-bg:<?= $activeViolations > 0 ? '#fffbeb' : '#f0fdf4' ?>;">
        <div class="stat-icon"><?= $activeViolations > 0 ? '⚠️' : '🛡️' ?></div>
        <div class="stat-body">
            <div class="stat-value" data-count="<?= $activeViolations ?>"><?= $activeViolations ?></div>
            <div class="stat-label">Vi phạm đang hiệu lực</div>
        </div>
        <a href="<?= getDynamicUrl('/student/violations') ?>" style="font-size:12px;color:var(--stat-color);text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-top:8px;font-weight:600">
            Xem vi phạm
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>

    <!-- Trạng thái phòng -->
    <div class="stat-card" style="--stat-color:<?= $hasContract ? '#4f46e5' : '#6b7280' ?>;--stat-icon-bg:<?= $hasContract ? '#eef2ff' : '#f9fafb' ?>;">
        <div class="stat-icon"><?= $hasContract ? '🏠' : '🔍' ?></div>
        <div class="stat-body">
            <div class="stat-value" style="font-size:18px;">
                <?= $hasContract ? htmlspecialchars($contract['room_number'] ?? '--') : 'Chưa có' ?>
            </div>
            <div class="stat-label">
                <?php if ($hasContract): ?>
                    <?= htmlspecialchars($contract['building_name'] ?? '') ?>
                <?php else: ?>
                    Chưa đăng ký phòng
                <?php endif; ?>
            </div>
        </div>
        <?php if ($hasContract): ?>
            <span style="font-size:12px;color:var(--stat-color);display:block;margin-top:8px;font-weight:600">
                <?php
                $cStatus = $contract['status'] ?? '';
                $statusLabel = match($cStatus) {
                    'active'    => '🟢 Đang ở',
                    'expired'   => '🔴 Đã hết hạn',
                    'cancelled' => '⚫ Đã huỷ',
                    default     => $cStatus
                };
                echo htmlspecialchars($statusLabel);
                ?>
            </span>
        <?php else: ?>
            <a href="<?= getDynamicUrl('/student/registrations/create') ?>" style="font-size:12px;color:var(--stat-color);text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-top:8px;font-weight:600">
                Đăng ký ngay
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Main Content: 2 columns -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;" class="grid-2-dashboard">

    <!-- Left: Room / Contract Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🏠 Thông tin phòng ở</h3>
        </div>
        <div class="card-body">
            <?php if ($hasContract): ?>
                <?php
                $cStatus = $contract['status'] ?? '';
                $statusBadge = match($cStatus) {
                    'active'    => '<span class="badge badge-success">Đang ở</span>',
                    'expired'   => '<span class="badge badge-danger">Hết hạn</span>',
                    'cancelled' => '<span class="badge badge-neutral">Đã huỷ</span>',
                    default     => '<span class="badge badge-info">' . htmlspecialchars($cStatus) . '</span>',
                };
                ?>
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span class="gradient-text" style="font-size:28px;font-weight:900;letter-spacing:-.5px">
                            Phòng <?= htmlspecialchars($contract['room_number'] ?? '--') ?>
                        </span>
                        <?= $statusBadge ?>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div style="background:var(--page-bg);border-radius:var(--radius);padding:14px;border:1px solid var(--border);transition:all .25s">
                            <div style="font-size:11px;color:var(--txt-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Tòa nhà</div>
                            <div style="font-weight:700;color:var(--txt-primary)"><?= htmlspecialchars($contract['building_name'] ?? '--') ?></div>
                        </div>
                        <div style="background:var(--page-bg);border-radius:var(--radius);padding:14px;border:1px solid var(--border);transition:all .25s">
                            <div style="font-size:11px;color:var(--txt-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Tiền phòng/tháng</div>
                            <div style="font-weight:700;color:var(--txt-primary)">
                                <?= number_format((float)($contract['monthly_fee'] ?? 0), 0, ',', '.') ?> ₫
                            </div>
                        </div>
                        <div style="background:var(--page-bg);border-radius:var(--radius);padding:14px;border:1px solid var(--border);transition:all .25s">
                            <div style="font-size:11px;color:var(--txt-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Ngày bắt đầu</div>
                            <div style="font-weight:700;color:var(--txt-primary)">
                                <?= htmlspecialchars($contract['start_date'] ?? '--') ?>
                            </div>
                        </div>
                        <div style="background:var(--page-bg);border-radius:var(--radius);padding:14px;border:1px solid var(--border);transition:all .25s">
                            <div style="font-size:11px;color:var(--txt-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Ngày kết thúc</div>
                            <div style="font-weight:700;color:var(--txt-primary)">
                                <?= htmlspecialchars($contract['end_date'] ?? '--') ?>
                            </div>
                        </div>
                    </div>

                    <div style="border-top:1px solid var(--border);padding-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
                        <a href="<?= getDynamicUrl('/student/invoices') ?>" class="btn btn-primary btn-sm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            Xem hóa đơn
                        </a>
                        <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-outline btn-sm">
                            📋 Đăng ký của tôi
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state" style="padding:40px 20px;">
                    <div class="empty-icon">🏠</div>
                    <div class="empty-title">Chưa có phòng ở</div>
                    <div class="empty-msg">Bạn chưa đăng ký phòng ký túc xá hoặc đơn chưa được phê duyệt.</div>
                    <a href="<?= getDynamicUrl('/student/registrations/create') ?>" class="btn btn-primary" style="margin-top:16px">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Đăng ký phòng ngay
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right: Recent Notifications -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🔔 Thông báo gần đây</h3>
            <a href="<?= getDynamicUrl('/student/notifications') ?>" class="btn btn-ghost btn-sm">Xem tất cả</a>
        </div>
        <div class="card-body" style="padding:0;">
            <?php if (empty($recentNotifs)): ?>
                <div class="empty-state" style="padding:40px 20px;">
                    <div class="empty-icon">📭</div>
                    <p style="color:var(--txt-muted);font-size:14px;margin:0;">Chưa có thông báo nào.</p>
                </div>
            <?php else: ?>
                <div class="notif-list" style="max-height:380px;overflow-y:auto;">
                    <?php foreach ($recentNotifs as $notif): ?>
                        <?php
                        $isRead  = !empty($notif['is_read']);
                        $nType   = $notif['type'] ?? 'general';
                        $typeIcon = match($nType) {
                            'invoice'   => '💳',
                            'violation' => '⚠️',
                            'contract'  => '📄',
                            'system'    => '⚙️',
                            default     => '🔔',
                        };
                        ?>
                        <div class="notif-item <?= $isRead ? '' : 'unread' ?>"
                             style="padding:14px 16px;border-bottom:1px solid var(--border);cursor:pointer"
                             onclick="window.location='<?= getDynamicUrl('/student/notifications') ?>'">
                            <span style="font-size:20px;flex-shrink:0;margin-top:1px"><?= $typeIcon ?></span>
                            <div style="flex:1;min-width:0">
                                <div style="font-weight:<?= $isRead ? '500' : '700' ?>;color:var(--txt-primary);font-size:13.5px;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                    <?= htmlspecialchars($notif['title'] ?? '') ?>
                                    <?php if (!$isRead): ?>
                                        <span style="display:inline-block;width:7px;height:7px;background:var(--brand);border-radius:50%;margin-left:5px;vertical-align:middle"></span>
                                    <?php endif; ?>
                                </div>
                                <div style="color:var(--txt-muted);font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                    <?= htmlspecialchars(mb_strimwidth($notif['message'] ?? '', 0, 80, '...')) ?>
                                </div>
                                <div style="color:var(--txt-muted);font-size:11px;margin-top:4px;display:flex;align-items:center;gap:4px">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <?= htmlspecialchars($notif['sent_at'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($recentNotifs)): ?>
            <div class="card-footer" style="text-align:center;">
                <a href="<?= getDynamicUrl('/student/notifications') ?>" class="btn btn-outline btn-sm" style="width:100%;">
                    Xem tất cả thông báo
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions (full-width bottom) -->
<div class="card mt-24">
    <div class="card-header">
        <h3 class="card-title">⚡ Thao tác nhanh</h3>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px">
            <a href="<?= getDynamicUrl('/student/invoices') ?>" class="btn btn-outline" style="flex-direction:column;gap:8px;padding:20px 12px;height:auto;text-align:center;border-radius:var(--radius)">
                <span style="font-size:28px">💳</span>
                <span style="font-size:13px">Hóa đơn</span>
            </a>
            <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-outline" style="flex-direction:column;gap:8px;padding:20px 12px;height:auto;text-align:center;border-radius:var(--radius)">
                <span style="font-size:28px">📋</span>
                <span style="font-size:13px">Đăng ký phòng</span>
            </a>
            <a href="<?= getDynamicUrl('/student/violations') ?>" class="btn btn-outline" style="flex-direction:column;gap:8px;padding:20px 12px;height:auto;text-align:center;border-radius:var(--radius)">
                <span style="font-size:28px">📝</span>
                <span style="font-size:13px">Vi phạm</span>
            </a>
            <a href="<?= getDynamicUrl('/student/notifications') ?>" class="btn btn-outline" style="flex-direction:column;gap:8px;padding:20px 12px;height:auto;text-align:center;border-radius:var(--radius)">
                <span style="font-size:28px">🔔</span>
                <span style="font-size:13px">Thông báo</span>
            </a>
            <a href="<?= getDynamicUrl('/student/profile') ?>" class="btn btn-outline" style="flex-direction:column;gap:8px;padding:20px 12px;height:auto;text-align:center;border-radius:var(--radius)">
                <span style="font-size:28px">👤</span>
                <span style="font-size:13px">Hồ sơ</span>
            </a>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .grid-2-dashboard {
        grid-template-columns: 1fr !important;
    }
}
</style>
