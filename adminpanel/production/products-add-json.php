<?php

require_once 'header.php';

// JSON dosyasını kontrol et ve işle
if ($_FILES['json_file']['error'] === UPLOAD_ERR_OK) {
    $jsonData = file_get_contents($_FILES['json_file']['tmp_name']);

    // JSON verisini diziye dönüştür
    $data = json_decode($jsonData, true);

    // Her ürün için veritabanına ekleme işlemi yap
    foreach ($data as $item) {
        $product_id = $item['product_id'];
        $title = $item['title'];
        $category_id = $item['category_id']; // Kategori ID
        $author = $item['author'];
        $list_price = $item['list_price'];
        $stock_quantity = $item['stock_quantity'];

        // Kategori başlığını al
        $category_title = null;
        $categoryQuery = "SELECT category_title FROM categories WHERE category_id = :category_id";
        $categoryStatement = $db->prepare($categoryQuery);
        $categoryStatement->bindParam(':category_id', $category_id);
        $categoryStatement->execute();
        $row = $categoryStatement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $category_title = $row['category_title'];
        }

        // Kategori tablosuna ekleme işlemi yap
        if ($category_title === null) {
            try {
                $insertCategoryQuery = "INSERT INTO categories (category_id, category_title) 
                                        VALUES (:category_id, :category_title)";
                $insertCategoryStatement = $db->prepare($insertCategoryQuery);
                $insertCategoryStatement->bindParam(':category_id', $category_id);
                $insertCategoryStatement->bindParam(':category_title', $item['category_title']);
                $insertCategoryStatement->execute();
            } catch (PDOException $e) {
                echo "Kategori eklenirken hata oluştu: " . $e->getMessage() . "<br>";
                continue;
            }
        }

        // Ürünü veritabanına ekleme işlemi yap
        try {
            $insertProductQuery = "INSERT INTO products (product_id, title, category_id, author, list_price, stock_quantity) 
                                    VALUES (:product_id, :title, :category_id, :author, :list_price, :stock_quantity)";
            $insertProductStatement = $db->prepare($insertProductQuery);
            $insertProductStatement->bindParam(':product_id', $product_id);
            $insertProductStatement->bindParam(':title', $title);
            $insertProductStatement->bindParam(':category_id', $category_id);
            $insertProductStatement->bindParam(':author', $author);
            $insertProductStatement->bindParam(':list_price', $list_price);
            $insertProductStatement->bindParam(':stock_quantity', $stock_quantity);
            $insertProductStatement->execute();
            echo "Ürün başarıyla eklendi: " . $title . "<br>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header("Location: products.php?durum=ayniurun");
                exit();
            } else {
                echo "Hata oluştu: " . $e->getMessage() . "<br>";
            }
        }
    }
} else {
    echo "Dosya yükleme hatası: " . $_FILES['json_file']['error'];
}


require_once 'footer.php';
?>
