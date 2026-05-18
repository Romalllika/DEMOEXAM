<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_applications = [];

if (!isset($_SESSION['user_id'])) {
    return;
}

$user_id = (int)$_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT applications.id, applications.date_start, applications.status, applications.pay_var, machines.machine_name, pay_variants.variant AS pay_variant FROM applications INNER JOIN machines ON applications.machine_id = machines.id_machine INNER JOIN pay_variants ON applications.pay_var = pay_variants.id_pay WHERE applications.user_id = ? ORDER BY applications.id DESC");
    $stmt->execute([$user_id]);
    $user_applications = $stmt->fetchAll();
} catch (PDOException $e) {
    $user_applications = [];
}
