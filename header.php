<?php
ob_start();
session_start();

require_once 'adminpanel/utilities/connect.php';

$usersor = $db->prepare("SELECT * FROM users WHERE email = :email");
$usersor->execute(['email' => $_SESSION['email']]);
$usercek = $usersor->fetch(PDO::FETCH_ASSOC);

$user_id = isset($usercek['user_id']) ? $usercek['user_id'] : '';
$username = isset($usercek['username']) ? $usercek['username'] : '';
$phone = isset($usercek['phone']) ? $usercek['phone'] : '';
$email = isset($usercek['email']) ? $usercek['email'] : '';
?>

<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KİTAP AL</title>

    <!-- Bootstrap Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">

</head>

<body>

<nav class="container hide-on-mobile hide-on-tablet navbar-desktop bg-primary kenarcizgi my-5 p-1 py-4">
    <div class="navbar-logo d-flex justify-content-center">
        <h1 class="ms-5"><a class="text-white" href="index.php">KİTAP AL</a></h1>
    </div>

    <ul class="navbar-menu me-4">
        <?php if (!empty($username)) { ?>
            <li>
                <span class="text-white">
                    Hoşgeldin, <a class="text-white fw-bold" href="profile.php"><?php echo $username; ?> <i class="bi bi-person-circle"></i></a>
                    <a class="text-white ms-5 fs-2" href="cart.php">
                        <i class="bi bi-cart2"></i>
                    </a>
                </span>
            </li>
        <?php } else { ?>
            <li>
                <a class="text-white" href="login.php">Giriş Yap / Kayıt Ol</a>
            </li>
        <?php } ?>
    </ul>
</nav>



<nav class="navbar-mobile navbar navbar-light bg-primary hide-on-desktop-lg">
    <div class="container">
        <div class="navbar-logo">
            <h1 class="ms-3"><a class="text-white" href="index.php">KİTAP AL</a></h1>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
                aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar"
             aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">KİTAP AL</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="login.php">Giriş Yap / Kayıt Ol</a>
                    </li>
                    <hr>

                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- Header Bitiş -->

