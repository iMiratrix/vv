<?php
session_start();
require '../server/config.php';

if (isset($_SESSION['id'])) {
    print "<a href='$site_url/modules/themes.php'>Главная</a><br>";
    print "<a href='$site_url/server/logout.php'>Выйти из записи</a><br>
<a href='$site_url/admin_panel/users.php'>Пользователи</a>";
    $stmt = $pdo->prepare("SELECT * FROM users INNER JOIN themes ON users.id_user = themes.id_user AND themes.status = ?");
    $stmt->execute([0 | $_POST['sort']]);
    print "<h1>Темы:</h1>";
    echo <<<HTML
<form action="" method="post">
<select  class="form-control" name="sort">
<option selected="selected">Sort</option>
 <option value="0">Ожидают модерацию</option>
 <option value="1">Одобрено</option>
 <option value="2">Отклонено</option>
</select>
<input type="submit" value="Сортировка">
</form>
HTML;
    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            switch ($data['status']) {
                case 1:
                    $hidden = "hidden";
                    break;
                case 2:
                    $hidden = "hidden";
                    break;
            }
            echo <<<HTML
<head>
<title>Тема</title>
</head>
<body>
<h1>${data['title']}</h1>
<p>${data['text']}</p>
<p>Создал: ${data['name']} ${data['surname']} ${data['date']}</p>
<p>id=${data['id_theme']}</p>

<form action="" method="post" style="visibility: ${hidden}">
<input type="hidden" name="id_theme" value="${data['id_theme']}">
<input type="submit" value="Принять" name="accept">
<input type="submit" value="Отклонить" name="reject">
</form>


HTML;
        }
        if (isset($_POST['reject'])) {
            $stmt = $pdo->prepare("UPDATE `themes` SET `status` = 2 WHERE `id_theme` = ?");
            $stmt->execute([$_POST['id_theme']]);
            print "Запись отклонена <a href='$site_url/admin_panel/admin.php'>Назад</a>";
        }
        if (isset($_POST['accept'])) {
            $stmt = $pdo->prepare("UPDATE `themes` SET `status` = 1 WHERE `id_theme` = ?");
            $stmt->execute([$_POST['id_theme']]);
            print "Запись одобрена <a href='$site_url/modules/themeshow.php?id=${_POST['id_theme']}'>Просмотреть</a><br>
            <a href='$site_url/admin_panel/admin.php'>Назад</a>";
        }

    } else {
        print"<p>Нет тем</p>";
    }
} else {
    header("Location:" . $site_url);
}
