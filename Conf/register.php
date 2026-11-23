<?php
require_once __DIR__ . '/includes/auth.php';
$data = handleRegister();
if ($data['success']) redirect('catalog.php');
$errors = $data['errors'];
$values = $data['values'];
$isLoggedIn = false; $isAdmin = false;
include 'header.php';
?>
<main class="container auth-page">
    <div class="auth-wrapper fade-in-up">
        <h2>Регистрация</h2>
        <form method="post" novalidate>
            <div class="mb-3">
                <label class="form-label">Логин</label>
                <input type="text" name="login" class="form-control <?= isset($errors['login']) ? 'is-invalid' : '' ?>" value="<?= e($values['login']) ?>" placeholder="Минимум 6 символов">
                <?php if (isset($errors['login'])): ?><div class="invalid-feedback"><?= e($errors['login']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Минимум 8 символов">
                <?php if (isset($errors['password'])): ?><div class="invalid-feedback"><?= e($errors['password']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">ФИО</label>
                <input type="text" name="fio" class="form-control <?= isset($errors['fio']) ? 'is-invalid' : '' ?>" value="<?= e($values['fio']) ?>">
                <?php if (isset($errors['fio'])): ?><div class="invalid-feedback"><?= e($errors['fio']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Телефон</label>
                <input type="tel" name="phone" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" value="<?= e($values['phone']) ?>" placeholder="+7 (___) ___-__-__">
                <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= e($errors['phone']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= e($values['email']) ?>">
                <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= e($errors['email']) ?></div><?php endif; ?>
            </div>
            <button type="submit" class="btn btn-auth">Зарегистрироваться</button>
        </form>
        <div class="auth-link">Уже есть аккаунт? <a href="login.php">Вход</a></div>
    </div>
</main>
<?php include 'footer.php'; ?>