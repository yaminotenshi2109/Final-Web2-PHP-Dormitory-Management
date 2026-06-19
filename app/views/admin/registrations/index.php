<?php
/**
 * admin/registrations/index.php — Đăng ký phòng
 * Variables: $title, $registrations[], $stats, $filters
 */
$statusMap = ['pending'=>['badge-warning','⏳ Chờ duyệt'],'approved'=>['badge-success','✅ Đã duyệt'],'rejected'=>['badge-danger','❌ Từ chối'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
?>

<div class="page-header">
  <div>
    <h1 class="page-title">📋 Đăng ký phòng</h1>
    <p class="page-subtitle">Quản lý đơn đăng ký phòng của sinh viên</p>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">📋</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng đơn</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⏳</div><div><div class="stat-value"><?= number_format($stats['pending'] ?? 0) ?></div><div class="stat-label">Chờ duyệt</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($stats['approved'] ?? 0) ?></div><div class="stat-label">Đã duyệt</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">❌</div><div><div class="stat-value"><?= number_format($stats['rejected'] ?? 0) ?></div><div class="stat-label">Từ chối</div></div></div>
</div>

<!-- Registrations Table -->
<div class="card">
    <div class="card-body" style="padding:0">
        <?php if (!empty($registrations)): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Sinh viên</th>
                            <th style="text-align:center">Giới tính</th>
                            <th>Tòa ưu tiên</th>
                            <th style="text-align:center">Học kỳ</th>
                            <th>Phòng được gán</th>
                            <th style="text-align:center">Trạng thái</th>
                            <th>Ngày đăng ký</th>
                            <th style="text-align:center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $page    = $pagination['current_page'] ?? 1;
                        $perPage = $pagination['per_page'] ?? 20;
                        $offset  = ($page - 1) * $perPage;

                        foreach ($registrations as $i => $reg):
                            $statusMap = [
                                'pending'   => ['label' => 'Chờ duyệt', 'class' => 'badge-warning'],
                                'approved'  => ['label' => 'Đã duyệt',  'class' => 'badge-success'],
                                'rejected'  => ['label' => 'Từ chối',   'class' => 'badge-danger'],
                                'cancelled' => ['label' => 'Đã hủy',    'class' => 'badge-neutral'],
                            ];
                            $st = $statusMap[$reg['status'] ?? ''] ?? ['label' => $reg['status'] ?? '—', 'class' => 'badge-neutral'];

                            $genderLabel = match($reg['gender'] ?? '') {
                                'male'   => '♂ Nam',
                                'female' => '♀ Nữ',
                                default  => '—',
                            };

                            $priorityMap = [
                                0 => 'Thường',
                                1 => 'Chính sách ⭐',
                                2 => 'Ưu tiên cao ⭐⭐',
                            ];
                            $priorityLabel = $priorityMap[(int)($reg['priority_level'] ?? 0)] ?? 'Thường';
                        ?>
                        <tr>
                            <td><?= $offset + $i + 1 ?></td>
                            <td>
                                <div style="font-weight:600"><?= htmlspecialchars($reg['full_name'] ?? '—') ?></div>
                                <div style="font-size:0.78rem;color:var(--text-muted)"><?= $priorityLabel ?></div>
                            </td>
                            <td style="text-align:center"><?= $genderLabel ?></td>
                            <td><?= htmlspecialchars($reg['building_name'] ?? '—') ?></td>
                            <td style="text-align:center">
                                <?php if (!empty($reg['semester'])): ?>
                                    HK<?= htmlspecialchars($reg['semester']) ?>
                                    <?= !empty($reg['academic_year']) ? ' - ' . htmlspecialchars($reg['academic_year']) : '' ?>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($reg['room_number'])): ?>
                                    <span style="font-weight:600"><?= htmlspecialchars($reg['room_number']) ?></span>
                                <?php else: ?>
                                    <span style="color:var(--text-muted);font-style:italic">Chưa gán</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center">
                                <span class="badge <?= $st['class'] ?>"><?= $st['label'] ?></span>
                            </td>
                            <td>
                                <?php
                                $dt = $reg['created_at'] ?? '';
                                echo $dt ? htmlspecialchars(date('d/m/Y', strtotime($dt))) : '—';
                                ?>
                            </td>
                            <td style="text-align:center">
                                <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
                                    <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations/<?= (int)$reg['id'] ?>"
                                       class="btn btn-ghost btn-sm">👁 Xem</a>

                                    <?php if (($reg['status'] ?? '') === 'pending'): ?>
                                        <!-- Approve -->
                                        <form method="POST"
                                              action="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations/<?= (int)$reg['id'] ?>/approve"
                                              onsubmit="return confirm('Xác nhận duyệt đăng ký này?')"
                                              style="display:inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">✅ Duyệt</button>
                                        </form>

                                        <!-- Reject (open modal) -->
                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="openRejectModal(<?= (int)$reg['id'] ?>)">
                                            ❌ Từ chối
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">Không có đăng ký nào</div>
                <div class="empty-state-desc">Không tìm thấy hồ sơ đăng ký phù hợp với bộ lọc hiện tại.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<?php if (!empty($pagination) && ($pagination['total_pages'] ?? 1) > 1): ?>
    <div class="pagination">
        <?php
        $cur   = (int)($pagination['current_page'] ?? 1);
        $total = (int)($pagination['total_pages'] ?? 1);
        $qs    = http_build_query(array_filter([
            'status'   => $filterStatus,
            'semester' => $filterSemester,
        ]));
        ?>
        <?php if ($cur > 1): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations?page=<?= $cur - 1 ?>&<?= $qs ?>" class="page-link">‹ Trước</a>
        <?php endif; ?>
        <?php for ($p = max(1, $cur - 2); $p <= min($total, $cur + 2); $p++): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations?page=<?= $p ?>&<?= $qs ?>"
               class="page-link <?= $p === $cur ? 'active' : '' ?>"><?= $p ?></a>
        <?php endfor; ?>
        <?php if ($cur < $total): ?>
            <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/registrations?page=<?= $cur + 1 ?>&<?= $qs ?>" class="page-link">Sau ›</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Modal: Từ chối đăng ký -->
<div class="modal-overlay" id="modal-reject-registration" style="display:none" onclick="closeRejectModal()">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
                <h3 class="card-title">❌ Từ chối đăng ký</h3>
                <button class="btn btn-ghost btn-sm" onclick="closeRejectModal()">✕</button>
            </div>
            <div class="card-body">
                <form id="form-reject-registration" method="POST" action="">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                    <div class="form-group">
                        <label class="form-label" for="reject-reason">
                            Lý do từ chối <span style="color:#ef4444">*</span>
                        </label>
                        <textarea
                            id="reject-reason"
                            name="reason"
                            class="form-control"
                            rows="4"
                            placeholder="Nhập lý do từ chối hồ sơ đăng ký này..."
                            required
                        ></textarea>
                        <div class="form-error" id="reject-reason-error" style="display:none">
                            Vui lòng nhập lý do từ chối.
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer" style="display:flex;justify-content:flex-end;gap:10px">
                <button class="btn btn-outline" onclick="closeRejectModal()">Hủy</button>
                <button class="btn btn-danger" onclick="submitReject()">❌ Xác nhận từ chối</button>
            </div>
        </div>
    </div>
</div>
