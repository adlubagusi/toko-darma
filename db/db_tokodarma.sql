-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2022 at 12:22 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tokodarma`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `img` varchar(30) NOT NULL,
  `url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `img`, `url`) VALUES
(19, '1602921038655.png', 'http://localhost/olshop/c/pakaian-wanita'),
(20, '1602921337255.png', 'http://localhost/olshop/c/komputer');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` double(16,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `img` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `weight` int(11) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `id_user`, `id_product`, `name`, `price`, `qty`, `img`, `link`, `weight`, `ket`) VALUES
(4, 1, 43, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100.00, 1, '1650183481044', 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 0, 'ukuran 43'),
(6, 1, 43, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100.00, 2, '1650183481044', 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 0, 'ukuran 41');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `link` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`, `link`) VALUES
(10, 'Elektronik', '1650009641151', 'elektronik'),
(11, 'Pakaian Pria', '1650009436928', 'pakaian-pria'),
(12, 'Sepatu', '1650009674553', 'sepatu'),
(13, 'Fashion Muslim', '1650009525706', 'fashion-muslim'),
(19, 'Minuman', '1650009489848', 'minuman'),
(20, 'Aksesoris Fashion', '1650009708100', 'aksesoris-fashion'),
(21, 'Komputer & Aksesoris', '1650009758264', 'komputer-aksesoris'),
(22, 'Prawatan & Kecantikan', '1650009840627', 'prawatan-kecantikan');

-- --------------------------------------------------------

--
-- Table structure for table `email_send`
--

CREATE TABLE `email_send` (
  `id` int(11) NOT NULL,
  `mail_to` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `page`, `type`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 2, 2),
