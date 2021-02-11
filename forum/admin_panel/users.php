<?php
session_start();
require '../server/config.php';

if (isset($_SESSION['id'])) {
    print "<a href='$site_url/modules/themes.php'>Главная</a><br>";
    print "<a href='$site_url/server/logout.php'>Выйти из записи</a><br>
<a href='$site_url/admin_panel/admin.php'>Назад</a><br>";
    $stmt = $pdo->prepare("SELECT * FROM users where permission = ? OR permission = ?");
    $stmt->execute([1, 2]);
    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            switch ($data['permission']) {
                case 0:
                    $permission = "Админ";
                    break;
                case 1:
                    $permission = "Пользователь";
                    break;
                case 2:
                    $permission = "Заблокирован";
                    break;
            }
            echo <<<HTML
<head>
<title>Пользователи</title>
</head>
<body>
<p>Почта: ${data['email']}</p>
<p>Имя: ${data['name']}</p>
<p>Фамилия: ${data['surname']}</p>
<p>Зарегистрирован: ${data['date_reg']}</p>
<p>Статус: ${permission}</p>
<p>id=${data['id_user']}</p>

<form action="" method="post">
<input type="hidden" name="id_user" value="${data['id_user']}">
<input type="submit" value="Разблокировать" name="accept">
<input type="submit" value="Блокировать" name="reject">
</form>


HTML;

        }
        if (isset($_POST['reject'])) {
            $stmt = $pdo->prepare("UPDATE `users` SET `permission` = 2 WHERE `id_user` = ?");
            $stmt->execute([$_POST['id_user']]);
            print "Пользователь заблокирован <a href='$site_url/admin_panel/users.php'>Назад</a>";

        }
        if (isset($_POST['accept'])) {
            $stmt = $pdo->prepare("UPDATE `users` SET `permission` = 1 WHERE `id_user` = ?");
            $stmt->execute([$_POST['id_user']]);
            print "Пользователь разблокирован <a href='$site_url/admin_panel/users.php'>Назад</a>";

        }

    } else {
        print"<p>Нет пользователей</p>";
    }
} else {
    header("Location:" . $site_url);
}
