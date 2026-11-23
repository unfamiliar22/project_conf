<?php
require_once __DIR__ . '/includes/admin.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin_panel.php');
}

updateOrderStatus((int)($_POST['order_id'] ?? 0), $_POST['status'] ?? '');
redirect('admin_panel.php');