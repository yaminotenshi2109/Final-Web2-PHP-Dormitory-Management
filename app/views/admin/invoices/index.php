<?php
/**
 * admin/invoices/index.php — Hóa đơn
 * Variables: $title, $invoices[], $stats, $filters
 */
$statusMap = ['unpaid'=>['badge-warning','⏳ Chưa trả'],'paid'=>['badge-success','✅ Đã trả'],'overdue'=>['badge-danger','🔴 Quá hạn'],'cancelled'=>['badge-neutral','🚫 Đã hủy']];
?>

<div class="page-header">
  <div><h1 class="page-title">🧾 Quản lý Hóa đơn</h1><p class="page-subtitle">Theo dõi hóa đơn tiền phòng, điện, nước</p></div>
  <div class="page-actions">
    <form method="POST" action="<?= getDynamicUrl('/admin/invoices/generate') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-primary" onclick="return confirm('Tạo hóa đơn cho tháng này?')">⚡ Tạo hóa đơn tháng</button></form>
  </div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#6366f1;--stat-icon-bg:#eef2ff"><div class="stat-icon">🧾</div><div><div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div><div class="stat-label">Tổng hóa đơn</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">⏳</div><div><div class="stat-value"><?= number_format($stats['unpaid'] ?? 0) ?></div><div class="stat-label">Chưa thanh toán</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">💰</div><div><div class="stat-value"><?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?>đ</div><div class="stat-label">Đã thu</div></div></div>
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">🔴</div><div><div class="stat-value"><?= number_format($stats['overdue'] ?? 0) ?></div><div class="stat-label">Quá hạn</div></div></div>
</div>

<div class="card">
<<<<<<< HEAD
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tên sinh viên...">
=======
    <div class="card-body" style="padding:0">
        <?php if (!empty($invoices)): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Sinh viên</th>
                            <th>Phòng</th>
                            <th style="text-align:center">Tháng/Năm</th>
                            <th style="text-align:right">Tiền phòng</th>
                            <th style="text-align:right">Điện + Nước</th>
                            <th style="text-align:right">Tổng</th>
                            <th>Hạn nộp</th>
                            <th style="text-align:center">Trạng thái</th>
                            <th style="text-align:center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $page    = $pagination['current_page'] ?? 1;
                        $perPage = $pagination['per_page'] ?? 20;
                        $offset  = ($page - 1) * $perPage;

                        foreach ($invoices as $i => $inv):
                            $statusMap = [
                                'unpaid'    => ['label' => 'Chưa thanh toán', 'class' => 'badge-warning'],
                                'paid'      => ['label' => 'Đã thanh toán',   'class' => 'badge-success'],
                                'overdue'   => ['label' => 'Quá hạn',         'class' => 'badge-danger'],
                                'cancelled' => ['label' => 'Đã hủy',          'class' => 'badge-neutral'],
                            ];
                            $st = $statusMap[$inv['status'] ?? ''] ?? ['label' => $inv['status'] ?? '—', 'class' => 'badge-neutral'];

                            $elecWater = (float)($inv['electricity_fee'] ?? 0) + (float)($inv['water_fee'] ?? 0);
                            $dueDate   = $inv['due_date'] ?? '';
                            $isPastDue = $dueDate && strtotime($dueDate) < time() && ($inv['status'] ?? '') === 'unpaid';
                        ?>
                        <tr>
                            <td><?= $offset + $i + 1 ?></td>
                            <td>
                                <div style="font-weight:600"><?= htmlspecialchars($inv['full_name'] ?? '—') ?></div>
                                <?php if (!empty($inv['paid_at'])): ?>
                                    <div style="font-size:0.75rem;color:var(--text-muted)">
                                        Thanh toán: <?= htmlspecialchars(date('d/m/Y', strtotime($inv['paid_at']))) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="font-weight:600"><?= htmlspecialchars($inv['room_number'] ?? '—') ?></span>
                                <div style="font-size:0.78rem;color:var(--text-muted)"><?= htmlspecialchars($inv['building_name'] ?? '') ?></div>
                            </td>
                            <td style="text-align:center">
                                <?= sprintf('%02d/%d', (int)($inv['month'] ?? 0), (int)($inv['year'] ?? 0)) ?>
                            </td>
                            <td style="text-align:right">
                                <?= number_format((float)($inv['base_rent'] ?? 0), 0, ',', '.') ?>₫
                            </td>
                            <td style="text-align:right">
                                <?= number_format($elecWater, 0, ',', '.') ?>₫
                            </td>
                            <td style="text-align:right;font-weight:700;color:var(--primary)">
                                <?= number_format((float)($inv['total_amount'] ?? 0), 0, ',', '.') ?>₫
                            </td>
                            <td>
                                <?php if ($dueDate): ?>
                                    <span style="<?= $isPastDue ? 'color:#ef4444;font-weight:600' : '' ?>">
                                        <?= htmlspecialchars(date('d/m/Y', strtotime($dueDate))) ?>
                                    </span>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center">
                                <span class="badge <?= $st['class'] ?>"><?= $st['label'] ?></span>
                            </td>
                            <td style="text-align:center">
                                <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
                                    <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices/<?= (int)$inv['id'] ?>"
                                       class="btn btn-ghost btn-sm">👁 Xem</a>
                                    <?php if (($inv['status'] ?? '') === 'unpaid' || ($inv['status'] ?? '') === 'overdue'): ?>
                                        <form method="POST"
                                              action="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices/<?= (int)$inv['id'] ?>/mark-paid"
                                              onsubmit="return confirm('Xác nhận đánh dấu hóa đơn #<?= (int)$inv['id'] ?> là đã thanh toán?')"
                                              style="display:inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">✅ Đã thu</button>
                                        </form>
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
                <div class="empty-state-icon">🧾</div>
                <div class="empty-state-title">Không có hóa đơn nào</div>
                <div class="empty-state-desc">Không tìm thấy hóa đơn phù hợp với bộ lọc hiện tại.</div>
                <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/invoices/generate" class="btn btn-primary" style="margin-top:1rem">
                    ➕ Tạo hóa đơn mới
                </a>
            </div>
        <?php endif; ?>
