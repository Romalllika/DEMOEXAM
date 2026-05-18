<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <main>
        <form action="../server/reg_hand.php" method="POST">
            <label for="login">Логин</label><br>
            <input type="text" id="login" name="login"><br>
            <label for="password">Пароль</label><br>
            <input type="password" id="password" name="password"><br>
            <label for="fio">Ваше ФИО</label><br>
            <input type="text" id="fio" name="fio"><br>
            <label for="burn_date">Дата рождения</label><br>
            <input type="date" id="burn_date" name="burn_date"><br>
            <label for="phone">Номер телефона</label><br>
            <input type="tel" id="phone" name="phone" placeholder="+7(999) 999-99-99"><br>
            <label for="email">Почта</label><br>
            <input type="email" id="email" name="email"><br><br>
            <input type="submit" value="Создать пользователя">
            <p>Есть аккаунт? <a href="login.php">Войти</a></p>
        </form>
        <?php
        $error = $_GET['error']?$_GET['error']:'';
        switch ($error){
            case 'empty':
                echo 'Заполните все поля';
                break;
            case 'nameLen':
                echo 'Логин должен быть не короче 6 символов и содержать только латинские буквы и цифры';
                break;
            case 'passLen':
                echo 'Пароль должен быть не короче 8 символов';
                break;
            case 'email':
                echo 'Неверный формат почты';
                break;
            case 'phone':
                echo 'Неверный формат телефона';
                break;
            case 'unic_login':
                echo 'Такой логин уже занят';
                break;
            case 'server':
                echo 'Ошибка сервера. Попробуйте позже';
                break;
            case 'fio':
                echo 'Поле ФИО заполнено неверно';
                break;
        }
        ?>
    </main>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>