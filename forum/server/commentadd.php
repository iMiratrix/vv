<?php
session_start();
require '../server/config.php';

if (isset($_SESSION['id'])) {
    if (isset($_POST['sub'])) {
        if (!empty($_POST['comment_text'])) {
            $comment = $_POST['comment_text'];
            $id_user = $_SESSION['id_user'];
            $id_theme = $_POST['id'];
            $today = date("Y-m-d H:i:s");
            $stmt = $pdo->prepare("INSERT INTO `comments` (`id_theme`,`id_user`,`comment_text`,`date`) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_theme, $id_user, $comment, $today]);
            if ($stmt == 1) {
                header("Location:" . $site_url . "/modules/themeshow.php?id=" . $id_theme);
            } else {
                header("Location:" . $site_url . "/modules/themeshow.php?id=" . $id_theme . "&error=0");
            }
        } else {
            $id_theme = $_POST['id'];
            header("Location:" . $site_url . "/modules/themeshow.php?id=" . $id_theme . "&error=1");
        }
    } else {
        header("Location:" . $site_url);
    }
} else {
    header("Location:" . $site_url);
}