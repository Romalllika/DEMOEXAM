<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'user') {
    header('location: ../index.php?event=no_user');
    exit;
}

$machine = (int)($_POST['machine'] ?? 0);
$date = trim($_POST['date'] ?? '');
$pay = (int)($_POST['pay'] ?? 0);
$user_id = (int)$_SESSION['user_id'];

if ($machine <= 0 || $pay <= 0 || $date === '') {
    header('location: ../index.php?event=bid_bad');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id_machine FROM machines WHERE id_machine = ?");
    $stmt->execute([$machine]);
    if (!$stmt->fetch()) {
        header('location: ../index.php?event=bid_bad');
        exit;
    }

    $stmt = $pdo->prepare("SELECT id_pay FROM pay_variants WHERE id_pay = ?");
    $stmt->execute([$pay]);
    if (!$stmt->fetch()) {
        header('location: ../index.php?event=bid_bad');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO applications (machine_id, date_start, pay_var, user_id, status) VALUES (?, ?, ?, ?, 'new')");
    $stmt->execute([$machine, $date, $pay, $user_id]);

    header('location: ../index.php?event=bid_confirm');
    exit;
} catch (PDOException $e) {
    header('location: ../index.php?event=server_error');
    exit;
}
