<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'connect.php';


if (isset($_POST['register'])) {
    $adsoyad = htmlspecialchars($_POST['username']);
    $mail = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['phone']);
    $sifre = htmlspecialchars($_POST['password']);
    $sifreiki = htmlspecialchars($_POST['passwordtwo']);

    if ($sifre == $sifreiki) {
        if ($sifre >= 6) {
            $mailsor = $db->prepare("select * from users where email=:mail");
            $mailsor->execute(array(
                'mail' => $mail
            ));
            $say = $mailsor->rowCount();
            if ($say == 0) {
                $password = md5($sifre);

                $kaydet = $db->prepare("INSERT INTO users SET
		            username=:username,
		            email=:email,
		            phone=:phone,
		            password=:password
		        ");
                $insert = $kaydet->execute(array(
                    'username' => $adsoyad,
                    'email' => $mail,
                    'phone' => $tel,
                    'password' => $password
                ));
                if ($insert) {
                    Header("Location:../../login.php?durum=loginbasarili");
                } else {
                    Header("Location:../../register.php?durum=loginbasarisiz");
                }
            } else {
                Header("Location:../../register.php?durum=mukerrerkayit");
            }

        } else {
            Header("Location:../../register.php?durum=eksiksifre");
        }

    } else {
        Header("Location:../../register.php?durum=farklisifre");
    }
}

if (isset($_POST['login'])) {
    $mail = htmlspecialchars($_POST['email']);
    $password = md5($_POST['password']);

    $admin_username = "admin@kitapal";
    $admin_password = "Kitapal99..";

    if ($mail == $admin_username && $password == md5($admin_password)) {

        $_SESSION['email'] = $mail;
        header("Location: ../../adminpanel/");
        exit;
    }

    $kullanicisor = $db->prepare("SELECT * FROM users WHERE email = :mail AND password = :password");
    $kullanicisor->execute(array(
        'mail' => $mail,
        'password' => $password
    ));

    $say = $kullanicisor->rowCount();

    if ($say == 1) {
        $_SESSION['email'] = $mail;
        header("Location: ../../");
        exit;
    } else {
        header("Location: ../../login.php?durum=basarisizgiris");
    }
}


//==============================================================================

if ($_GET['urunsil'] == "ok") {
    $sil = $db->prepare("DELETE from products where product_id=:product_id");
    $kontrol = $sil->execute(array(
        'product_id' => $_GET['product_id']
    ));
    if ($kontrol) {
        Header("Location:../production/products.php?durum=silindi");
    } else {
        Header("Location:../production/products.php?durum=silinmedi");
    }
}

if ($_GET['usersil'] == "ok") {
    $sil = $db->prepare("DELETE from users where user_id=:user_id");
    $kontrol = $sil->execute(array(
        'user_id' => $_GET['user_id']
    ));
    if ($kontrol) {
        Header("Location:../production/users.php?durum=silindi");
    } else {
        Header("Location:../production/users.php?durum=silinmedi");
    }
}


//==============================================================================

if (isset($_POST['productupdate'])) {
    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $list_price = $_POST['list_price'];
    $stock_quantity = $_POST['stock_quantity'];

    $kaydet = $db->prepare("UPDATE products SET
        title = :title,
        author = :author,
        list_price = :list_price,
        stock_quantity = :stock_quantity
        WHERE product_id = :product_id
    ");

    $update = $kaydet->execute(array(
        'title' => $title,
        'author' => $author,
        'list_price' => $list_price,
        'stock_quantity' => $stock_quantity,
        'product_id' => $product_id
    ));

    if ($update) {
        header("Location: ../production/products.php?durum=ok");
    } else {
        header("Location: ../production/products.php?durum=no");
    }
}






