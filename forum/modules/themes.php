<?php
session_start();
require "../server/config.php";
if (isset($_SESSION['id'])) {
    if ($_SESSION['id'] == 0) {
        print "<a href='$site_url/admin_panel/admin.php'>Админ панель<a><br>";
        print "<a href='$site_url/server/logout.php'>Выйти из записи<br></a>";
    } else {
        print "<a href='$site_url/modules/person.php'>Мои темы (${_SESSION['email']}) <a><br>";
        print "<a href='$site_url/server/logout.php'>Выйти из записи<br></a>";
    }
}
$stmt = $pdo->prepare("SELECT n.*, COALESCE(cnt, 0) as cmtcnt
                                       FROM themes n
                                       LEFT JOIN
                                      (SELECT id_theme, COUNT(id_comment) as cnt
                                       FROM comments
                                       GROUP BY id_theme) as ct
                                       ON n.id_theme = ct.id_theme
                                       WHERE n.status=?");
$stmt->execute([1]);
if ($stmt->rowCount() > 0) {
    print "<h1>Темы:</h1>";
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $text = mb_substr($data['text'], 0, 10);
        echo <<<HTML
<head>
<title>Темы</title>
</head>
<body>
<a href="${site_url}/modules/themeshow.php?id=${data['id_theme']}"><h2>${data['title']}</h2>${text}</a><br>
<p>Колличество комментариев: ${data['cmtcnt']}</p>
<hr>
</body> 

HTML;
    }
    if (isset($_SESSION['id'])) {

        if ($_SESSION['id'] == 2) {
            print "Вы заблокированы";
        } else {
            print "<br><a href='$site_url/modules/themeadd.php'>Добавить</a>";
        }
    } else {
        print "<br><a href='$site_url/modules/auth.php'>Авторизуйтесь, чтобы добавить тему</a>";
    }


} else {
    print "Тем нет  <a href='$site_url/modules/auth.php'>Авторизуйтесь, чтобы добавить тему</a>";
}

