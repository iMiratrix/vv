<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    if (isset($_POST['sub'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $today = date("Y-m-d H:i:s");
        if (!empty($email) && !empty($password) && !empty($name) && !empty($surname)) {
            $sql_check = 'SELECT EXISTS(SELECT `email` FROM `users`  WHERE email = ?)';
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$email]);
            if ($stmt_check->fetchColumn()) {
                print("Такая почта уже используется<br><a href='${site_url}/modules/reg.php'>Назад</a>");
                die();
            }
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO `users` (`email`, `password`, `name`, `surname`, `date_reg`, `permission`) VALUES(?, ?, ?, ?, ?, ?)';
            $params = [$email, $password, $name, $surname, $today, 1];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            if ($stmt->rowCount() > 0) {
                header("Location:" . $site_url);
            }
        } else {
            print("Заполните поля<br><a href='${site_url}/modules/reg.php'>Назад</a>");
        }
    }
} else {
    header("Location:" . $site_url);
}

