<?php
/**
 * app/views/admin/dashboard.php
 * ─────────────────────────────────────────────────────────────
 *  Admin dashboard — tổng quan hệ thống KTX
 *  Variables: $title, $stats[], $recent_registrations[], $recent_violations[]
 * ─────────────────────────────────────────────────────────────
 * @var string $title
 * @var array $stats
 * @var array $recent_registrations
 * @var array $recent_violations
 * @var array $occupancyPct
 */

// Helpers for occupancy ratio
$totalRooms    = $stats['total_rooms']            ?? 0;
$occupiedRooms = $stats['occupied_rooms']         ?? 0;
$availableRooms = $stats['available_rooms']        ?? 0;
$occupancyPct  = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
$pendingRegs   = $stats['pending_registrations']  ?? 0;
$openViolations = $stats['open_violations']        ?? 0;

$statIcons = [
    'rooms'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5Z"/></svg>',
    'occupied'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3Z"/><path d="M8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Z"/><path d="M8 13c-2.67 0-8 1.34-8 4v2h10"/><path d="M16 13c-.34 0-.67.02-1 .06 2.02.64 3.5 2.02 3.5 3.94V19h6v-2c0-2.66-5.33-4-8-4Z"/></svg>',
    'available' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11V7a3 3 0 0 1 6 0v4"/><path d="M5 11h14v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-9Z"/></svg>',
    'students'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"/><path d="M4 20v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg>',
    'contracts' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h5"/></svg>',
    'invoices'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2h9l5 5v15a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h5"/></svg>',
    'pending'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><path d="M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2Z"/><path d="M9 14h6"/><path d="M9 18h4"/></svg>',
    'violations'=> '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>',
    'notifications' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>',
];
?>

<!-- ── Page Header ──────────────────────────────────────────── -->
<div class="page-header">
    <div>
        <h1 class="page-title"> Dashboard</h1>
        <p class="page-subtitle">Tổng quan hệ thống Ký túc xá</p>
    </div>
    <div class="page-actions">
        <span style="font-size:12px;color:var(--txt-muted);background:var(--card-bg);border:1px solid var(--border);padding:6px 12px;border-radius:var(--radius-sm);">
             <?= date('d/m/Y H:i') ?>
        </span>
        <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/reports" class="btn btn-outline btn-sm"> Báo cáo</a>
        <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations" class="btn btn-primary btn-sm"> Đăng ký mới</a>
    </div>
</div>

<!-- ── Flash messages ───────────────────────────────────────── -->
<?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert alert-success mb-16">
        <div class="alert-content">
            <div class="alert-msg"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
        </div>
        <button class="alert-close" onclick="this.closest('.alert').remove()">×</button>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<!-- ── Stat Grid ────────────────────────────────────────────── -->
