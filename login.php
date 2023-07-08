<?php error_reporting(0);
ob_start();
session_start();

require_once 'adminpanel/utilities/connect.php';

// Oturum kontrolü
if (isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KİTAP AL Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>



<div class="container-fluid">
    <div class="row">

        <div class="col-md-1 d-none d-md-flex"></div>
        <div class="col-sm-12 col-md-3 d-flex align-items-center" style="height: 100vh;">
            <div class="mx-auto">
                <?php
                if ($_GET['durum'] == "ok") {
                    echo "<div class='alert alert-success'>İşlem Başarılı</div>";
                } else if($_GET['durum'] == "basarisizgiris"){
                    echo "<div class='alert alert-danger'>Parola veya E-Posta hatalı</div>";
                }
                else if($_GET['durum'] == "loginbasarili"){
                    echo "<div class='alert alert-success'>Kayıt başarılı. Lütfen giriş yapın.</div>";
                }
                ?>
                <form method="post" action="adminpanel/utilities/operations.php">
                    <h1 class="text-center mb-4">Giriş Yap</h1>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="email" required name="email" class="form-control" id="eposta" placeholder="E-Posta">
                                <label for="eposta">E-Posta</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="password" required name="password" class="form-control" id="parola" placeholder="Parola">
                                <label for="parola">Parola</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="login" class="btn btn-outline-secondary w-100">Giriş Yap</button>
                </form>
                <div class="mt-3">Hesabın yok mu? <a class="fw-bold text-dark" href="register.php">Hesap Oluştur</a></div>
            </div>
        </div>

        <div class="col-md-1 d-none d-md-flex"></div>

        <div class="col-md-7 bg-primary d-none d-md-flex align-items-center justify-content-center">
            <a href="index.php" class="text-white fs-1">KİTAP AL</a>
        </div>

    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>