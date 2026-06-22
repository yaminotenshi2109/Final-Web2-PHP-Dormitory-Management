<?php
/**
 * admin/users/show.php — Chi tiết tài khoản
 * Variables: $title, $user, $_csrfToken
 */
$u = $user ?? [];
$roleMap = ['admin'=>['badge-purple',' Admin'],'student'=>['badge-info',' Sinh viên']];
$statusMap = ['active'=>['badge-success',' Hoạt động'],'inactive'=>['badge-neutral',' Ngừng'],'banned'=>['badge-danger',' Cấm']];
$role = $u['role'] ?? 'student'; [$rClass, $rLabel] = $roleMap[$role] ?? ['badge-neutral', $role];
$st = $u['status'] ?? 'active'; [$sClass, $sLabel] = $statusMap[$st] ?? ['badge-neutral', $st];
?>

<div class="page-header">
  <div><h1 class="page-title"> <?= htmlspecialchars($u['username'] ?? '') ?></h1><p class="page-subtitle">Chi tiết tài khoản</p></div>
  <div class="page-actions">
    <a href="<?= getDynamicUrl('/admin/users') ?>" class="btn btn-ghost">← Quay lại</a>
    <a href="<?= getDynamicUrl('/admin/users/' . ($u['id'] ?? '') . '/edit') ?>" class="btn btn-outline"> Sửa</a>
  </div>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body" style="text-align:center;padding:40px">
    <div class="avatar avatar-xl" style="width:80px;height:80px;font-size:28px;margin:0 auto 16px"><?= mb_strtoupper(mb_substr($u['username'] ?? 'U', 0, 1)) ?></div>
    <div style="font-size:22px;font-weight:800;margin-bottom:4px"><?= htmlspecialchars($u['username'] ?? '') ?></div>
    <div style="color:var(--txt-muted);font-size:14px;margin-bottom:12px"><?= htmlspecialchars($u['email'] ?? '') ?></div>
    <div style="display:flex;gap:8px;justify-content:center"><span class="badge <?= $rClass ?>"><?= $rLabel ?></span><span class="badge <?= $sClass ?>"><?= $sLabel ?></span></div>
  </div>
  <div class="card-body" style="border-top:1px solid var(--border)">
    <table style="width:100%;font-size:14px">
      <tr><td style="padding:10px 0;color:var(--txt-muted)">ID</td><td style="text-align:right;font-family:monospace">#<?= $u['id'] ?? '' ?></td></tr>
      <tr><td style="padding:10px 0;color:var(--txt-muted)">Ngày tạo</td><td style="text-align:right"><?= !empty($u['created_at']) ? date('d/m/Y H:i', strtotime($u['created_at'])) : '—' ?></td></tr>
      <tr><td style="padding:10px 0;color:var(--txt-muted)">Đăng nhập cuối</td><td style="text-align:right"><?= !empty($u['last_login']) ? date('d/m/Y H:i', strtotime($u['last_login'])) : 'Chưa bao giờ' ?></td></tr>
    </table>
  </div>
</div>
