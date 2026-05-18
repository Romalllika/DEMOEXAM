<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: ../index.php');
    exit;
}

if (isset($_GET['status'], $_GET['id'])) {
    $status = $_GET['status'];
    $id = (int)$_GET['id'];
    $allowedStatuses = ['new', 'processing', 'done'];

    if (!in_array($status, $allowedStatuses, true) || $id <= 0) {
        header('location: ../views/admin.php?event=errorStatus');
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        header('location: ../views/admin.php?event=changeStatus');
        exit;
    } catch (PDOException $e) {
        header('location: ../views/admin.php?event=errorStatus');
        exit;
    }
}

try {
    $stmt = $pdo->query("SELECT applications.id AS application_id, applications.date_start, applications.status, applications.pay_var, users.FIO, users.phone, users.email, machines.machine_name, pay_variants.variant AS pay_variant FROM applications INNER JOIN users ON applications.user_id = users.user_id INNER JOIN machines ON applications.machine_id = machines.id_machine INNER JOIN pay_variants ON applications.pay_var = pay_variants.id_pay ORDER BY applications.id DESC");
    $all_bids = $stmt->fetchAll();
} catch (PDOException $e) {
    $all_bids = [];
}
