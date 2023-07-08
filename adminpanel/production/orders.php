<?php
require_once 'header.php';
?>


<main class="container mb-5">
    <div class="row">

        <div class="col-12 my-5">
            <?php
            if ($_GET['durum'] == "silindi") {
                echo "<div class='alert alert-success'>Kullanıcı silme işlemi başarılı.</div>";
            }
            ?>
        </div>

        <div class="col-12 my-5">
            <table id="datatable" class="table">
                <thead>
                <tr>
                    <th scope="col">Sipariş No</th>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Sipariş Tarihi</th>
                    <th scope="col">Kullandığı Kampanya</th>
                    <th scope="col">Sipariş Tutarı</th>
                    <th scope="col">İndirimsiz Sipariş Tutarı</th>
                    <th scope="col">Siparişe Git</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $ordersor = $db->prepare("SELECT * FROM orders ORDER BY order_date DESC ");
                $ordersor->execute();
                while ($ordercek = $ordersor->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <th scope="row">#SIP<?php echo $ordercek['order_id'] ?></th>
                        <td>
                            <?php
                            $user_id = $ordercek['user_id'];
                            $usersor = $db->prepare("SELECT username FROM users WHERE user_id = :user_id");
                            $usersor->execute(['user_id' => $user_id]);
                            $usercek = $usersor->fetch(PDO::FETCH_ASSOC);
                            echo $usercek['username'];
                            ?>
                        </td>
                        <td><?php echo $ordercek['order_date'] ?></td>
                        <td>
                            <?php
                            if ($ordercek['campaign_id']) {
                                $campaignsor = $db->prepare("SELECT campaign_title FROM campaigns WHERE campaign_id = :campaign_id");
                                $campaignsor->execute(['campaign_id' => $ordercek['campaign_id']]);
                                $campaigncek = $campaignsor->fetch(PDO::FETCH_ASSOC);
                                echo $campaigncek['campaign_title'];
                            } else {
                                echo "Kullanılan Kampanya Yok";
                            }
                            ?>
                        </td>
                        <td><?php echo $ordercek['order_total'] ?> ₺</td>
                        <td><?php echo $ordercek['order_oldtotal'] ?> ₺</td>
                        <td>
                            <form action="order-detail.php" method="post" class="col-sm-12 col-lg-2">
                                <input type="hidden" name="order_id" value="<?php echo $ordercek['order_id'] ?>">
                                <button class="btn btn-success" type="submit">Sipariş</button>
                            </form>
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
