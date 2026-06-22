<?php
// app/views/student/registrations/show.php
// Variables: $title, $registration, $_csrfToken, $_errors, $_flash

$reg = $registration ?? [];
$status = $reg['status'] ?? 'unknown';

function regStatusBadge(string $status): string {
    return match(strtolower($status)) {
        'pending'   => '<span class="badge badge-warning">⏳ Chờ duyệt</span>',
        'approved'  => '<span class="badge badge-success"> Đã duyệt</span>',
        'assigned'  => '<span class="badge badge-info"> Đã phân phòng</span>',
        'rejected'  => '<span class="badge badge-danger"> Từ chối</span>',
        'cancelled' => '<span class="badge badge-neutral"> Đã huỷ</span>',
        default     => '<span class="badge badge-neutral">' . htmlspecialchars($status) . '</span>',
    };
}

function semesterLabel(string $sem): string {
    return match($sem) {
        '1' => 'Học kỳ 1',
        '2' => 'Học kỳ 2',
        '3' => 'Học kỳ hè',
        default => 'Học kỳ ' . htmlspecialchars($sem),
    };
}

?>

<div class="page-header">
    <div>
        <h1 class="page-title"> Chi tiết đơn đăng ký</h1>
        <p class="page-subtitle">Xem trạng thái và thông tin đơn đăng ký phòng của bạn</p>
    </div>
    <div class="page-actions">
        <a href="<?= getDynamicUrl('/student/registrations') ?>" class="btn btn-ghost">← Quay lại danh sách</a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="display:grid;gap:18px;">
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:space-between;align-items:flex-start;">
            <div>
                <h2 style="margin:0;font-size:20px;"><?= semesterLabel((string)($reg['semester'] ?? '')) ?> — <?= htmlspecialchars($reg['academic_year'] ?? '') ?></h2>
                <p style="margin:6px 0 0 0;color:#6b7280;">Mã đơn: #<?= htmlspecialchars($reg['id'] ?? '') ?></p>
            </div>
            <div><?= regStatusBadge($status) ?></div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;">
                <div style="font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Tòa ưu tiên</div>
                <div style="font-size:15px;color:#1f2937;"><?= htmlspecialchars($reg['preferred_building_name'] ?? 'Không chọn') ?></div>
            </div>

            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;">
                <div style="font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Phòng được phân</div>
                <div style="font-size:15px;color:#1f2937;">
                    <?php if (!empty($reg['room_number'])): ?>
                        Phòng <?= htmlspecialchars($reg['room_number']) ?>
                        <?= !empty($reg['floor']) ? '— Tầng ' . htmlspecialchars($reg['floor']) : '' ?>
                    <?php else: ?>
                        <span style="color:#94a3b8;">Chưa phân phòng</span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($reg['assigned_building_name'])): ?>
                    <div style="margin-top:6px;font-size:13px;color:#475569;">Tòa: <?= htmlspecialchars($reg['assigned_building_name']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;">
                <div style="font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Ngày nộp đơn</div>
                <div style="font-size:15px;color:#1f2937;"><?= htmlspecialchars($reg['registered_at'] ?? '') ?></div>
            </div>
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;">
                <div style="font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Ghi chú</div>
                <div style="font-size:15px;color:#1f2937;"><?= nl2br(htmlspecialchars($reg['notes'] ?? 'Không có')) ?></div>
            </div>
        </div>

        <div style="background:#eef2ff;border:1px solid #c7d2fe;border-radius:12px;padding:16px;">
            <strong style="display:block;margin-bottom:8px;color:#3730a3;">Trạng thái đơn</strong>
            <p style="margin:0;color:#334155;font-size:14px;line-height:1.6;">
                <?php switch (strtolower($status)): case 'pending': ?>
                    Đơn của bạn đang chờ admin duyệt. Vui lòng chờ thông báo tiếp theo.
                    <?php break; ?>
                <?php case 'approved': ?>
                    Đơn đã được duyệt. BQL sẽ tiến hành phân phòng cho bạn trong thời gian sớm nhất.
                    <?php break; ?>
                <?php case 'assigned': ?>
                    Đơn đã phân phòng. Kiểm tra thông tin phòng được phân ở trang danh sách hoặc liên hệ BQL nếu cần.
                    <?php break; ?>
                <?php case 'rejected': ?>
                    Đơn đã bị từ chối. Bạn có thể tạo đơn mới nếu cần.
                    <?php break; ?>
                <?php case 'cancelled': ?>
                    Đơn đã bị hủy. Nếu bạn vẫn cần phòng, hãy tạo đơn mới.
                    <?php break; ?>
                <?php default: ?>
                    Trạng thái hiện tại của đơn chưa rõ. Vui lòng liên hệ BQL để biết thêm chi tiết.
                <?php endswitch; ?>
            </p>
        </div>
    </div>
</div>
