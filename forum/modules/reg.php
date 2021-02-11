<?php
session_start();
require '../server/config.php';

if (!isset($_SESSION['id'])) {
    print "<a href='$site_url/modules/themes.php'>Главная</a><br>";
    echo <<<HTML
<head>
<title>Регистрация</title>
</head>
<body>
<form action="${site_url}/server/reg.php" method="post">
<input type="text" name="email" placeholder="email">
<input required type="text" name="name" placeholder="Имя">
<input required type="text" name="surname" placeholder="Фамилия">
<input required type="password" name="password" placeholder="password">
<input type="submit" name="sub" value="enter">
</form>
<a href="${site_url}/modules/auth.php">Авторизация</a>
</body>
HTML;
} else {
    header("Location:" . $site_url);
}