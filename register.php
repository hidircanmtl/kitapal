<?php error_reporting(0);
require_once 'adminpanel/utilities/connect.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KİTAP AL Kayıt Ol</title>
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
                } else if($_GET['durum'] == "mukerrerkayit"){
                    echo "<div class='alert alert-danger'>Önceden kayıt olmuş kullanıcı</div>";
                }else if($_GET['durum'] == "eksiksifre"){
                    echo "<div class='alert alert-danger'>Şifreniz en az 6 karakter içermelidir</div>";
                }else if($_GET['durum'] == "farklisifre"){
                    echo "<div class='alert alert-danger'>Girdiğiniz iki şifre birbirinden farklıdır</div>";
                }
                ?>
                <form action="adminpanel/utilities/operations.php" method="post">
                    <h1 class="text-center mb-4">Kayıt Ol</h1>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input name="username" required type="text" class="form-control" id="adsoyad" placeholder="Ad - Soyad">
                                <label for="adsoyad">Ad - Soyad</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input name="phone" required type="number" class="form-control" id="telefon" placeholder="Telefon">
                                <label for="telefon">Telefon</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input name="email" required type="email" class="form-control" id="eposta" placeholder="E-Posta">
                                <label for="eposta">E-Posta</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input name="password" required type="password" class="form-control" id="parola" placeholder="Şifre">
                                <label for="parola">Şifre</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input name="passwordtwo" required type="password" class="form-control" id="sifre" placeholder="Şifre Tekrar">
                                <label for="sifre">Şifre Tekrar</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input required class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    Kullanım Koşulları'nı okudum, onaylıyorum.
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="register" class="btn btn-outline-secondary w-100">Kayıt Ol</button>
                </form>
                <div class="mt-3">Hesabın var mı? <a class="fw-bold text-dark" href="login.php">Giriş Yap</a></div>
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