(4, 1, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 2),
(8, 7, 2),
(9, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `general`
--

CREATE TABLE `general` (
  `id` int(11) NOT NULL,
  `app_name` varchar(50) NOT NULL,
  `slogan` varchar(150) NOT NULL,
  `navbar_color` varchar(10) NOT NULL,
  `host_mail` varchar(50) NOT NULL,
  `port_mail` varchar(5) NOT NULL,
  `crypto_mail` varchar(10) NOT NULL,
  `account_mail` varchar(50) NOT NULL,
  `pass_mail` varchar(150) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `whatsappv2` varchar(20) NOT NULL,
  `email_contact` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `general`
--

INSERT INTO `general` (`id`, `app_name`, `slogan`, `navbar_color`, `host_mail`, `port_mail`, `crypto_mail`, `account_mail`, `pass_mail`, `whatsapp`, `whatsappv2`, `email_contact`) VALUES
(1, 'Toko Darma', 'Easy and Reliable Online Shop', '#2d2d2d', 'ssl://gmail.com', '465', '', '', '', '081907784650', '6281234567890', 'baiqfenijuniati946@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `img_product`
--

CREATE TABLE `img_product` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `img` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_product`
--

INSERT INTO `img_product` (`id`, `id_product`, `img`) VALUES
(7, 30, '1598796094098.jpg'),
(8, 30, '1598796099769.jpg'),
(9, 31, '1598800027430.jpg'),
(10, 35, '1598800578610.jpg'),
(11, 37, '1598800774520.jpg'),
(13, 42, '1602920870406.jpg'),
(14, 45, '1649961765942'),
(15, 43, '1650183541575'),
(16, 43, '1650183551015');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invoice_code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `region` int(11) NOT NULL,
  `address` text NOT NULL,
  `ongkir` varchar(10) NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_all` int(11) NOT NULL,
  `date_input` datetime NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_code`, `name`, `email`, `telp`, `region`, `address`, `ongkir`, `total_price`, `total_all`, `date_input`, `status`) VALUES
(150, '237194', 'Adlu Bagus', 'adlubagusi@gmail.com', '081246319759', 5, 'Perum Griya Permata Alam Blok Q 27', '1500000', 172700099, 174200099, '2020-10-17 13:47:17', 1),
(151, '981165', 'Tes', 'tes@email.com', '081246319759', 5, 'Perum Griya Permata Alam', '1500000', 62500, 1562500, '2020-10-18 13:36:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `slug`) VALUES
(1, 'About Us', '<p>This is an example of our about page</p>', 'about-us'),
(2, 'Contact', '<p>This is an example of a contact page</p>', 'contact'),
(3, 'Testimonial', '<p>Don\'t change slug</p>', 'testimony'),
(4, 'Privacy Policy', '<p>This is an example of a privacy policy page</p>', 'privacy-policy'),
(5, 'Terms and Conditions', '<p>This is an example of the terms and conditions page</p>', 'terms'),
(6, 'How to Shop', '<p>This is an example of how to shop page</p>', 'shopping-help'),
(7, 'Delivery Order', '<p>This is an example of delivery order page</p>', 'delivery-order');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `condit` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `img` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date_submit` datetime NOT NULL,
  `publish` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  `transaction` int(11) NOT NULL,
  `promo_price` varchar(30) NOT NULL,
  `viewer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `stock`, `category`, `condit`, `weight`, `img`, `description`, `date_submit`, `publish`, `link`, `transaction`, `promo_price`, `viewer`) VALUES
(42, 'KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat', '192,000.00', 10, 13, 1, 100, '1602920836385.jpg', '<p>KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat adalah kerudung segiempat berbahan Nuvoile yang didesain comfy dalam patterned dan mudah diatur sehingga nyaman saat digunakan. Ukuran : 115x115 cm</p>', '2020-10-17 14:47:16', 1, 'kami-yarra-print-scarf-nuvoile-aster-jilbab-segiempat', 0, '100,000.00', 3),
(43, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', '89,100.00', 50, 12, 1, 250, '1650183481044', '<p>Sepatu Sneakers joemen slip on dan Kasual Pria untuk jalan sekolah olahraga kuliah kerja, salah satu model baru dan trendy untuk anda miliki. Didesain untuk bisa dipakai dalam berbagai acara. Sangat nyaman dan kokoh saat anda pakai sehingga dapat menunjang penampilan dan kepercayaan diri anda.&nbsp;</p><p>Detail produk ; - ukuran ready 38/39/40/41/42/43 - bahan kulit pu sintetis - include box joemen original - fitur : ringan.empuk.nyaman di pakai Produk ORIGINAL 100% Model simple dan elegan trend terbaru Kualitas bagus harga terjangkau Nyaman saat dipakai Perawatan mudah<br>&nbsp;</p>', '2022-04-17 10:18:01', 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `region` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `region`, `price`) VALUES
(5, 'Malang Kota/Kab.', 500000),
(6, 'Surabaya Kota/Kab.', 1500000),
(8, 'Bali', 5000000),
(9, 'Denpasar Utara', 5000),
(10, 'Badung', 7500),
(11, 'Gianyar', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `promo` int(11) NOT NULL,
  `promo_time` varchar(40) NOT NULL,
  `short_desc` text NOT NULL,
  `address` varchar(100) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `favicon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `promo`, `promo_time`, `short_desc`, `address`, `logo`, `favicon`) VALUES
(1, 0, '2020-10-24T01:00', 'Toko Darma merupakan....', 'Jl. Jalan sama kamu no.1', '1602916934871.jpg', '1602916934871.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sosmed`
--

CREATE TABLE `sosmed` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sosmed`
--

INSERT INTO `sosmed` (`id`, `name`, `icon`, `link`) VALUES
(1, 'Facebook', 'facebook-f', 'https://facebook.com/banatechindo'),
(3, 'Twitter', 'twitter', 'https://twitter.com/tonisuwen'),
(4, 'Linkedin', 'linkedin-in', 'https://linkedin.com/in/tonisuwendi'),
(5, 'Instagram', 'instagram', 'https://instagram.com/tonisuwen'),
(6, 'Youtube', 'youtube', 'https://youtube.com/tonisuwendi');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `ket` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `id_invoice`, `product_name`, `price`, `qty`, `slug`, `ket`) VALUES
(208, 237194, 'Lenovo Legion Y540 15.6 Laptop 144Hz i7-9750H 16GB RAM 256GB SSD GTX 1660Ti 6GB', 172700099, 1, 'lenovo-legion-y540-156-laptop-144hz-i7-9750h-16gb-ram-256gb-ssd-gtx-1660ti-6gb', ''),
(209, 981165, 'MACBOOK PRO 13\" RETINA @ CORE i7 @ 16GB RAM 1TB SSD 3 YEAR WARRANTY @ OS-2019', 62500, 1, 'macbook-pro-13-retina-core-i7-16gb-ram-1tb-ssd-3-year-warranty-os-2019', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `poscode` varchar(6) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('admin','user','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `poscode`, `telp`, `email`, `password`, `level`) VALUES
(1, 'Qwerty Uiop', 'Denpasar', '65152', '081234567890', 'user@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user'),
(2, 'Administrator', '', '', '', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_send`
--
ALTER TABLE `email_send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general`
--
ALTER TABLE `general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img_product`
--
ALTER TABLE `img_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sosmed`
--
ALTER TABLE `sosmed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `email_send`
--
ALTER TABLE `email_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `general`
--
ALTER TABLE `general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `img_product`
--
ALTER TABLE `img_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sosmed`
--
ALTER TABLE `sosmed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
