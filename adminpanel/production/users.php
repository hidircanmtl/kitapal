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
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">E - Posta</th>
                    <th scope="col">Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $usersor = $db->prepare("select * from users order by userdate");
                $usersor->execute();
                while ($usercek = $usersor->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <th scope="row">#<?php echo $usercek['user_id'] ?></th>
                        <td><?php echo $usercek['username'] ?></td>
                        <td><?php echo $usercek['phone'] ?></td>
                        <td><?php echo $usercek['email'] ?></td>
                        <td>
                            <a href="../utilities/operations.php?user_id=<?php echo $usercek['user_id']; ?>&usersil=ok"
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
