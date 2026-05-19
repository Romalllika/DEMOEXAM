<?php
session_start();
require_once 'server/db.php';

$pays = [];
$machines = [];

try {
    $pays = $pdo->query("SELECT * FROM pay_variants ORDER BY id_pay")->fetchAll();
    $machines = $pdo->query("SELECT * FROM machines ORDER BY id_machine")->fetchAll();
} catch (PDOException $e) {
    $load_error = true;
}

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Водить.РФ</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <style>
        .slider-box {
            width: 400px;
            height: 300px;
            overflow: hidden;
        }
        .slider {
            width: 10000px;
            height: 300px;
        }
        img {
            width: 400px;
            height: 300px;
            float: left;
        }
        *{margin: 0; padding: 0;}
    </style>
<header>
    <a href="index.php">Главная</a>
    <?php if (isset($_SESSION['user_id'], $_SESSION['role'])): ?>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="views/admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="views/profile.php">Личный кабинет</a>
        <?php endif; ?>
        <a href="server/logout.php">Выход</a>
    <?php else: ?>
        <a href="views/login.php">Вход</a>
        <a href="views/reg.php">Регистрация</a>
    <?php endif; ?>
</header>
<main>
    <h1>Запись на обучение вождению речного транспорта</h1>
    <div class="slider-box">
        <div class="slider">
            <img src="img/im5.jpg" alt="5">
            
            <img src="img/im1.jpg" alt="1">
            <img src="img/im2.jpg" alt="2">
            <img src="img/im3.jpg" alt="3">
            <img src="img/im4.jpg" alt="4">
            <img src="img/im5.jpg" alt="5">

            <img src="img/im1.jpg" alt="1">
        </div>
    </div>
    <form action="server/add_bid.php" method="POST">
        <label for="machine">Выберите транспорт:</label><br>
        <select name="machine" id="machine" required>
            <option value="0">Выберите транспорт</option>
            <?php foreach ($machines as $m): ?>
                <option value="<?= h($m['id_machine']) ?>"><?= h($m['machine_name']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="date">Укажите желаемую дату начала обучения:</label><br>
        <input type="date" name="date" id="date" required><br>

        <label for="pay">Выберите способ оплаты:</label><br>
        <select name="pay" id="pay" required>
            <option value="0">Выберите способ оплаты</option>
            <?php foreach ($pays as $p): ?>
                <option value="<?= h($p['id_pay']) ?>"><?= h($p['variant']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Подать заявку">
    </form>

    <div class="res">
        <?php
        $event = $_GET['event'] ?? '';
        switch ($event) {
            case 'reg_success': echo 'Регистрация прошла успешно'; break;
            case 'bid_confirm': echo 'Заявка создана'; break;
            case 'bid_bad': echo 'Заполните все данные заявки корректно'; break;
            case 'server_error': echo 'Ошибка сервера'; break;
            case 'no_user': echo 'Пожалуйста, авторизуйтесь или создайте аккаунт'; break;
        }
        ?>
    </div>
</main>
<footer>&copy; Водить.РФ</footer>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