<div class="stat-grid mb-24">

    <!-- Tổng số phòng -->
    <div class="stat-card" style="--stat-color:#6366f1">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['rooms'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $totalRooms ?>"><?= number_format($totalRooms) ?></div>
                <div class="stat-label">Tổng số phòng</div>
            </div>
        </div>
    </div>

    <!-- Phòng đã có người -->
    <div class="stat-card" style="--stat-color:#3b82f6">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['occupied'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $occupiedRooms ?>"><?= number_format($occupiedRooms) ?></div>
                <div class="stat-label">Phòng đã có người</div>
            </div>
        </div>
        <div class="stat-card__extra">
            <div class="progress">
                <div class="progress-bar" style="width:<?= $occupancyPct ?>%;background:#3b82f6"></div>
            </div>
            <div class="stat-card__hint"><?= $occupancyPct ?>% lấp đầy</div>
        </div>
    </div>

    <!-- Phòng còn trống -->
    <div class="stat-card" style="--stat-color:#10b981">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['available'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $availableRooms ?>"><?= number_format($availableRooms) ?></div>
                <div class="stat-label">Phòng còn trống</div>
            </div>
        </div>
    </div>

    <!-- Tổng sinh viên -->
    <div class="stat-card" style="--stat-color:#8b5cf6">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['students'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $stats['total_students'] ?? 0 ?>"><?= number_format($stats['total_students'] ?? 0) ?></div>
                <div class="stat-label">Sinh viên</div>
            </div>
        </div>
    </div>

    <!-- Hợp đồng -->
    <div class="stat-card" style="--stat-color:#06b6d4">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['contracts'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $stats['total_contracts'] ?? 0 ?>"><?= number_format($stats['total_contracts'] ?? 0) ?></div>
                <div class="stat-label">Hợp đồng active</div>
            </div>
        </div>
    </div>

    <!-- Hóa đơn chưa thanh toán -->
    <div class="stat-card" style="--stat-color:#f59e0b">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['invoices'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $stats['unpaid_invoices'] ?? 0 ?>"><?= number_format($stats['unpaid_invoices'] ?? 0) ?></div>
                <div class="stat-label">Hóa đơn chưa trả</div>
            </div>
        </div>
    </div>

    <!-- Đơn đăng ký chờ duyệt -->
    <div class="stat-card" style="--stat-color:#ec4899">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['pending'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $pendingRegs ?>"><?= number_format($pendingRegs) ?></div>
                <div class="stat-label">Đơn chờ duyệt</div>
            </div>
        </div>
        <?php if ($pendingRegs > 0): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations?status=pending" class="stat-card__link">
                Xem ngay →
            </a>
        <?php endif; ?>
    </div>

    <!-- Vi phạm đang mở -->
    <div class="stat-card" style="--stat-color:#ef4444">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['violations'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $openViolations ?>"><?= number_format($openViolations) ?></div>
                <div class="stat-label">Vi phạm chưa xử lý</div>
            </div>
        </div>
        <?php if ($openViolations > 0): ?>
            <a href="<?= getDynamicUrl('/admin/violations?status=active') ?>" class="stat-card__link stat-card__link--danger">
                Xem ngay →
            </a>
        <?php endif; ?>
    </div>

    <!-- Thông báo -->
    <div class="stat-card" style="--stat-color:#64748b">
        <div class="stat-card__top">
            <div class="stat-icon"><?= $statIcons['notifications'] ?></div>
            <div>
                <div class="stat-value" data-count="<?= $stats['total_notifications'] ?? 0 ?>"><?= number_format($stats['total_notifications'] ?? 0) ?></div>
                <div class="stat-label">Thông báo</div>
            </div>
        </div>
        <a href="<?= getDynamicUrl('/admin/notifications') ?>" class="stat-card__link">
            Quản lý →
        </a>
    </div>

</div><!-- /.stat-grid -->

<!-- ── Occupancy Summary Bar ────────────────────────────────── -->
<div class="card mb-24">
    <div class="card-body" style="padding:16px 20px">
        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
            <div style="font-size:13px;font-weight:600;color:var(--txt-secondary);min-width:140px">
                 Tỷ lệ lấp đầy tổng thể
            </div>
            <div style="flex:1;min-width:200px">
                <div class="progress">
                    <div class="progress-bar <?= $occupancyPct >= 90 ? 'danger' : ($occupancyPct >= 70 ? 'warning' : 'success') ?>"
                         style="width:<?= $occupancyPct ?>%"></div>
                </div>
            </div>
            <div style="font-size:18px;font-weight:800;color:var(--txt-primary);min-width:55px;text-align:right">
                <?= $occupancyPct ?>%
            </div>
            <div style="font-size:12px;color:var(--txt-muted)">
                <?= number_format($occupiedRooms) ?> / <?= number_format($totalRooms) ?> phòng
            </div>
        </div>
    </div>
</div>

<!-- ── Two-column: Recent Registrations + Recent Violations ─── -->
<div class="grid-2">

    <!-- Đơn đăng ký gần đây -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title"> Đơn đăng ký gần đây</div>
                <div class="card-subtitle">5 đơn mới nhất trong hệ thống</div>
            </div>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations" class="btn btn-ghost btn-sm">Xem tất cả →</a>
        </div>

        <?php if (!empty($recent_registrations)): ?>
            <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
                <table>
                    <thead>
                        <tr>
                            <th>Sinh viên</th>
                            <th>Phòng yêu cầu</th>
                            <th>Ngày nộp</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_registrations as $reg): ?>
                            <?php
                                $statusMap = [
                                    'pending'  => ['badge-warning', '⏳ Chờ duyệt'],
                                    'approved' => ['badge-success', ' Đã duyệt'],
                                    'rejected' => ['badge-danger',  ' Từ chối'],
                                ];
                                $status    = $reg['status'] ?? 'pending';
                                [$badgeClass, $statusLabel] = $statusMap[$status] ?? ['badge-neutral', $status];
                            ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="avatar avatar-sm">
                                            <?= mb_strtoupper(mb_substr($reg['student_name'] ?? 'S', 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;font-size:13px">
                                                <?= htmlspecialchars($reg['student_name'] ?? 'N/A') ?>
                                            </div>
                                            <div class="sub"><?= htmlspecialchars($reg['student_code'] ?? '') ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight:600"><?= htmlspecialchars($reg['room_number'] ?? '—') ?></span>
                                    <?php if (!empty($reg['building_name'])): ?>
                                        <div class="sub"><?= htmlspecialchars($reg['building_name']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-size:12px;color:var(--txt-muted)">
                                        <?= !empty($reg['created_at']) ? date('d/m/Y', strtotime($reg['created_at'])) : '—' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state" style="padding:40px 24px">
                <div class="empty-icon" aria-hidden="true"></div>
                <div class="empty-title">Chưa có đơn đăng ký</div>
                <div class="empty-msg">Các đơn đăng ký mới sẽ hiển thị tại đây.</div>
            </div>
        <?php endif; ?>

        <?php if (!empty($recent_registrations) && $pendingRegs > 0): ?>
            <div class="card-footer" style="text-align:center">
                <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations?status=pending"
                   class="btn btn-outline btn-sm">
                    ⏳ Xem <?= $pendingRegs ?> đơn chờ duyệt
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Vi phạm gần đây -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title"> Vi phạm gần đây</div>
                <div class="card-subtitle">Các trường hợp vi phạm mới nhất</div>
            </div>
            <a href="<?= getDynamicUrl('/admin/violations') ?>" class="btn btn-ghost btn-sm">Xem tất cả →</a>
        </div>

        <?php if (!empty($recent_violations)): ?>
            <div class="notif-list" style="padding:8px 0">
                <?php foreach ($recent_violations as $v): ?>
                    <?php
                        $vStatus = $v['status'] ?? 'open';
                        $isOpen  = $vStatus === 'open';
                    ?>
                    <div class="notif-item <?= $isOpen ? 'unread' : '' ?>">
                        <div class="notif-dot"></div>
                        <div class="notif-body">
                            <div class="notif-title">
                                <?= htmlspecialchars($v['student_name'] ?? 'Sinh viên') ?>
                                <span style="font-weight:400;color:var(--txt-muted)">—</span>
                                <?= htmlspecialchars($v['violation_type'] ?? 'Vi phạm nội quy') ?>
                            </div>
                            <div class="notif-msg">
                                 Phòng <?= htmlspecialchars($v['room_number'] ?? '—') ?>
                                <?php if (!empty($v['description'])): ?>
                                    · <?= htmlspecialchars(mb_strimwidth($v['description'], 0, 60, '...')) ?>
                                <?php endif; ?>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;margin-top:5px">
                                <?php
                                    $vBadge = match($vStatus) {
                                        'active'    => ['badge-danger',  ' Chưa xử lý'],
                                        'resolved'  => ['badge-success', ' Đã xử lý'],
                                        'pending'   => ['badge-warning', '⏳ Đang xem xét'],
                                        'appealed'  => ['badge-warning', ' Đang khiếu nại'],
                                        'dismissed' => ['badge-neutral', ' Đã hủy'],
                                        default     => ['badge-neutral', $vStatus],
                                    };
                                ?>
                                <span class="badge <?= $vBadge[0] ?>"><?= $vBadge[1] ?></span>
                                <?php if (!empty($v['fine_amount']) && $v['fine_amount'] > 0): ?>
                                    <span style="font-size:11px;color:var(--danger);font-weight:600">
                                         <?= number_format($v['fine_amount']) ?>đ
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="notif-time">
                            <?= !empty($v['created_at']) ? date('d/m', strtotime($v['created_at'])) : '' ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state" style="padding:40px 24px">
                <div class="empty-icon" aria-hidden="true"></div>
                <div class="empty-title">Không có vi phạm</div>
                <div class="empty-msg">Tuyệt vời! Hiện không có vi phạm nào cần xử lý.</div>
            </div>
        <?php endif; ?>

        <?php if (!empty($recent_violations) && $openViolations > 0): ?>
            <div class="card-footer" style="text-align:center">
                <a href="<?= getDynamicUrl('/admin/violations?status=active') ?>"
                   class="btn btn-danger btn-sm">
                     Xử lý <?= $openViolations ?> vi phạm
                </a>
            </div>
        <?php endif; ?>
    </div>

</div><!-- /.grid-2 -->

<!-- ── Quick Links ───────────────────────────────────────────── -->
<div class="card mt-24">
    <div class="card-header">
        <div class="card-title"> Truy cập nhanh</div>
    </div>
    <div class="card-body">
        <div style="display:flex;flex-wrap:wrap;gap:10px">
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/rooms" class="btn btn-outline"> Quản lý phòng</a>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/students" class="btn btn-outline"> Quản lý sinh viên</a>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/contracts" class="btn btn-outline"> Hợp đồng</a>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices" class="btn btn-outline"> Hóa đơn</a>
            <a href="<?= getDynamicUrl('/admin/violations') ?>" class="btn btn-outline"> Vi phạm</a>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/users" class="btn btn-outline"> Tài khoản</a>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/services" class="btn btn-outline"> Dịch vụ</a>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/reports" class="btn btn-primary"> Báo cáo tổng hợp</a>
        </div>
    </div>
</div>

<script>
// Animate stat counters on load
document.addEventListener('DOMContentLoaded', function () {
    const counters = document.querySelectorAll('.stat-value[data-count]');
    counters.forEach(function (el) {
        const target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target) || target === 0) return;
        let start = 0;
        const duration = 900;
        const step = Math.ceil(target / (duration / 16));
        const timer = setInterval(function () {
            start += step;
            if (start >= target) {
                el.textContent = target.toLocaleString('vi-VN');
                clearInterval(timer);
            } else {
                el.textContent = start.toLocaleString('vi-VN');
            }
        }, 16);
    });
});
</script>
