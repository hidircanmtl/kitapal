<?php
require_once 'guard.php';
require_once '../utilities/connect.php';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KİTAP AL Adminpanel</title>

    <!-- Bootstrap Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" />

    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="container">
    <div class="row bg-primary bg-gradient mt-5 p-3 rounded-3 text-white text-center">
        <a class="col-3 border-end" href="products.php">
            <h4 class="text-white">Ürünler</h4>
        </a>
        <a class="col-3 border-end" href="orders.php">
            <h4 class="text-white">Siparişler</h4>
        </a>
        <a class="col-3" href="users.php">
            <h4 class="text-white">Kullanıcılar</h4>
        </a>
        <h4 class="col-3 d-flex justify-content-end">
            <button class="btn btn-danger">
                <a href="logout.php" class="text-white text-decoration-none fw-bold">
                    <i class="bi bi-box-arrow-left"></i> Çıkış Yap
                </a>
            </button>
        </h4>

    </div>
</nav>