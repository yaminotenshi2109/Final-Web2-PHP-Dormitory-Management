<?php
/**
 * admin/maintenance/index.php — Bảo trì
 * Variables: $title, $requests[], $stats, $filters
 */
$statusMap = ['open'=>['badge-danger','🔴 Mở'],'in_progress'=>['badge-warning','🔧 Đang xử lý'],'resolved'=>['badge-success','✅ Đã xử lý'],'closed'=>['badge-neutral','✔️ Đóng'],'rejected'=>['badge-neutral','❌ Từ chối']];
$priorityMap = ['low'=>['badge-info','Thấp'],'medium'=>['badge-warning','Trung bình'],'high'=>['badge-danger','Cao'],'urgent'=>['badge-danger','🔥 Khẩn cấp']];
?>

<div class="page-header">
  <div><h1 class="page-title">🔧 Quản lý Bảo trì</h1><p class="page-subtitle">Theo dõi yêu cầu sửa chữa, bảo trì phòng</p></div>
</div>

<div class="stat-grid mb-24">
  <div class="stat-card" style="--stat-color:#ef4444;--stat-icon-bg:#fee2e2"><div class="stat-icon">🔴</div><div><div class="stat-value"><?= number_format($stats['open'] ?? 0) ?></div><div class="stat-label">Đang mở</div></div></div>
  <div class="stat-card" style="--stat-color:#f59e0b;--stat-icon-bg:#fef3c7"><div class="stat-icon">🔧</div><div><div class="stat-value"><?= number_format($stats['in_progress'] ?? 0) ?></div><div class="stat-label">Đang xử lý</div></div></div>
  <div class="stat-card" style="--stat-color:#10b981;--stat-icon-bg:#d1fae5"><div class="stat-icon">✅</div><div><div class="stat-value"><?= number_format($stats['resolved'] ?? 0) ?></div><div class="stat-label">Đã xử lý</div></div></div>
</div>

<div class="card">
<<<<<<< HEAD
  <div class="filter-bar">
    <div class="filter-search">
      <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" class="form-control" placeholder="Tìm theo tiêu đề, phòng...">
