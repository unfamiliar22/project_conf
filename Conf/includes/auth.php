<?php
require_once __DIR__ . '/functions.php';

function handleLogin(): array
{
    $result = ['success' => false, 'error' => '', 'login' => ''];

    if (isLoggedIn()) {
        $result['success'] = true;
        return $result;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login    = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        $result['login'] = $login;

        if ($login === '' || $password === '') {
            $result['error'] = 'Введите логин и пароль.';
        } else {
            $stmt = db()->prepare('SELECT id, password, role FROM users WHERE login = ? LIMIT 1');
            $stmt->execute([$login]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id']   = (int)$user['id'];
                $_SESSION['user_role'] = $user['role'];
                $result['success'] = true;
            } else {
                $result['error'] = 'Неверный логин или пароль.';
            }
        }
    }
    return $result;
}

function handleRegister(): array
{
    $result = [
        'success' => false,
        'errors'  => [],
        'values'  => ['login' => '', 'fio' => '', 'phone' => '', 'email' => '']
    ];

    if (isLoggedIn()) {
        $result['success'] = true;
        return $result;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $values = [
            'login' => trim($_POST['login'] ?? ''),
            'fio'   => trim($_POST['fio'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
        ];
        $password = $_POST['password'] ?? '';
        $result['values'] = $values;

        if (!preg_match('/^[A-Za-z0-9]{6,}$/', $values['login'])) {
            $result['errors']['login'] = 'Логин: латинские буквы и цифры, минимум 6 символов.';
        } else {
            $stmt = db()->prepare('SELECT id FROM users WHERE login = ?');
            $stmt->execute([$values['login']]);
            if ($stmt->fetch()) $result['errors']['login'] = 'Такой логин уже занят.';
        }

        if (mb_strlen($password) < 8) $result['errors']['password'] = 'Пароль: минимум 8 символов.';
        if ($values['fio'] === '') $result['errors']['fio'] = 'Укажите ФИО.';
        if (!preg_match('/^[\d\s\+\-\(\)]{7,}$/', $values['phone'])) $result['errors']['phone'] = 'Некорректный телефон.';
        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $result['errors']['email'] = 'Некорректный e-mail.';

        if (!$result['errors']) {
            $stmt = db()->prepare('INSERT INTO users (login, password, fio, phone, email, role) VALUES (?, ?, ?, ?, ?, "user")');
            $stmt->execute([
                $values['login'],
                password_hash($password, PASSWORD_DEFAULT),
                $values['fio'],
                $values['phone'],
                $values['email'],
            ]);
            $_SESSION['user_id']   = (int)db()->lastInsertId();
            $_SESSION['user_role'] = 'user';
            $result['success'] = true;
        }
    }
    return $result;
}