>>>>>>> cab58fd2b4b300bab02822a36621ded10784ddfb
    </div>
    <select class="form-control" style="width:auto;min-width:140px">
      <option value="">Tất cả trạng thái</option>
      <option value="unpaid" <?= ($filters['status'] ?? '') === 'unpaid' ? 'selected' : '' ?>>Chưa trả</option>
      <option value="paid" <?= ($filters['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Đã trả</option>
      <option value="overdue" <?= ($filters['status'] ?? '') === 'overdue' ? 'selected' : '' ?>>Quá hạn</option>
    </select>
  </div>

  <?php if (!empty($invoices)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Sinh viên</th><th>Tháng</th><th>Tiền phòng</th><th>Điện</th><th>Nước</th><th>Tổng</th><th>Hạn nộp</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($invoices as $inv): ?>
            <?php $st = $inv['status'] ?? 'unpaid'; [$bClass, $bLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:8px">
                  <div class="avatar avatar-sm"><?= mb_strtoupper(mb_substr($inv['student_name'] ?? 'S', 0, 1)) ?></div>
                  <span style="font-weight:600"><?= htmlspecialchars($inv['student_name'] ?? '') ?></span>
                </div>
              </td>
              <td style="font-weight:600"><?= ($inv['month'] ?? '') . '/' . ($inv['year'] ?? '') ?></td>
              <td><?= number_format($inv['base_rent'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><?= number_format($inv['electricity_fee'] ?? 0, 0, ',', '.') ?>đ</td>
              <td><?= number_format($inv['water_fee'] ?? 0, 0, ',', '.') ?>đ</td>
              <td style="font-weight:800;color:var(--brand)"><?= number_format($inv['total_amount'] ?? 0, 0, ',', '.') ?>đ</td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($inv['due_date']) ? date('d/m/Y', strtotime($inv['due_date'])) : '—' ?></td>
              <td><span class="badge <?= $bClass ?>"><?= $bLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/invoices/' . ($inv['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <?php if ($st === 'unpaid' || $st === 'overdue'): ?>
                  <form method="POST" action="<?= getDynamicUrl('/admin/invoices/' . ($inv['id'] ?? '') . '/pay') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success btn-sm">💰 Đã trả</button></form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🧾</div><div class="empty-title">Chưa có hóa đơn</div></div>
  <?php endif; ?>
</div>
