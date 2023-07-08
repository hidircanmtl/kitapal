<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'connect.php';


//==============================================================================

if (isset($_POST['increase']) && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    $cart_check = $db->prepare("SELECT cart.quantity, products.stock_quantity FROM cart 
        INNER JOIN products ON cart.product_id = products.product_id 
        WHERE cart.cart_id = :cart_id");
    $cart_check->execute(['cart_id' => $cart_id]);
    $result = $cart_check->fetch(PDO::FETCH_ASSOC);

    $quantity = $result['quantity'];
    $stock_quantity = $result['stock_quantity'];

    if ($quantity < $stock_quantity) {
        $quantity_update = $db->prepare("UPDATE cart SET quantity = quantity + 1 WHERE cart_id = :cart_id");
        $quantity_update->execute(['cart_id' => $cart_id]);
    }

    header("Location: ../../cart.php");
    exit();
}


if (isset($_POST['decrease']) && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    $quantity_check = $db->prepare("SELECT quantity FROM cart WHERE cart_id = :cart_id");
    $quantity_check->execute(['cart_id' => $cart_id]);
    $quantity = $quantity_check->fetchColumn();

    if ($quantity > 1) {
        $quantity_update = $db->prepare("UPDATE cart SET quantity = quantity - 1 WHERE cart_id = :cart_id");
        $quantity_update->execute(['cart_id' => $cart_id]);
    }

    header("Location: ../../cart.php");
    exit();
}

//==============================================================================

if (isset($_POST['submitcart'])) {
    $user_id = $_POST['user_id'];
    $order_total = $_POST['order_total'];
    $campaign_id = $_POST['campaign_id'];
    $order_oldtotal = $_POST['order_oldtotal'];

    // Siparişi orders tablosuna kaydetme işlemi
    $kaydet = $db->prepare("INSERT INTO orders SET
        user_id=:user_id,
        order_total=:order_total,
        campaign_id=:campaign_id,
        order_oldtotal=:order_oldtotal
    ");

    $insert = $kaydet->execute(array(
        'user_id' => $user_id,
        'campaign_id' => $campaign_id,
        'order_total' => $order_total,
        'order_oldtotal' => $order_oldtotal
    ));

    if ($insert) {
        $siparis_id = $db->lastInsertId();

        // Sipariş detaylarını orderdetails tablosuna kaydetme işlemi
        $sepetsor = $db->prepare("SELECT * FROM cart WHERE user_id=:user_id");
        $sepetsor->execute(array('user_id' => $user_id));

        while ($sepetcek = $sepetsor->fetch(PDO::FETCH_ASSOC)) {
            $product_id = $sepetcek['product_id'];
            $quantity = $sepetcek['quantity'];

            $urunsor = $db->prepare("SELECT * FROM products WHERE product_id=:id");
            $urunsor->execute(array('id' => $product_id));
            $uruncek = $urunsor->fetch(PDO::FETCH_ASSOC);
            $list_price = $uruncek['list_price'];

            $newStok = $uruncek['stock_quantity'] - $quantity;

            $stokGuncelle = $db->prepare("UPDATE products SET stock_quantity = :newStok WHERE product_id = :product_id");
            $stokGuncelle->execute(['newStok' => $newStok, 'product_id' => $product_id]);

            $kaydet = $db->prepare("INSERT INTO orderdetails SET
                user_id=:user_id,
                order_id=:order_id,
                product_id=:product_id,
                list_price=:list_price,
                quantity=:quantity
            ");

            $insert = $kaydet->execute(array(
                'order_id' => $siparis_id,
                'user_id' => $user_id,
                'product_id' => $product_id,
                'list_price' => $list_price,
                'quantity' => $quantity
            ));
        }

        if ($insert) {
            // Kullanıcının kampanyayı kullandığını campaignused tablosuna kaydetme işlemi
            $kaydetCampaignUsed = $db->prepare("INSERT INTO campaignused SET user_id=:user_id, campaign_id=:campaign_id");
            $kaydetCampaignUsed->execute(['user_id' => $user_id, 'campaign_id' => $campaign_id]);

            if ($kaydetCampaignUsed) {
                $sil = $db->prepare("DELETE FROM cart WHERE user_id=:user_id");
                $sil->execute(array('user_id' => $user_id));

                header("Location: ../../orders?durum=ok");
                exit;
            } else {
                echo "Kampanya kullanımı kaydedilirken bir hata oluştu.";
            }
        } else {
            echo "Sipariş detayları kaydedilirken bir hata oluştu.";
        }
    } else {
        echo "Sipariş kaydedilirken bir hata oluştu.";
    }
}


//==============================================================================

if (isset($_POST['addcart'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $cart_check = $db->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $cart_check->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $existing_cart = $cart_check->fetch(PDO::FETCH_ASSOC);

    if ($existing_cart) {
        $cart_id = $existing_cart['cart_id'];

        $quantity_update = $db->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE cart_id = :cart_id");
        $quantity_update->execute(['quantity' => $quantity, 'cart_id' => $cart_id]);
    } else {
        $cart_insert = $db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $cart_insert->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    Header("Location:../../cart.php?durum=ok");
    exit();
}

//==============================================================================

if ($_GET['cartsil'] == "ok") {
    $sil = $db->prepare("DELETE from cart where cart_id=:cart_id");
    $kontrol = $sil->execute(array(
        'cart_id' => $_GET['cart_id']
    ));
    if ($kontrol) {
        Header("Location:../../cart.php?durum=silindi");
    } else {
        Header("Location:../../cart.php?durum=silinmedi");
    }
}