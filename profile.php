<?php
require_once 'header.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
?>

<main class="container my-5">

    <div class="row shadow rounded-4">

        <div class="col-sm-12 col-lg-3 p-3 border-end">
            <a href="profile.php"><h5 class="fw-bold">Profil</h5></a>
            <hr>
            <a href="orders.php"><h5>Siparişlerim</h5></a>
            <hr>
            <a href="campaigns.php"><h5>Kampanyalarım</h5></a>
            <hr>
            <a class="text-danger" href="logout.php"><h5>Çıkış Yap</h5></a>
        </div>

        <div class="col-sm-12 col-lg-9 p-5">
            <div class="row">
                <h3 class="col-12 mb-4">Profil Bilgileri</h3>

                <div class="col-5 mb-3">Ad-Soyad</div>
                <div class="col-5 mb-3">: <?php echo $username ?></div>
                <div class="col-5 mb-3">Telefon</div>
                <div class="col-5 mb-3">: <?php echo $phone ?></div>
                <div class="col-5 mb-3">E - Posta</div>
                <div class="col-5 mb-3">: <?php echo $email ?></div>

            </div>

        </div>

    </div>

</main>


<?php require_once 'footer.php'; ?>
