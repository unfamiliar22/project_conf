<?php
require_once __DIR__ . '/includes/orders.php';
requireLogin();
$data = handleOrder();
if ($data['success']) redirect('history.php');
$halls  = getHalls();
$errors = $data['errors'];
$values = $data['values'];
include 'header.php';
?>
<main class="container py-4">
    <h2 class="mb-4 section-title">Бронирование зала</h2>
    <div class="auth-wrapper fade-in-up" style="max-width: 600px;">
        <form method="post" novalidate>
            <div class="mb-3">
                <label class="form-label">Зал</label>
                <select name="tour_id" class="form-select <?= isset($errors['tour_id']) ? 'is-invalid' : '' ?>">
                    <option value="">— выберите зал —</option>
                    <?php foreach ($halls as $t): ?>
                        <option value="<?= (int)$t['id'] ?>" <?= $values['tour_id'] === (int)$t['id'] ? 'selected' : '' ?>>
                            <?= e($t['title']) ?> — от <?= number_format((float)$t['price'], 0, '.', ' ') ?> ₽
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['tour_id'])): ?><div class="invalid-feedback"><?= e($errors['tour_id']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Дата начала мероприятия</label>
                <input type="text" name="start_date" class="form-control <?= isset($errors['start_date']) ? 'is-invalid' : '' ?>" value="<?= e($values['start_date']) ?>" placeholder="ДД.ММ.ГГГГ">
                <?php if (isset($errors['start_date'])): ?><div class="invalid-feedback"><?= e($errors['start_date']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Способ оплаты</label>
                <select name="payment" class="form-select">
                    <option value="card" <?= $values['payment']==='card'?'selected':'' ?>>Банковская карта</option>
                    <option value="cash" <?= $values['payment']==='cash'?'selected':'' ?>>Наличные</option>
                    <option value="transfer" <?= $values['payment']==='transfer'?'selected':'' ?>>Перевод на счёт</option>
                </select>
            </div>
            <button type="submit" class="btn btn-auth">Отправить заявку</button>
        </form>
    </div>
</main>
<?php include 'footer.php'; ?>