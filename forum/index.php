<?php
session_start();
require "server/config.php";

if (isset($_SESSION['id'])) {
    header("Location:" . $site_url . "/modules/themes.php");

} else {
    header("Location:" . $site_url . "/modules/auth.php");
}
