<?php
session_start();

if (isset($_SESSION['id'])) {
    session_destroy();
    header("Location:" . $site_url . "/modules/themes.php");

} else {
    session_destroy();
    header("Location:" . $site_url . "/modules/themes.php");
}