<?php
require_once __DIR__ . '/includes/orders.php';
requireLogin();
$orderId = (int)($_GET['order_id'] ?? $_POST['order_id'] ?? 0);
$data = handleReview($orderId, $_SESSION['user_id']);
if ($data['success']) redirect('history.php');
$order = $data['order'];
include 'header.php';
?>
<main class="container py-4">
    <h2 class="mb-4 section-title">Отзыв о зале «<?= e($order['tour_title']) ?>»</h2>
    <div class="auth-wrapper fade-in-up" style="max-width: 600px;">
        <?php if ($data['error']): ?><div class="alert alert-danger py-2"><?= e($data['error']) ?></div><?php endif; ?>
        <form method="post">
            <input type="hidden" name="order_id" value="<?= (int)$orderId ?>">
            <div class="mb-3">
                <label class="form-label">Ваш отзыв</label>
                <textarea name="text" rows="5" class="form-control" placeholder="Поделитесь впечатлениями..." required></textarea>
            </div>
            <button type="submit" class="btn btn-auth">Отправить отзыв</button>
        </form>
    </div>
</main>
<?php include 'footer.php'; ?>