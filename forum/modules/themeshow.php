<?php
session_start();
require "../server/config.php";
print "<a href='$site_url/modules/themes.php'>Главная</a><br>";
if (isset($_SESSION['id'])) {

    if ($_SESSION['id'] == 0) {
        print "<a href='$site_url/admin_panel/admin.php'>Админ панель<a><br>";
        print "<a href='$site_url/server/logout.php'>Выйти из записи<br></a>";
    } else {
        print "<a href='$site_url/modules/person.php'>Мои темы (${_SESSION['email']}) <a><br>";
        print "<a href='$site_url/server/logout.php'>Выйти из записи<br></a>";
    }
}

if (isset($_GET['id']) & is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    //$stmt = $pdo->prepare("SELECT * FROM `themes` WHERE `id_theme` = ?");
    $stmt = $pdo->prepare("SELECT *FROM users INNER JOIN themes ON users.id_user = themes.id_user AND themes.id_theme = ? AND themes.status = 1");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo <<<HTML
<head>
<title>Тема</title>
</head>
<body>
<h1>${data['title']}</h1>
<p>${data['text']}</p>
<p>Создал: ${data['name']} ${data['surname']} ${data['date']}</p>

HTML;

        }
        // $stmt = $pdo->prepare("SELECT * FROM `comments` WHERE `id_theme` = ?");
        $stmt = $pdo->prepare("SELECT * FROM comments INNER JOIN users ON users.id_user = comments.id_user AND comments.id_theme = ? ORDER BY date DESC");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            print "<h1>Комментарии:</h1>";
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo <<<HTML
<p>Текст: ${data['comment_text']}</p>
<p>Оставил: ${data['name']} ${data['surname']} ${data['date']}</p>
HTML;
            }
        } else {
            print("Нет комментариев ");
        }
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 0) {
                print "400";
            }
            if ($_GET['error'] == 1) {
                print "Заполните поле";
            }
        }
        if (isset($_SESSION['id'])) {

            if ($_SESSION['id'] == 2) {
                print "Вы заблокированы";
            } else {
                echo <<<HTML
<form action="${site_url}/server/commentadd.php" method="post">
<textarea name="comment_text" id="" cols="30" rows="10" placeholder="Оставьте комментарий"></textarea>
<input type="hidden" name="id" value="${id}">
<input type="submit" name="sub" value="Отправить">
</form>
</body>
HTML;
            }
        } else {
            print "<br><a href='$site_url/modules/auth.php'>Авторизуйтесь, чтобы добавить комментарий</a>";
        }
    }
}