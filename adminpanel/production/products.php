<?php
require_once 'header.php';
?>


<main class="container mb-5">
    <div class="row">

        <div class="col-12 my-5">
            <?php
            if ($_GET['durum'] == "ayniurun") {
                echo "<div class='alert alert-danger'>Aynı ürünleri yüklemeye çalıştınız. Lütfen 'product_id' kontrol edin.</div>";
            } elseif ($_GET['durum'] == "silindi"){
                echo "<div class='alert alert-success'>Silme işlemi başarılı.</div>";
            }
            ?>
            <form class="row" method="POST" action="products-add-json.php" enctype="multipart/form-data">
                <h3 class="my-3">.json ile Ürün Eklemesi Yapın</h3>
                <div class="col-6 input mb-3">
                    <input type="file" name="json_file" accept=".json" required class="form-control">
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </div>
            </form>
        </div>

        <div class="col-12 my-5">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Başlık</th>
                    <th scope="col">Yazar</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Fiyat</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $urunsor = $db->prepare("select products.*, categories.category_title
                        from products inner join categories on products.category_id = categories.category_id
                        order by products.product_id ASC");
                $urunsor->execute();
                while ($uruncek = $urunsor->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <th scope="row">#<?php echo $uruncek['product_id'] ?></th>
                        <td><?php echo $uruncek['title'] ?></td>
                        <td><?php echo $uruncek['author'] ?></td>
                        <td><?php echo $uruncek['category_title'] ?></td>
                        <td><?php echo number_format($uruncek['list_price'], 2) ?> ₺</td>
                        <td><?php echo $uruncek['stock_quantity'] ?></td>
                        <td>
                            <a href="../utilities/operations.php?product_id=<?php echo $uruncek['product_id']; ?>&urunsil=ok"
                               class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>

    </div>
</main>


<?php require_once 'footer.php'?>
