<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location:../../login.php");
    exit;
}

// Kullanıcı adı ve parolayı kontrol etmek için değiştirilmesi gereken değerler
$admin_username = "admin@kitapal";
$admin_password = "Kitapal99..";

$current_page = basename($_SERVER['PHP_SELF']);

if ($_SESSION['email'] != $admin_username && strpos($_SERVER['REQUEST_URI'], "adminpanel/include") !== false) {
    header("Location:../../login.php");
    exit;
}

if ($_SESSION['email'] != $admin_username && $current_page == "include.php") {
    header("Location:../../login.php");
    exit;
}
