<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'user') {
    header('location: ../index.php?event=no_user');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$app_id = (int)($_POST['app_id'] ?? $_GET['app_id'] ?? 0);
$text = trim($_POST['text'] ?? $_GET['text'] ?? '');

if ($app_id <= 0 || $text === '') {
    header('location: ../views/profile.php?event=errorFeedback');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id FROM applications WHERE id = ? AND user_id = ? AND status = 'done'");
    $stmt->execute([$app_id, $user_id]);
    $application = $stmt->fetch();

    if (!$application) {
        header('location: ../views/profile.php?event=error');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO feedback (user_id, text, application_id) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $text, $app_id]);

    header('location: ../views/profile.php?event=success');
    exit;
} catch (PDOException $e) {
    header('location: ../views/profile.php?event=server_error');
    exit;
}
