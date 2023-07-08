<?php
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];

        $ordersor = $db->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $ordersor->execute(['order_id' => $order_id]);
        $ordercek = $ordersor->fetch(PDO::FETCH_ASSOC);

        // Kullanıcı adını bulmak için user_id'yi kullanarak users tablosundan sorgulama yapalım
        $user_id = $ordercek['user_id'];
        $usersor = $db->prepare("SELECT username FROM users WHERE user_id = :user_id");
        $usersor->execute(['user_id' => $user_id]);
        $usercek = $usersor->fetch(PDO::FETCH_ASSOC);
        $username = $usercek['username'];
    } else {
        echo "Sipariş ID tanımlanmamış!";
        header("Location: order.php");
        exit();
    }
}
$order_id = $ordercek['order_id'];
?>


<main class="container mb-5">
    <div class="row">

        <h3 class="mt-4"><?php echo $username . " kullanıcısına ait " . "<span class='text-success'>#SIP" . $order_id . "</span>" ?> </h3>

        <div class="col-12 my-5">
            <table class="table table-hover">
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
                            <td><?php echo "(x" . $urun['quantity'] . ") " . number_format($urun['list_price'], 2) ?>
                                ₺
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // order_id değeri geçerli değilse, hata mesajı veya başka bir işlem yapabilirsiniz
                    echo '<tr><td colspan="4">Geçerli bir sipariş seçilmedi.</td></tr>';
                }
                ?>

                </tbody>
                <tfoot>
                    <td></td>
                </tfoot>

            </table>
        </div>

    </div>
</main>


<?php require_once 'footer.php' ?>
