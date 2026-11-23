<?php
require_once __DIR__ . '/functions.php';

function getAdminOrders(): array
{
    $statusFilter = $_GET['status'] ?? '';
    $search       = trim($_GET['search'] ?? '');
    $sort         = $_GET['sort'] ?? 'id_desc';
    $page         = max(1, (int)($_GET['page'] ?? 1));
    $perPage      = 10;
    $offset       = ($page - 1) * $perPage;

    $where  = [];
    $params = [];

    if (in_array($statusFilter, ['new','assigned','done'], true)) {
        $where[]  = 'o.status = ?';
        $params[] = $statusFilter;
    }
    if ($search !== '') {
        $where[]  = '(u.fio LIKE ? OR u.phone LIKE ?)';
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    switch ($sort) {
        case 'id_asc':    $orderBy = 'o.id ASC'; break;
        case 'date_asc':  $orderBy = 'o.created_at ASC'; break;
        case 'date_desc': $orderBy = 'o.created_at DESC'; break;
        default:          $orderBy = 'o.id DESC'; break;
    }

    $sqlBase = 'FROM orders o JOIN users u ON u.id = o.user_id JOIN tours t ON t.id = o.tour_id';
    $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

    $stmt = db()->prepare("SELECT COUNT(*) $sqlBase $whereSql");
    $stmt->execute($params);
    $total = (int)$stmt->fetchColumn();
    $pages = max(1, (int)ceil($total / $perPage));

    $stmt = db()->prepare("SELECT o.*, u.fio, u.phone, t.title AS tour_title $sqlBase $whereSql ORDER BY $orderBy LIMIT $perPage OFFSET $offset");
    $stmt->execute($params);
    
    return [
        'orders' => $stmt->fetchAll(),
        'total'  => $total,
        'pages'  => $pages,
        'page'   => $page,
        'filters'=> compact('statusFilter', 'search', 'sort')
    ];
}

function updateOrderStatus(int $orderId, string $status): void
{
    if ($orderId > 0 && in_array($status, ['new','assigned','done'], true)) {
        $stmt = db()->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$status, $orderId]);
    }
}