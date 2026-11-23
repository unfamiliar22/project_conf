<?php
require_once __DIR__ . '/includes/orders.php';
requireLogin();
$orders = getUserOrders($_SESSION['user_id']);
$flash  = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
include 'header.php';
?>
<main class="container py-4">
    <h2 class="mb-4 section-title">История заявок</h2>
    <?php if ($flash): ?><div class="alert alert-success"><?= e($flash) ?></div><?php endif; ?>
    <?php if (!$orders): ?>
        <div class="order-block fade-in-up"><p class="mb-0">У вас пока нет заявок. <a href="catalog.php">Выбрать зал</a>.</p></div>
    <?php endif; ?>
    <?php foreach ($orders as $order): ?>
        <?php [$label, $badge] = statusLabel($order['status']); ?>
        <div class="order-block fade-in-up">
            <div class="order-title">Зал: <?= e($order['tour_title']) ?></div>
            <div class="order-row"><span class="label">Дата начала:</span> <?= e(date('d.m.Y', strtotime($order['start_date']))) ?></div>
            <div class="order-row"><span class="label">Способ оплаты:</span> <?= e(paymentLabel($order['payment'])) ?></div>
            <div class="order-row"><span class="label">Статус:</span> <span class="badge-status <?= e($badge) ?>"><?= e($label) ?></span></div>
            <div class="order-row"><span class="label">Создана:</span> <?= e(date('d.m.Y H:i', strtotime($order['created_at']))) ?></div>
            <div class="mt-3">
                <?php if ($order['status'] === 'done' && !$order['review_id']): ?>
                    <a href="review.php?order_id=<?= (int)$order['id'] ?>" class="btn btn-tour btn-sm">Оставить отзыв</a>
                <?php elseif ($order['review_id']): ?>
                    <span class="text-muted small">Отзыв оставлен</span>
                <?php else: ?>
                    <button class="btn btn-tour btn-sm" disabled>Оставить отзыв</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</main>
<?php include 'footer.php'; ?>