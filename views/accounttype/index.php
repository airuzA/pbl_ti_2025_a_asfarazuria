<?php
require_once __DIR__ . '/../layout/header.php';

$page = isset($page) ? (int) $page : 1;
$totalPages = isset($totalPages) ? (int) $totalPages : 1;
$search = isset($search) ? (string) $search : '';
$totalAccountTypes = isset($totalAccountTypes) ? (int) $totalAccountTypes : 0;

if ($totalPages < 1) {
    $totalPages = 1;
}
if ($page < 1) {
    $page = 1;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">AccountType</h4>
    <a href="<?= BASE_URL ?>/account-type/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add AccountType
    </a>
</div>

<form method="GET" action="<?= BASE_URL ?>/account-type" class="mb-3" role="search">
    <div class="row g-2">
        <div class="col-sm-8 col-md-6">
            <label for="account-type-search" class="visually-hidden">Search account types</label>
            <input id="account-type-search" type="search" name="q" class="form-control"
                   placeholder="Search name or description"
                   value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
        <?php if ($search !== ''): ?>
            <div class="col-auto">
                <a href="<?= BASE_URL ?>/account-type" class="btn btn-outline-secondary">Reset</a>
            </div>
        <?php endif; ?>
    </div>
</form>

<?php if (empty($accounttype)): ?>
    <div class="card text-center p-5">
        <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
        <p class="mt-3 mb-3 text-muted">No account type found.</p>
        <a href="<?= BASE_URL ?>/account-type/create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add AccountType
        </a>
    </div>
<?php else: ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounttype as $row): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td class="text-end">
                            <a href="<?= BASE_URL ?>/account-type/<?= urlencode($row['id']) ?>/edit"
                               class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?= BASE_URL ?>/account-type/<?= urlencode($row['id']) ?>/delete"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure?')">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if ($totalAccountTypes > 0): ?>
    <?php
    $baseQuery = [];
    if ($search !== '') {
        $baseQuery['q'] = $search;
    }

    $makeUrl = function (int $p) use ($baseQuery) {
        $query = $baseQuery;
        $query['page'] = $p;
        return BASE_URL . '/account-type?' . http_build_query($query);
    };

    $previousPage = max(1, $page - 1);
    $nextPage = min($totalPages, $page + 1);
    ?>
    <nav class="mt-3" aria-label="Account type pages">
        <ul class="pagination justify-content-end mb-0">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <?php if ($page <= 1): ?>
                    <span class="page-link">Previous</span>
                <?php else: ?>
                    <a class="page-link" href="<?= htmlspecialchars($makeUrl($previousPage), ENT_QUOTES, 'UTF-8') ?>">Previous</a>
                <?php endif; ?>
            </li>

            <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++): ?>
                <?php $isActive = ($pageNumber === $page); ?>
                <li class="page-item <?= $isActive ? 'active' : '' ?>">
                    <a class="page-link"
                       href="<?= htmlspecialchars($makeUrl($pageNumber), ENT_QUOTES, 'UTF-8') ?>"
                       <?= $isActive ? 'aria-current="page"' : '' ?>>
                        <?= $pageNumber ?>
                    </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <?php if ($page >= $totalPages): ?>
                    <span class="page-link">Next</span>
                <?php else: ?>
                    <a class="page-link" href="<?= htmlspecialchars($makeUrl($nextPage), ENT_QUOTES, 'UTF-8') ?>">Next</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
