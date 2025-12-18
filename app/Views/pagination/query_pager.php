<?php
/** @var CodeIgniter\Pager\PagerRenderer $pager */
$pager->setSurroundCount(2);
$params = $params ?? [];
$group = method_exists($pager, 'getPageName') ? $pager->getPageName() : 'default';
$group = $group ?: 'default';
$agentLogPath = 'c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log';
if (! is_dir(dirname($agentLogPath))) {
    @mkdir(dirname($agentLogPath), 0775, true);
}
$agentLog = static function (string $hypothesisId, string $location, string $message, array $data = []) use ($agentLogPath): void {
    $payload = json_encode([
        'sessionId'    => 'debug-session',
        'runId'        => 'aktivitas-debug',
        'hypothesisId' => $hypothesisId,
        'location'     => $location,
        'message'      => $message,
        'data'         => $data,
        'timestamp'    => round(microtime(true) * 1000),
    ]);
    @file_put_contents($agentLogPath, $payload . PHP_EOL, FILE_APPEND);
};
// #region agent log
$agentLog('H5', 'pagination/query_pager.php:init', 'Pagination view init', [
    'group' => $group,
    'hasPrev' => $pager->hasPrevious(),
    'hasNext' => $pager->hasNext(),
]);
// #endregion
$currentPage = method_exists($pager, 'getCurrentPageNumber')
    ? $pager->getCurrentPageNumber()
    : (method_exists($pager, 'getCurrentPage') ? (int) $pager->getCurrentPage($group) : 1);
$pageCount = method_exists($pager, 'getPageCount')
    ? max(1, (int) $pager->getPageCount())
    : (method_exists($pager, 'getLastPageNumber') ? max(1, (int) $pager->getLastPageNumber()) : $currentPage);
$buildUrl = static function ($page) use ($params, $group) {
    $query = $params;
    $query['page_' . $group] = max(1, (int) $page);
    return '?' . http_build_query($query);
};
?>
<?php if ($pager->hasPrevious() || $pager->hasNext()): ?>
<nav aria-label="Pagination">
    <ul class="pagination pagination-sm mb-0">
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $buildUrl(1) ?>">First</a>
        </li>
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $buildUrl(max(1, $currentPage - 1)) ?>">Prev</a>
        </li>
        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $buildUrl($link['title']) ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>
        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $buildUrl(min($pageCount, $currentPage + 1)) ?>">Next</a>
        </li>
        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $buildUrl($pageCount) ?>">Last</a>
        </li>
    </ul>
</nav>
<?php endif; ?>
