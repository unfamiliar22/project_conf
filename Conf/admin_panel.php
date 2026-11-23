<?php
require_once __DIR__ . '/includes/admin.php';
requireAdmin();
$data = getAdminOrders();
$orders = $data['orders']; $pages = $data['pages']; $page = $data['page'];
$statusFilter = $data['filters']['statusFilter'];
$search = $data['filters']['search'];
$sort = $data['filters']['sort'];
include 'header.php';
?>
<main class="container py-4">
    <h2 class="mb-4 section-title">Панель администратора</h2>
    <form class="filter-bar row g-3 align-items-end" method="get">
        <div class="col-12 col-md-4">
            <label class="form-label">Поиск по ФИО или телефону</label>
            <input type="text" name="search" class="form-control" value="<?= e($search) ?>" placeholder="Иванов Иван">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">Статус</label>
            <select name="status" class="form-select">
                <option value="">Все</option>
                <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>Новая</option>
                <option value="assigned" <?= $statusFilter === 'assigned' ? 'selected' : '' ?>>Зал назначен</option>
                <option value="done" <?= $statusFilter === 'done' ? 'selected' : '' ?>>Мероприятие завершено</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">Сортировка</label>
            <select name="sort" class="form-select">
                <option value="id_desc" <?= $sort === 'id_desc' ? 'selected' : '' ?>>По ID (убыв.)</option>
                <option value="id_asc" <?= $sort === 'id_asc' ? 'selected' : '' ?>>По ID (возр.)</option>
                <option value="date_desc" <?= $sort === 'date_desc' ? 'selected' : '' ?>>По дате (убыв.)</option>
                <option value="date_asc" <?= $sort === 'date_asc' ? 'selected' : '' ?>>По дате (возр.)</option>
            </select>
        </div>
        <div class="col-12 col-md-2">
            <button class="btn btn-auth w-100">Применить</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr><th>ID</th><th>ФИО</th><th>Телефон</th><th>Зал</th><th>Способ оплаты</th><th>Статус</th><th></th></tr>
            </thead>
            <tbody>
                <?php if (!$orders): ?><tr><td colspan="7" class="text-center text-muted py-4">Заявок не найдено</td></tr><?php endif; ?>
                <?php foreach ($orders as $o): ?>
                    <?php [$label, $badge] = statusLabel($o['status']); ?>
                    <tr>
                        <td><?= (int)$o['id'] ?></td>
                        <td><?= e($o['fio']) ?></td>
                        <td><?= e($o['phone']) ?></td>
                        <td><?= e($o['tour_title']) ?></td>
                        <td><?= e(paymentLabel($o['payment'])) ?></td>
                        <td><span class="badge-status <?= e($badge) ?>"><?= e($label) ?></span></td>
                        <td class="text-end">
                            <form method="post" action="admin_status.php" class="d-flex gap-2">
                                <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                                <select name="status" class="form-select form-select-sm" style="width: auto;">
                                    <option value="new" <?= $o['status'] === 'new' ? 'selected' : '' ?>>Новая</option>
                                    <option value="assigned" <?= $o['status'] === 'assigned' ? 'selected' : '' ?>>Зал назначен</option>
                                    <option value="done" <?= $o['status'] === 'done' ? 'selected' : '' ?>>Мероприятие завершено</option>
                                </select>
                                <button class="btn btn-tour btn-sm">OK</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pages > 1): ?>
        <nav><ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $pages; $i++): ?><?php $qs = $_GET; $qs['page'] = $i; ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" href="?<?= e(http_build_query($qs)) ?>"><?= $i ?></a></li>
            <?php endfor; ?>
        </ul></nav>
    <?php endif; ?>
</main>
<?php include 'footer.php'; ?>