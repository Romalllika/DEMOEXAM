<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'user') {
    header('location: ../index.php?event=no_user');
    exit;
}
require_once '../server/user_bids.php';

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<header>
    <a href="../index.php">Главная</a>
    <a href="profile.php">Личный кабинет</a>
    <a href="../server/logout.php">Выход</a>
</header>
<main>
    <h1>Личный кабинет</h1>

    <?php if (count($user_applications) !== 0): ?>
        <?php foreach ($user_applications as $ua): ?>
            <?php
            switch ($ua['status']) {
                case 'new': $status = 'Новая'; break;
                case 'processing': $status = 'Идет обучение'; break;
                case 'done': $status = 'Обучение завершено'; break;
                default: $status = 'Неизвестно';
            }
            ?>
            <div>
                <h3>Заявка №<?= h($ua['id']) ?></h3>
                <p>Транспорт: <?= h($ua['machine_name']) ?></p>
                <p>Дата начала: <?= h($ua['date_start']) ?></p>
                <p>Вид оплаты: <?= h($ua['pay_variant']) ?></p>
                <p>Статус: <?= h($status) ?></p>

                <?php if ($ua['status'] === 'done'): ?>
                    <div class="feedback">
                        <h4>Поделитесь впечатлениями об обучении</h4>
                        <form action="../server/feedback.php" method="POST">
                            <input type="hidden" name="app_id" value="<?= h($ua['id']) ?>">
                            <textarea name="text" id="text" required></textarea><br>
                            <input type="submit" value="Оставить отзыв">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>У вас еще нет заявок</p>
    <?php endif; ?>

    <?php
    $event = $_GET['event'] ?? '';
    switch ($event) {
        case 'error': echo 'Отзыв можно оставить только к своей завершенной заявке'; break;
        case 'errorFeedback': echo 'Заполните текст отзыва'; break;
        case 'success': echo 'Спасибо за ваш отзыв'; break;
        case 'server_error': echo 'Ошибка сервера. Попробуйте позже'; break;
    }
    ?>
</main>
<footer>&copy; Водить.РФ</footer>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
