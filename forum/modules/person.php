<?php
session_start();
require '../server/config.php';
print "<a href='$site_url/modules/themes.php'>Главная</a><br>";
print "<br><a href='$site_url/modules/themeadd.php'>Добавить тему</a>";
if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM themes WHERE id_user = ?");
    $stmt->execute([$_SESSION['id_user']]);
    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            switch ($data['status']) {
                case 0:
                    $status = "На модерации";
                    break;
                case 1:
                    $status = "Одобрена";
                    break;
                case 2:
                    $status = "Отклонена";
                    break;
            }
            echo <<<HTML
<head>
<title>Тема</title>
</head>
<body>
<h1>${data['title']}</h1>
<p>${data['text']}</p>
<p>Создана: ${data['name']} ${data['surname']} ${data['date']}</p>
<p>Статус: ${status}</p>
<hr>

HTML;
        }
    }else{
        print "Нет тем <a href='$site_url/modules/themeadd.php'>Создать</a><br>";
    }
} else {
    header("Location:" . $site_url);
}