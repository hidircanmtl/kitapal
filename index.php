<?php
require_once 'header.php';
?>
    <main class="container my-5">
        <div class="row">

            <?php
            $urunsor = $db->prepare("select * from products");
            $urunsor->execute();
            while ($uruncek = $urunsor->fetch(PDO::FETCH_ASSOC)) {
                if ($uruncek['stock_quantity'] > 0) {
                    ?>
                    <div class="col-sm-12 col-lg-4 mb-4">
                        <div class="card shadow rounded-4">
                            <h4 class="card-header bg-primary text-white">
                                <?php echo $uruncek['title'] ?>
                                <p class="text-white-50 text-end">-<?php echo $uruncek['author'] ?></p>
                                <p><?php echo $uruncek['stock_quantity'] ?> adet stokta</p>
                            </h4>
                            <div class="card-body">
                                <div class="row">
                                    <h3 class="col-6 shadow-inline text-primary d-flex align-items-center">
                                        <div><?php echo number_format($uruncek['list_price'], 2) ?> ₺</div>
                                    </h3>
                                    <h3 class="col-6 d-flex justify-content-end">
                                        <form action="adminpanel/utilities/cart.php" method="post">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                                            <input type="hidden" name="product_id" value="<?php echo $uruncek['product_id']?>">
                                            <button name="addcart" class="btn bg-warning p-2 px-3 rounded">
                                                <i class="bi bi-cart2 text-white fs-4"></i>
                                            </button>
                                        </form>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>

        </div>
    </main>

<?php require_once 'footer.php' ?>