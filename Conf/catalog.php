<?php
require_once __DIR__ . '/includes/orders.php';
requireLogin();
$halls = getHalls();
include 'header.php';
?>
<main class="container py-4">
    <!-- Слайдер -->
    <?php if (!empty($halls)): ?>
    <div class="slider-wrapper position-relative fade-in-up">
        <div class="slider-track">
            <?php foreach ($halls as $hall): ?>
                <div class="slide" style="background-image: url('<?= e(hallImage($hall['image'])) ?>');">
                    <div class="slide-caption"><h3><?= e($hall['title']) ?></h3></div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="slider-btn prev" aria-label="Назад">&#10094;</button>
        <button class="slider-btn next" aria-label="Вперёд">&#10095;</button>
    </div>
    <?php endif; ?>

    <h2 class="mb-4 section-title">Доступные залы для бронирования</h2>
    <div class="row g-4">
        <?php foreach ($halls as $hall): ?>
        <div class="col-12 col-sm-6 col-lg-4 fade-in-up">
            <div class="card tour-card">
                <img src="<?= e(hallImage($hall['image'])) ?>" alt="<?= e($hall['title']) ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= e($hall['title']) ?></h5>
                    <p class="card-text text-muted small"><?= e($hall['description']) ?></p>
                    <p class="price mb-3">от <?= number_format((float)$hall['price'], 0, '.', ' ') ?> ₽</p>
                    <a href="order.php?tour_id=<?= (int)$hall['id'] ?>" class="btn btn-tour mt-auto">Забронировать</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include 'footer.php'; ?>