<?php
require_once 'db.php';
session_start();

$login = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';
$fio = trim($_POST['fio'] ?? '');
$burn_date = trim($_POST['burn_date'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($login === '' || $password === '' || $fio === '' || $burn_date === '' || $phone === '' || $email === '') {
    header('location: ../views/reg.php?error=empty');
    exit;
}

if (strlen($login) < 6 || !preg_match('/^[A-Za-z0-9]+$/', $login)) {
    header('location: ../views/reg.php?error=nameLen');
    exit;
}

if (strlen($password) < 8) {
    header('location: ../views/reg.php?error=passLen');
    exit;
}

if (!preg_match('/^[А-Яа-яЁё]+ [А-Яа-яЁё]+ [А-Яа-яЁё]+$/u', $fio)) {
    header('location: ../views/reg.php?error=fio');
    exit;
}

if (!preg_match('/^\+7\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/', $phone)) {
    header('location: ../views/reg.php?error=phone');
    exit;
}

if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$/', $email)) {
    header('location: ../views/reg.php?error=email');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) {
        header('location: ../views/reg.php?error=unic_login');
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (login, password, FIO, date_burn, phone, email, role) VALUES (?, ?, ?, ?, ?, ?, 'user')");
    $stmt->execute([$login, $password_hash, $fio, $burn_date, $phone, $email]);

    $user_id = $pdo->lastInsertId();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = 'user';

    header('location: ../index.php?event=reg_success');
    exit;
} catch (PDOException $e) {
    header('location: ../views/reg.php?error=server');
    exit;
}
