<?php
require_once __DIR__ . '/functions.php';

function getHalls(): array
{
    return db()->query('SELECT * FROM tours ORDER BY title')->fetchAll();
}

function handleOrder(): array
{
    $halls = getHalls();
    $result = [
        'success' => false,
        'errors'  => [],
        'values'  => [
            'tour_id'    => (int)($_POST['tour_id'] ?? $_GET['tour_id'] ?? 0),
            'start_date' => $_POST['start_date'] ?? '',
            'payment'    => $_POST['payment'] ?? 'card',
        ]
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $values = $result['values'];
        $tourExists = false;
        foreach ($halls as $t) {
            if ((int)$t['id'] === $values['tour_id']) { $tourExists = true; break; }
        }
        if (!$tourExists) $result['errors']['tour_id'] = 'Выберите зал.';

        if (!preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $values['start_date'])) {
            $result['errors']['start_date'] = 'Формат даты: ДД.ММ.ГГГГ.';
        } else {
            [$d, $m, $y] = explode('.', $values['start_date']);
            if (!checkdate((int)$m, (int)$d, (int)$y)) {
                $result['errors']['start_date'] = 'Некорректная дата.';
            } else {
                $result['values']['start_date'] = "$y-$m-$d"; // для БД
            }
        }
        if (!in_array($values['payment'], ['card','cash','transfer'], true)) {
            $result['errors']['payment'] = 'Выберите способ оплаты.';
        }

        if (!$result['errors']) {
            $stmt = db()->prepare('INSERT INTO orders (user_id, tour_id, start_date, payment, status) VALUES (?, ?, ?, ?, "new")');
            $stmt->execute([
                $_SESSION['user_id'],
                $values['tour_id'],
                $result['values']['start_date'],
                $values['payment'],
            ]);
            $_SESSION['flash'] = 'Заявка на бронирование отправлена администратору.';
            $result['success'] = true;
        }
    }
    return $result;
}

function getUserOrders(int $userId): array
{
    $stmt = db()->prepare(
        'SELECT o.*, t.title AS tour_title, t.country, r.id AS review_id
         FROM orders o
         JOIN tours t ON t.id = o.tour_id
         LEFT JOIN reviews r ON r.order_id = o.id
         WHERE o.user_id = ?
         ORDER BY o.created_at DESC'
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function handleReview(int $orderId, int $userId): array
{
    $result = ['success' => false, 'error' => '', 'order' => null];

    $stmt = db()->prepare('SELECT o.*, t.title AS tour_title FROM orders o JOIN tours t ON t.id = o.tour_id WHERE o.id = ? AND o.user_id = ?');
    $stmt->execute([$orderId, $userId]);
    $order = $stmt->fetch();

    if (!$order || $order['status'] !== 'done') {
        redirect('history.php');
    }
    $result['order'] = $order;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $text = trim($_POST['text'] ?? '');
        if (mb_strlen($text) < 5) {
            $result['error'] = 'Отзыв слишком короткий.';
        } else {
            $stmt = db()->prepare('INSERT INTO reviews (order_id, user_id, text) VALUES (?, ?, ?)');
            $stmt->execute([$orderId, $userId, $text]);
            $_SESSION['flash'] = 'Спасибо за отзыв!';
            $result['success'] = true;
        }
    }
    return $result;
}