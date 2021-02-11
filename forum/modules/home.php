<?php
//session_start();
//require "../server/config.php";
//
//if (isset($_SESSION['id'])) {
//    if ($_SESSION['id'] == 5) {
//        print "<a href='$site_url/admin_panel/admin.php'>Админ панель<a>";
//    } else {
//        print "<a href='$site_url/modules/person.php'>Личный кабинет<a>";
//    }
//    $stmt = $pdo->prepare("SELECT * FROM `sections`");
//    $stmt->execute();
//    if ($stmt->rowCount() > 0) {
//        print "<br><a href='$site_url/server/logout.php'>Выйти из записи</a>";
//        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            echo <<<HTML
//<head>
//<title>Разделы</title>
//</head>
//<body>
//<a href="themes.php?id=${data['id_section']}"><br>${data['name']}</a>
//</body>
//HTML;
//        }
//    } else {
//        print "Нет разделов";
//    }
//
//} else {
//    header("Location:" . $site_url);
//}