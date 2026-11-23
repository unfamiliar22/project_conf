<?php
require_once __DIR__ . '/db.php';

// Экранирование
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Текущий пользователь
function currentUser(): ?array
{
    if (empty($_SESSION['user_id'])) return null;
    $stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch() ?: null;
}

// Авторизован?
function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

// Админ?
function isAdmin(): bool
{
    return isLoggedIn() && ($_SESSION['user_role'] ?? '') === 'admin';
}

// Редирект
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// Требуется авторизация
function requireLogin(): void
{
    if (!isLoggedIn()) redirect('login.php');
}

// Требуется админ
function requireAdmin(): void
{
    if (!isAdmin()) redirect('login.php');
}

// Человеческое название статуса заявки
function statusLabel(string $status): array
{
    switch ($status) {
        case 'new':      return ['Новая', 'badge-new'];
        case 'assigned': return ['Зал назначен', 'badge-assigned'];
        case 'done':     return ['Мероприятие завершено', 'badge-done'];
        default:         return ['Неизвестно', 'badge-new'];
    }
}

// Человеческое название способа оплаты
function paymentLabel(string $payment): string
{
    switch ($payment) {
        case 'card':     return 'Банковская карта';
        case 'cash':     return 'Наличные';
        case 'transfer': return 'Перевод на счёт';
        default:         return 'Не указано';
    }
}

// Формирование пути к картинке зала
function hallImage(?string $image): string
{
    if (empty($image)) return 'img/no-image.jpg';
    if (strpos($image, 'http') === 0) return $image;
    return 'img/' . $image;
}