<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: ../index.php');
    exit;
}
include '../server/admin_hand.php';

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<header>
    <a href="../server/logout.php">Выйти</a>
    <a href="../index.php">← Назад</a>
</header>
<main>
    <h1>Панель администратора</h1>

    <?php
    $event = $_GET['event'] ?? '';
    switch ($event) {
        case 'changeStatus': echo '<p>Статус успешно изменен</p>'; break;
        case 'errorStatus': echo '<p>Ошибка смены статуса</p>'; break;
    }
    ?>

    <?php if (count($all_bids) === 0): ?>
        <p>Заявок пока нет</p>
    <?php endif; ?>

    <?php foreach ($all_bids as $ab): ?>
        <?php
        switch ($ab['status']) {
            case 'new': $status = 'Новая'; break;
            case 'processing': $status = 'Идет обучение'; break;
            case 'done': $status = 'Обучение завершено'; break;
            default: $status = 'Неизвестно';
        }
        ?>
        <div class="bid-card">
            <h3>Заявка №<?= h($ab['application_id']) ?></h3>
            <p>Курс: <?= h($ab['machine_name']) ?></p>
            <p>Дата начала: <?= h($ab['date_start']) ?></p>
            <p>Данные заказчика:</p>
            <div class="customer">
                <p>ФИО: <?= h($ab['FIO']) ?></p>
                <p>Телефон: <?= h($ab['phone']) ?></p>
                <p>Почта: <?= h($ab['email']) ?></p>
            </div>
            <p>Вид оплаты: <?= h($ab['pay_variant']) ?></p>
            <p>Статус: <?= h($status) ?></p>

            <h3>Изменить статус</h3>
            <a href="../server/admin_hand.php?status=new&id=<?= h($ab['application_id']) ?>">Новая</a>
            <a href="../server/admin_hand.php?status=processing&id=<?= h($ab['application_id']) ?>">Идет обучение</a>
            <a href="../server/admin_hand.php?status=done&id=<?= h($ab['application_id']) ?>">Обучение завершено</a>
        </div>
    <?php endforeach; ?>
</main>
<footer>&copy; Водить.РФ</footer>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
