<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <main>
        <form action="../server/login_hand.php" method="POST">
            <label for="login">Логин</label><br>
            <input type="text" id="login" name="login"><br>
            <label for="password">Пароль</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Войти">
            <p>Еще не зарегистрированы? <a href="reg.php">Регистрация</a></p>
        </form>
        <?php
        $error = $_GET['error'] ? $_GET['error'] : '';
        switch ($error) {
            case 'noUser':
                echo '<p class="text-center text-danger">Неверный логин</p>';
                break;
            case 'passErr':
                echo '<p class="text-center text-danger">Неверный пароль</p>';
                break;
            case 'empty':
                echo '<p class="text-center text-danger">Заполните все поля</p>';
                break;
            case 'server':
                echo '<p class="text-center text-danger">Ошибка сервера. Попробуйте позже</p>';
                break;
        }

        ?>
    </main>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>