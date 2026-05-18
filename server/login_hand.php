<?php
require_once 'db.php';
session_start();

$login = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

if ($login === '' || $password === '') {
    header('location: ../views/login.php?error=empty');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $User = $stmt->fetch();

    if (!$User) {
        header('location: ../views/login.php?error=noUser');
        exit;
    }

    if (!password_verify($password, $User['password'])) {
        header('location: ../views/login.php?error=passErr');
        exit;
    }

    $_SESSION['user_id'] = $User['user_id'];
    $_SESSION['role'] = $User['role'];

    if ($User['role'] === 'admin') {
        header('location: ../views/admin.php');
        exit;
    }

    header('location: ../index.php');
    exit;
} catch (PDOException $e) {
    header('location: ../views/login.php?error=server');
    exit;
}
