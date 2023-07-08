<?php
require_once 'header.php';
?>

<main class="container my-5">

    <div class="row shadow border rounded-4">

        <div class="col-sm-12 col-lg-3 p-3 border-end">
            <a href="profile.php"><h5>Profil</h5></a>
            <hr>
            <a href="orders.php"><h5>Siparişlerim</h5></a>
            <hr>
            <a href="campaigns.php"><h5 class="fw-bold">Kampanyalarım</h5></a>
            <hr>
            <a class="text-danger" href="logout.php"><h5>Çıkış Yap</h5></a>
        </div>

        <div class="col-sm-12 col-lg-9 p-5">
            <h3 class="mb-4">Kampanyalarım</h3>

            <?php
            $campsor = $db->prepare("SELECT c.*, cu.campaignused_id FROM campaigns c LEFT JOIN campaignused cu ON c.campaign_id = cu.campaign_id AND cu.user_id = :user_id");
            $campsor->execute(['user_id' => $user_id]);

            while ($campcek = $campsor->fetch(PDO::FETCH_ASSOC)) {
                $used = !empty($campcek['campaignused_id']);

                ?>
                <div class="row bg-white border my-3 p-3 rounded-3 shadow-sm">
                    <div class="col-sm-12 col-lg-1
                     <?php echo $used ? "bg-danger" : "bg-success"; ?>
                     text-center"></div>
                    <div class="col-sm-12 col-lg-7 text-center"><?php echo $campcek['campaign_title'] ?></div>
                    <div class="col-sm-12 col-lg-4 text-center">
                        <?php echo $used ? "<span class='text-danger'>Kullanıldı</span>" : "<span class='text-success'>Kullanılmadı</span>"; ?>
                    </div>
                </div>
            <?php } ?>


        </div>

    </div>

</main>


<?php require_once 'footer.php'; ?>
