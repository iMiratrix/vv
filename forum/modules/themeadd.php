<?php
session_start();
require '../server/config.php';
if (isset($_SESSION['id'])) {
    print "<a href='$site_url/modules/themes.php'>Главная</a><br>";
    if ($_SESSION['id'] == 0) {
        print "<a href='$site_url/admin_panel/admin.php'>Админ панель<a><br>";
    } else {
        print "<a href='$site_url/modules/person.php'>Мои темы (${_SESSION['email']}) <a><br>";
    }

    //print "<a href='$site_url/server/logout.php'>Выйти из записи</a><br>";

    echo <<<HTML
<head>
<title>Добавить тему</title>
</head>
<body>
<form action="${site_url}/server/topicadd.php" method="post">
<input type="text" name="title" placeholder="Заголовок"><br>
<textarea name="text" id="" cols="30" rows="10" placeholder="Введите текст"></textarea>
<input type="submit" value="Добавить" name="sub">
</form>
</body>
HTML;
    if (isset($_GET['done'])) {
        print "Запись на модерации <a href='$site_url/modules/themes.php'>Назад</a>";
    }
    if (isset($_GET['errors'])) {
        print 'Заполните поля';
    }

} else {
    header("Location:" . $site_url);
}
