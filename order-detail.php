<?php
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];

        $ordersor = $db->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $ordersor->execute(['order_id' => $order_id]);
        $ordercek = $ordersor->fetch(PDO::FETCH_ASSOC);

    } else {
        echo "Sipariş ID tanımlanmamış!";
        header("Location: order.php");
        exit();
    }
}
$order_id = $ordercek['order_id'];
?>

<main class="container my-5">

    <div class="row shadow border rounded-4">

        <div class="col-sm-12 col-lg-3 p-3 border-end">
            <a href="profile.php"><h5>Profil</h5></a>
            <hr>
            <a href="orders.php"><h5 class="fw-bold">Siparişlerim</h5></a>
            <hr>
            <a href="#"><h5>Kampanyalarım</h5></a>
            <hr>
            <a class="text-danger" href="logout.php"><h5>Çıkış Yap</h5></a>
        </div>

        <div class="col-sm-12 col-lg-9 p-5">
            <h3 class="mb-4">Siparişlerim</h3>

            Henüz bir siparişiniz bulunmuyor.


            <div class="row border bg-white my-3 p-3 rounded-3 shadow-sm">
                <div class="col-6 mb-3">Sipariş No: <span
                            class="text-success">#SIP<?php echo $ordercek['order_id'] ?></span></div>
                <div class="col-6 mb-3 text-end text-black-50">Hazırlanıyor</div>
                <div class="col-sm-12 col-lg-4"><?php echo $ordercek['order_date'] ?></div>
                <div class="col-sm-12 col-lg-5 text-center">Kullanılan Kampanya</div>
                <div class="col-sm-12 col-lg-3 text-end">
                    <p class="text-decoration-line-through lh-1"><?php echo $ordercek['order_oldtotal'] ?> ₺</p>
                    <p class="lh-1 fs-3"><?php echo $ordercek['order_total'] ?> ₺</p>
                </div>


                <table class="table table-borderless table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Ürün Adı</th>
                        <th scope="col">Yazarı</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Fiyat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($order_id != '') {
                        $urunlerSorgu = $db->prepare("SELECT products.*, categories.category_title, orderdetails.quantity FROM orderdetails
                            INNER JOIN products ON orderdetails.product_id = products.product_id
                            INNER JOIN categories ON products.category_id = categories.category_id
                            WHERE orderdetails.order_id = :order_id");
                        $urunlerSorgu->execute(['order_id' => $order_id]);
                        $urunler = $urunlerSorgu->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($urunler as $urun) {
                            ?>
                            <tr>
                                <td><?php echo $urun['title'] ?></td>
                                <td><?php echo $urun['author'] ?></td>
                                <td><?php echo $urun['category_title'] ?></td>
                                <td><?php echo "(x" . $urun['quantity'] . ") " . number_format($urun['list_price'], 2) ?> ₺</td>
                            </tr>
                            <?php
                        }
                    } else {
                        // order_id değeri geçerli değilse, hata mesajı veya başka bir işlem yapabilirsiniz
                        echo '<tr><td colspan="4">Geçerli bir sipariş seçilmedi.</td></tr>';
                    }
                    ?>

                    </tbody>

                </table>


            </div>

        </div>

    </div>

</main>


<?php require_once 'footer.php'; ?>
