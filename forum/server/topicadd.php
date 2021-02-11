<?php
session_start();
require 'config.php';
if (isset($_SESSION['id'])) {
    if (isset($_POST['sub'])) {
        $title = ucfirst($_POST['title']);
        $text = $_POST['text'];
        $user_id = $_SESSION['id_user'];
        $today = date("Y-m-d H:i:s");
        if (!empty($title) & !empty($text)) {
            $stmt = $pdo->prepare("INSERT INTO `themes` (`id_user`,`title`,`text`,`date`,`status`) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $title, $text, $today, 0]);
            if ($stmt) {
                header("Location:" . $site_url . "/modules/themeadd.php?done=done");
            } else {
                header("Location:" . $site_url . "/modules/themeadd.php?errors=true");
            }
        } else {
            header("Location:" . $site_url . "/modules/themeadd.php?errors=true");
        }
    } else {
        header("Location:" . $site_url);
    }
} else {
    header("Location:" . $site_url);
}