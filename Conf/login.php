<?php
require_once __DIR__ . '/includes/auth.php';
$data = handleLogin();
if ($data['success']) redirect(isAdmin() ? 'admin_panel.php' : 'catalog.php');
include 'header.php';
?>
<main class="container auth-page">
    <div class="auth-wrapper fade-in-up">
        <h2>Вход</h2>
        <?php if ($data['error']): ?><div class="alert alert-danger py-2"><?= e($data['error']) ?></div><?php endif; ?>
        <form action="#" method="post" novalidate>
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" id="login" name="login" value="<?= e($data['login']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-auth">Войти</button>
        </form>
        <div class="auth-link">Ещё не зарегистрированы? <a href="register.php">Регистрация</a></div>
    </div>
</main>
<?php include 'footer.php'; ?>