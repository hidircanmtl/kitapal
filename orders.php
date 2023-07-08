<?php
require_once 'header.php';
?>

<main class="container my-5">

    <div class="row shadow border rounded-4">

        <div class="col-sm-12 col-lg-3 p-3 border-end">
            <a href="profile.php"><h5>Profil</h5></a>
            <hr>
            <a href="orders.php"><h5 class="fw-bold">Siparişlerim</h5></a>
            <hr>
            <a href="campaigns.php"><h5>Kampanyalarım</h5></a>
            <hr>
            <a class="text-danger" href="logout.php"><h5>Çıkış Yap</h5></a>
        </div>

        <div class="col-sm-12 col-lg-9 p-5">
            <h3 class="mb-4">Siparişlerim</h3>

            <?php
            $siparissor=$db->prepare("select * from orders where user_id=:user_id order by order_date DESC");
            $siparissor->execute(['user_id'=>$user_id]);
            if ($siparissor->rowCount() > 0) {
            while ($sipariscek = $siparissor->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="row bg-white border my-3 p-3 rounded-3 shadow-sm">
                <div class="col-6 mb-3">Sipariş No: <span class="text-success">#SIP<?php echo $sipariscek['order_id'] ?></span></div>
                <div class="col-6 mb-3 text-end text-black-50">Hazırlanıyor</div>
                <form action="order-detail.php" method="post" class="col-sm-12 col-lg-2">
                    <input type="hidden" name="order_id" value="<?php echo $sipariscek['order_id']?>">
                    <button class="btn btn-success" type="submit">Detay</button>
                </form>

                <div class="col-sm-12 col-lg-3 text-center"><?php echo $sipariscek['order_date'] ?></div>
                <div class="col-sm-12 col-lg-5 text-center">
                    <?php
                    if ($sipariscek['campaign_id']) {
                        $campaignsor = $db->prepare("SELECT campaign_title FROM campaigns WHERE campaign_id = :campaign_id");
                        $campaignsor->execute(['campaign_id' => $sipariscek['campaign_id']]);
                        $campaigncek = $campaignsor->fetch(PDO::FETCH_ASSOC);
                        echo $campaigncek['campaign_title'];
                    } else {
                        echo "Kullanılan Kampanya Yok";
                    }
                    ?>
                </div>
                <div class="col-sm-12 col-lg-2 text-end">
                    <p class="text-decoration-line-through lh-1"><?php echo $sipariscek['order_oldtotal'] ?> ₺</p>
                    <p class="lh-1 fs-3"><?php echo $sipariscek['order_total'] ?> ₺</p>
                </div>
            </div>
            <?php } } else { echo "Henüz bir siparişiniz bulunmuyor."; } ?>

        </div>

    </div>

</main>


<?php require_once 'footer.php'; ?>
