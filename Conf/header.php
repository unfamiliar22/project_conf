<?php
require_once __DIR__ . '/includes/functions.php';
$user    = currentUser();
$isAdmin = isAdmin();
$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конференции.рф — бронирование залов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header sticky-top">
    <nav class="navbar navbar-expand-lg container">
        <a class="navbar-brand" href="<?= $isLoggedIn ? ($isAdmin ? 'admin.php' : 'catalog.php') : 'login.php' ?>">
            Конференции<span class="brand-dot">.рф</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <?php if ($isAdmin): ?>
                    <!-- Админ-панель: только выход -->
                    <li class="nav-item"><span class="nav-link admin-panel-label">Админ-панель</span></li>
                    <li class="nav-item"><a href="logout.php" class="btn btn-logout">Выход</a></li>
                <?php elseif ($isLoggedIn): ?>
                    <!-- Каталог (ЛК): история заказов + красная кнопка выхода -->
                    <li class="nav-item"><a class="nav-link" href="catalog.php">Каталог</a></li>
                    <li class="nav-item"><a class="nav-link" href="history.php">История заказов</a></li>
                    <li class="nav-item"><a href="logout.php" class="btn btn-logout-red">Выход</a></li>
                <?php else: ?>
                    <!-- Гость: только вход и регистрация -->
                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>