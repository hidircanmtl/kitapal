-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 08 Tem 2023, 17:55:04
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kitapal`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE IF NOT EXISTS `campaigns` (
  `campaign_id` int NOT NULL AUTO_INCREMENT,
  `campaign_title` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `campaign_type` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `campaign_value` decimal(5,2) NOT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `campaigns`
--

INSERT INTO `campaigns` (`campaign_id`, `campaign_title`, `campaign_type`, `campaign_value`) VALUES
(1, 'Sabahattin Ali Romanlarında 2 Üründen 1 Bedava!', 'kitap_indirim', '0.50'),
(2, '100 TL ve Üzeri Alışverişlerde %5 İndirim', 'sepet_indirim', '0.05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `campaignused`
--

DROP TABLE IF EXISTS `campaignused`;
CREATE TABLE IF NOT EXISTS `campaignused` (
  `campaignused_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `campaign_id` int NOT NULL,
  PRIMARY KEY (`campaignused_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `cart_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity` int NOT NULL,
  `shipping_count` double(15,2) NOT NULL DEFAULT '75.00',
  `campaign_id` int NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_title` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(5, 'Öykü'),
(4, 'Din Tasavvuf'),
(3, 'Bilim'),
(2, 'Kişisel Gelişim'),
(1, 'Roman'),
(6, 'Felsefe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE IF NOT EXISTS `orderdetails` (
  `orderdetail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `order_no` varchar(20) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `list_price` double(15,2) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `campaign_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `orderdetail_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderdetail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_no` int NOT NULL,
  `order_total` double(15,2) NOT NULL,
  `order_oldtotal` double(15,2) NOT NULL,
  `user_id` int NOT NULL,
  `campaign_id` int NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=65298459 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `category_id` int NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `list_price` double(15,2) NOT NULL,
  `stock_quantity` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `title`, `category_id`, `author`, `list_price`, `stock_quantity`) VALUES
(15, 'Animal Farm', 1, 'George Orwell', 17.50, 1),
(14, 'Denemeler - Hasan Ali Yücel Klasikleri', 6, 'Michel de Montaigne', 24.00, 4),
(13, 'Kendime Düşünceler', 6, 'Marcus Aurelius', 14.40, 1),
(12, 'Kamyon - Seçme Öyküler', 5, 'Sabahattin Ali', 9.75, 9),
(11, 'Kuyucaklı Yusuf', 1, 'Sabahattin Ali', 10.40, 2),
(10, 'Benim Zürafam Uçabilir', 4, 'Mert Arık', 27.30, 12),
(9, 'Aşk 5 Vakittir', 4, 'Mehmet Yıldız', 42.00, 9),
(8, 'Allah De Ötesini Bırak', 4, 'Uğur Koşar', 39.60, 18),
(7, 'Kara Delikler', 3, 'Stephen Hawking', 39.00, 2),
(6, 'Sen Yola Çık Yol Sana Görünür', 2, 'Hakan Mengüç', 28.50, 7),
(5, 'Şeker Portakalı', 1, 'Jose Mauro De Vasconcelos', 33.00, 1),
(4, 'Fareler ve İnsanlar', 1, 'John Steinback', 35.75, 8),
(3, 'Kürk Mantolu Madonna', 1, 'Sabahattin Ali', 9.10, 4),
(2, 'Tutunamayanlar', 1, 'Oğuz Atay', 90.30, 20),
(1, 'İnce Memed', 1, 'Yaşar Kemal', 48.75, 10),
(16, 'Dokuzuncu Hariciye Koğuşu', 1, 'Peyami Safa', 18.50, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `userdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `campaign_id` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `phone`, `password`, `userdate`, `campaign_id`) VALUES
(1, 'Hıdırcan Mutlu', 'hidircanmutlu@gmail.com', '05386019400', 'ee9364e8beab6adc046fb97e3b22686c', '2023-07-07 00:32:39', 0),
(2, 'Ali Yılmaz', 'aliyilmaz@gmail.com', '555555555', '86318e52f5ed4801abe1d13d509443de', '2023-07-07 00:32:39', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
