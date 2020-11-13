-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 24 May 2020, 17:37:03
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hesapal`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `verified` int(11) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `price` float NOT NULL,
  `details` text NOT NULL,
  `category` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `bought_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `number` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `configs`
--

CREATE TABLE `configs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`) VALUES
(1, 'site_name', 'Hesap Satın Al'),
(2, 'site_description', 'Sitemiz sayesinde kolayca hesap satın alabilirsiniz.'),
(3, 'site_tags', 'hesap satın al, ucuza hesap al'),
(4, 'site_lang', 'tr'),
(5, 'site_money_sign', '₺'),
(6, 'recaptcha_enabled', '0'),
(7, 'recaptcha_site_key', ''),
(8, 'recaptcha_secret_key', ''),
(9, 'smtp_host', 'smtp.hosting.com'),
(10, 'smtp_user', 'noreply@hosting.com'),
(11, 'smtp_pass', '123456'),
(12, 'smtp_port', '25'),
(13, 'minimum_payment', '1'),
(14, 'payment_method', 'shopier'),
(15, 'shopier_api_key', 'SHOPIER_API_KEY'),
(16, 'shopier_api_secret', 'SHOPIER_SECRET_KEY'),
(17, 'shopier_site_index', '1'),
(18, 'payment_commission', '0'),
(19, 'weepay_seller_id', '1000'),
(20, 'weepay_api_key', 'weepay_api_key'),
(21, 'weepay_secret_key', 'weepay_secret_key'),
(22, 'logo', '1'),
(23, 'site_timezone', 'Europe/Istanbul');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `tags` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `description`, `tags`, `content`, `menu`) VALUES
(6, 'Kullanım Koşulları', 'kullanim-kosullari', 'Sitemizi kullanarak bazı şartları kabul etmiş olursunuz.', 'kullanım koşulları', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus dignissim ultrices justo id sollicitudin. Nam at augue sit amet felis pharetra egestas et ultrices neque. Maecenas eu risus in justo sollicitudin condimentum. Morbi posuere placerat odio, ut aliquet ipsum feugiat et. Praesent nulla lorem, pulvinar vel aliquam a, condimentum at augue. Ut id iaculis odio. Cras accumsan, purus id tristique laoreet, turpis enim hendrerit sem, at facilisis elit velit ut dui. Aenean dui ex, posuere vel enim eu, fermentum fringilla enim. Nullam accumsan ullamcorper rutrum. Duis non posuere lectus. Curabitur at ultricies libero, et viverra neque.</p>\n\n<p>&nbsp;</p>\n\n<p>Aenean et dui venenatis, aliquam odio eu, condimentum odio. Phasellus leo nisi, ornare ut varius id, ullamcorper a quam. Donec imperdiet sollicitudin tempor. Curabitur in mi ut nibh vulputate ultricies. Curabitur laoreet ac massa vel suscipit. Nulla malesuada facilisis elit vel consequat. Pellentesque volutpat mattis mi quis euismod. Vivamus viverra, lectus a porta pretium, justo lectus pharetra metus, congue mattis risus enim vulputate ligula. Morbi lacinia tincidunt interdum. Duis sed velit id mi aliquam bibendum non vel lacus. Donec odio elit, feugiat vel ligula sodales, aliquam consequat neque. Mauris fringilla magna quam, non hendrerit lorem semper vel. Nulla sed odio non eros blandit ultricies in et nisi. Cras quis pharetra dui. Nam viverra quam sit amet tincidunt porta.</p>\n', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `user` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment_notifications`
--

CREATE TABLE `payment_notifications` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `bank` int(11) NOT NULL,
  `amount` float NOT NULL,
  `user` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `user` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `message` text NOT NULL,
  `user` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(64) NOT NULL,
  `balance` float NOT NULL,
  `created_date` int(11) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `balance`, `created_date`, `role`) VALUES
(1, 'Script Admin', 'admin@script.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0, 1589888075, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `payment_notifications`
--
ALTER TABLE `payment_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `payment_notifications`
--
ALTER TABLE `payment_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
