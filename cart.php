<?php
require_once 'header.php';

error_reporting(0);
?>

<main class="container mb-5">
    <div class="row">

        <div class="col-sm-12 col-lg-7 mt-5">
            <h4 class="text-danger">
                200₺ ve üzeri alışverişinizde kargo bedava!
            </h4>
            <?php
            $sepetsor = $db->prepare("SELECT cart.*, products.title, products.list_price, products.stock_quantity FROM cart 
                INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = :user_id");
            $sepetsor->execute(['user_id' => $user_id]);
            while ($sepetcek = $sepetsor->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="row align-items-center shadow p-3 border rounded-4 mb-3">
                    <h5 class="col-sm-8 col-lg-4"><?php echo $sepetcek['title']; ?></h5>
                    <div class="col-sm-4 col-lg-3 d-flex justify-content-end">
                        <div class="product-artaz">
                            <form action="adminpanel/utilities/cart.php" method="post">
                                <button type="submit" name="decrease" class="btn btn-primary">-</button>
                                <span class="count-artaz-<?php echo $sepetcek['cart_id']; ?> mx-2">
                                    <?php echo $sepetcek['quantity']; ?>
                                </span>
                                <button type="submit" name="increase" class="btn btn-primary">+</button>
                                <input type="hidden" name="cart_id" value="<?php echo $sepetcek['cart_id']; ?>">
                            </form>
                        </div>
                    </div>
                    <h5 class="col-sm-4 col-lg-3 text-center">
                        <?php echo number_format($sepetcek['list_price'] * $sepetcek['quantity'], 2); ?> ₺
                    </h5>
                    <a href="adminpanel/utilities/cart.php?cart_id=<?php echo $sepetcek['cart_id']; ?>&cartsil=ok"
                       class="col-sm-4 col-lg-2 text-center">
                        <button class="btn bg-danger"><i class="bi bi-trash text-white"></i></button>
                    </a>
                </div>
            <?php } ?>


        </div>

        <div class="col-sm-12 col-lg-1"></div>

        <div class="col-sm-12 col-lg-4">
            <div class="shadow p-3 px-5 border rounded-4 mt-5 mb-3">
                <h4 class="text-center">Sipariş</h4>
                <hr>

                <?php
                $sepetsor = $db->prepare("SELECT cart.*, products.title, products.list_price, products.stock_quantity FROM cart 
                    INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = :user_id");
                $sepetsor->execute(['user_id' => $user_id]);
                $total_amount = 0;
                while ($sepetcek = $sepetsor->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <p><?php echo $sepetcek['title'] . " (" . $sepetcek['quantity'] . "x)"; ?></p>
                        </div>
                        <div class="text-end">
                            <p> <?php echo number_format($sepetcek['list_price'] * $sepetcek['quantity'], 2); ?>
                                ₺</p>
                        </div>
                    </div>
                    <?php
                    $total_amount += $sepetcek['list_price'] * $sepetcek['quantity'];
                }

                $kargosor = $db->prepare("select * from cart");
                $kargosor->execute();
                $kargocek = $kargosor->fetch(PDO::FETCH_ASSOC);

                $shipping_cost = 0;
                if ($total_amount < 200) {
                    $shipping_cost = $kargocek['shipping_count'];
                    $remainingAmount = 200 - $total_amount;
                    ?>
                    <div class="alert alert-warning mt-3">
                        Kargo bedava olması için <?php echo $remainingAmount; ?>₺ daha ekleyin.
                    </div>
                <?php } ?>

                <div class="d-flex justify-content-between text-black-50">
                    <div class="text-start">
                        <p>Kargo ücreti</p>
                    </div>
                    <div class="text-end">
                        <p><?php echo $shipping_cost; ?> ₺</p>
                    </div>
                </div>

                <?php
                $bookamount = 0;
                $bookprice = PHP_FLOAT_MAX;

                $kitapsor = $db->prepare("SELECT cart.*, products.title, products.list_price FROM cart 
                    INNER JOIN products ON cart.product_id = products.product_id 
                    WHERE cart.user_id = :user_id AND products.author = 'Sabahattin Ali'");
                $kitapsor->execute(['user_id' => $user_id]);

                while ($kitapcek = $kitapsor->fetch(PDO::FETCH_ASSOC)) {
                    $bookamount += $kitapcek['quantity'];
                    if ($kitapcek['list_price'] < $bookprice) {
                        $bookprice = $kitapcek['list_price'];
                    }
                }

                $campaignusedsor = $db->prepare("SELECT * FROM campaignused WHERE user_id = :user_id");
                $campaignusedsor->execute(['user_id' => $user_id]);
                $campaignusedcek = $campaignusedsor->fetchAll(PDO::FETCH_ASSOC);

                $campaignsor = $db->prepare("SELECT * FROM campaigns");
                $campaignsor->execute();
                $allcampaigns = $campaignsor->fetchAll(PDO::FETCH_ASSOC);

                $sepetindirim = 0;
                $yuzdesonuc = 0;
                $selectedCampaign = null;

                foreach ($allcampaigns as $campaign) {
                    if ($campaign['campaign_title'] === '100 TL ve Üzeri Alışverişlerde %5 İndirim') {
                        $sepetindirim = $campaign['campaign_value'];
                    } elseif ($campaign['campaign_title'] === 'Sabahattin Ali Romanlarında 2 Üründen 1 Bedava!' && $bookamount >= 2) {
                        $selectedCampaign = $campaign;
                        break;
                    }
                }

                if (count($campaignusedcek) === 2) {
                    // Her iki kampanya da kullanılmış
                    $kampanyaAdi = 'Kampanya Kullanıldı';
                    $amount = $total_amount + $shipping_cost;
                } elseif ($selectedCampaign !== null && !in_array($selectedCampaign['campaign_id'], array_column($campaignusedcek, 'campaign_id'))) {
                    $kampanyaAdi = $selectedCampaign['campaign_title'];
                    $amount = $total_amount + $shipping_cost - $bookprice;
                } elseif ($total_amount > 100 && !in_array($sepetindirim, array_column($campaignusedcek, 'campaign_id'))) {
                    $totalamount = $total_amount * (1 - $sepetindirim);
                    $yuzdesonuc = $total_amount * $sepetindirim;
                    $kampanyaAdi = '100 TL ve Üzeri Alışverişlerde %5 İndirim';
                    $amount = $total_amount + $shipping_cost - $yuzdesonuc;
                } else {
                    $kampanyaAdi = 'Uygun Kampanyanız Yok';
                    $amount = $total_amount + $shipping_cost;
                }
                ?>

                <hr class="mt-4">
                <div class="d-flex justify-content-between">
                    <div class="text-start">
                        <p>Toplam</p>
                    </div>
                    <div class="text-end">
                        <h4>
                            <?php echo number_format($amount, 2); ?> ₺
                        </h4>
                    </div>
                </div>

                <div class="rounded-4 py-4 px-4 shadow">
                    <span class="fw-bold">Sizin İçin En Uygun Kampanya:<br></span>
                    <span><?php echo $kampanyaAdi; ?></span>
                </div>

                <form action="adminpanel/utilities/cart.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="campaign_id" value="<?php
                    $campaignTitle = $kampanyaAdi;
                    $campaignsor = $db->prepare("SELECT campaign_id FROM campaigns WHERE campaign_title = :campaign_title");
                    $campaignsor->execute(['campaign_title' => $campaignTitle]);
                    $campaigncek = $campaignsor->fetch(PDO::FETCH_ASSOC);

                    if ($campaigncek) {
                        echo $campaigncek['campaign_id'];
                    }
                    ?>">
                    <input type="hidden" name="order_oldtotal" value="<?php echo number_format($total_amount+$shipping_cost, 2); ?>">
                    <input type="hidden" name="order_total" value="<?php echo number_format($amount, 2) ?>">
                    <input type="submit" name="submitcart" value="Sepeti Onayla"
                           class="btn btn-success rounded-4 fs-4 w-100 shadow mt-4 py-2">
                </form>
            </div>

        </div>


    </div>
</main>

<?php require_once 'footer.php' ?>
