<?php
/**
 * components/pagination.php — Reusable pagination component
 * Variables: $pagination ['current_page', 'total_pages', 'total_items', 'per_page', 'base_url']
 */
$p = $pagination ?? [];
$current = $p['current_page'] ?? 1;
$total = $p['total_pages'] ?? 1;
$totalItems = $p['total_items'] ?? 0;
$perPage = $p['per_page'] ?? 20;
$baseUrl = $p['base_url'] ?? '';
$from = ($current - 1) * $perPage + 1;
$to = min($current * $perPage, $totalItems);
?>

<?php if ($total > 1): ?>
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
  <div class="pagination-info">
    Hiển thị <?= $from ?>–<?= $to ?> / <?= number_format($totalItems) ?> kết quả
  </div>
  <div class="pagination">
    <!-- Previous -->
    <a href="<?= $current > 1 ? $baseUrl . '?page=' . ($current - 1) : '#' ?>"
       class="page-link <?= $current <= 1 ? 'disabled' : '' ?>">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </a>

    <?php
    // Show page numbers with ellipsis
    $range = 2;
    for ($i = 1; $i <= $total; $i++):
      if ($i === 1 || $i === $total || ($i >= $current - $range && $i <= $current + $range)):
    ?>
      <a href="<?= $baseUrl ?>?page=<?= $i ?>" class="page-link <?= $i === $current ? 'active' : '' ?>"><?= $i ?></a>
    <?php
      elseif ($i === $current - $range - 1 || $i === $current + $range + 1):
    ?>
      <span class="page-link disabled" style="border:none;background:none;font-size:14px">…</span>
    <?php
      endif;
    endfor;
    ?>

    <!-- Next -->
    <a href="<?= $current < $total ? $baseUrl . '?page=' . ($current + 1) : '#' ?>"
       class="page-link <?= $current >= $total ? 'disabled' : '' ?>">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
  </div>
</div>
<?php endif; ?>