=======
    <div class="card-body" style="padding:0">
        <?php if (!empty($requests)): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Phòng</th>
                            <th>Tiêu đề</th>
                            <th style="text-align:center">Mức ưu tiên</th>
                            <th style="text-align:center">Trạng thái</th>
                            <th>Báo cáo bởi</th>
                            <th>Ngày báo cáo</th>
                            <th style="text-align:center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $page    = $pagination['current_page'] ?? 1;
                        $perPage = $pagination['per_page'] ?? 20;
                        $offset  = ($page - 1) * $perPage;

                        foreach ($requests as $i => $req):
                            $priorityMap = [
                                'low'    => ['label' => 'Thấp',      'class' => 'badge-neutral'],
                                'medium' => ['label' => 'Trung bình', 'class' => 'badge-info'],
                                'high'   => ['label' => 'Cao',        'class' => 'badge-warning'],
                                'urgent' => ['label' => 'Khẩn cấp',  'class' => 'badge-danger'],
                            ];
                            $pri = $priorityMap[$req['priority'] ?? ''] ?? ['label' => $req['priority'] ?? '—', 'class' => 'badge-neutral'];

                            $statusMap = [
                                'open'        => ['label' => 'Mới mở',       'class' => 'badge-danger'],
                                'in_progress' => ['label' => 'Đang xử lý',   'class' => 'badge-warning'],
                                'resolved'    => ['label' => 'Đã giải quyết','class' => 'badge-success'],
                                'closed'      => ['label' => 'Đã đóng',      'class' => 'badge-neutral'],
                                'rejected'    => ['label' => 'Đã từ chối',   'class' => 'badge-neutral'],
                            ];
                            $st = $statusMap[$req['status'] ?? ''] ?? ['label' => $req['status'] ?? '—', 'class' => 'badge-neutral'];

                            $canResolve = in_array($req['status'] ?? '', ['open', 'in_progress']);
                            $canClose   = in_array($req['status'] ?? '', ['open', 'in_progress', 'resolved']);
                        ?>
                        <tr>
                            <td><?= $offset + $i + 1 ?></td>
                            <td>
                                <span style="font-weight:600"><?= htmlspecialchars($req['room_number'] ?? '—') ?></span>
                                <div style="font-size:0.78rem;color:var(--text-muted)"><?= htmlspecialchars($req['building_name'] ?? '') ?></div>
                            </td>
                            <td>
                                <div style="max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"
                                     title="<?= htmlspecialchars($req['title'] ?? '') ?>">
                                    <?= htmlspecialchars($req['title'] ?? '—') ?>
                                </div>
                            </td>
                            <td style="text-align:center">
                                <span class="badge <?= $pri['class'] ?>"><?= $pri['label'] ?></span>
                            </td>
                            <td style="text-align:center">
                                <span class="badge <?= $st['class'] ?>"><?= $st['label'] ?></span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:6px">
                                    <span style="font-size:1.1rem">👤</span>
                                    <?= htmlspecialchars($req['reporter_username'] ?? '—') ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                $dt = $req['reported_at'] ?? '';
                                if ($dt) {
                                    echo htmlspecialchars(date('d/m/Y', strtotime($dt)));
                                    echo '<div style="font-size:0.75rem;color:var(--text-muted)">';
                                    echo htmlspecialchars(date('H:i', strtotime($dt)));
                                    echo '</div>';
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td style="text-align:center">
                                <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
                                    <a href="/Final-Web2-PHP-Dormitory-Management/public/admin/maintenance/<?= (int)$req['id'] ?>"
                                       class="btn btn-ghost btn-sm">👁 Xem</a>

                                    <?php if ($canResolve): ?>
                                        <form method="POST"
                                              action="/Final-Web2-PHP-Dormitory-Management/public/admin/maintenance/<?= (int)$req['id'] ?>/resolve"
                                              onsubmit="return confirm('Đánh dấu yêu cầu #<?= (int)$req['id'] ?> là đã giải quyết?')"
                                              style="display:inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">✅ Giải quyết</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($canClose && ($req['status'] ?? '') !== 'closed'): ?>
                                        <form method="POST"
                                              action="/Final-Web2-PHP-Dormitory-Management/public/admin/maintenance/<?= (int)$req['id'] ?>/close"
                                              onsubmit="return confirm('Đóng yêu cầu bảo trì #<?= (int)$req['id'] ?>?')"
                                              style="display:inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>">
                                            <button type="submit" class="btn btn-outline btn-sm">🔒 Đóng</button>
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
                <div class="empty-state-icon">🔧</div>
                <div class="empty-state-title">Không có yêu cầu bảo trì nào</div>
                <div class="empty-state-desc">Hiện tại không có yêu cầu bảo trì phù hợp với bộ lọc hiện tại.</div>
            </div>
        <?php endif; ?>
>>>>>>> cab58fd2b4b300bab02822a36621ded10784ddfb
    </div>
    <select class="form-control" style="width:auto;min-width:140px">
      <option value="">Tất cả trạng thái</option>
      <option value="open" <?= ($filters['status'] ?? '') === 'open' ? 'selected' : '' ?>>Đang mở</option>
      <option value="in_progress" <?= ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>Đang xử lý</option>
      <option value="resolved" <?= ($filters['status'] ?? '') === 'resolved' ? 'selected' : '' ?>>Đã xử lý</option>
    </select>
    <select class="form-control" style="width:auto;min-width:120px">
      <option value="">Mức độ</option>
      <option value="urgent" <?= ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' ?>>Khẩn cấp</option>
      <option value="high" <?= ($filters['priority'] ?? '') === 'high' ? 'selected' : '' ?>>Cao</option>
      <option value="medium" <?= ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' ?>>TB</option>
      <option value="low" <?= ($filters['priority'] ?? '') === 'low' ? 'selected' : '' ?>>Thấp</option>
    </select>
  </div>

  <?php if (!empty($requests)): ?>
    <div class="table-wrapper" style="border:none;border-radius:0;box-shadow:none">
      <table>
        <thead><tr><th>Tiêu đề</th><th>Phòng</th><th>Người báo</th><th>Mức độ</th><th>Ngày báo</th><th>Trạng thái</th><th style="text-align:right">Thao tác</th></tr></thead>
        <tbody>
          <?php foreach ($requests as $rq): ?>
            <?php $st = $rq['status'] ?? 'open'; [$sClass, $sLabel] = $statusMap[$st] ?? ['badge-neutral', $st]; $pr = $rq['priority'] ?? 'medium'; [$pClass, $pLabel] = $priorityMap[$pr] ?? ['badge-neutral', $pr]; ?>
            <tr>
              <td><div style="font-weight:600"><?= htmlspecialchars($rq['title'] ?? '') ?></div><div class="sub"><?= htmlspecialchars(mb_strimwidth($rq['description'] ?? '', 0, 50, '...')) ?></div></td>
              <td style="font-weight:700"><?= htmlspecialchars($rq['room_number'] ?? '') ?><div class="sub"><?= htmlspecialchars($rq['building_name'] ?? '') ?></div></td>
              <td><?= htmlspecialchars($rq['reporter_name'] ?? '') ?></td>
              <td><span class="badge <?= $pClass ?>"><?= $pLabel ?></span></td>
              <td style="font-size:12px;color:var(--txt-muted)"><?= !empty($rq['reported_at']) ? date('d/m/Y', strtotime($rq['reported_at'])) : '—' ?></td>
              <td><span class="badge <?= $sClass ?>"><?= $sLabel ?></span></td>
              <td style="text-align:right">
                <a href="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '')) ?>" class="btn btn-ghost btn-sm">Xem</a>
                <?php if ($st === 'open' || $st === 'in_progress'): ?>
                  <form method="POST" action="<?= getDynamicUrl('/admin/maintenance/' . ($rq['id'] ?? '') . '/resolve') ?>" style="display:inline"><input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_csrfToken ?? '') ?>"><button type="submit" class="btn btn-success btn-sm">✅ Xử lý</button></form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state"><div class="empty-icon">🔧</div><div class="empty-title">Không có yêu cầu bảo trì</div></div>
  <?php endif; ?>
</div>
