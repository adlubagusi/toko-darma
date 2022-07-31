-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2022 at 03:10 AM
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
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `img` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `weight` int(11) NOT NULL,
  `ket` text NOT NULL,
  `ongkir` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `general`
--

CREATE TABLE `general` (
  `id` int(11) NOT NULL,
  `app_name` varchar(50) NOT NULL,
  `slogan` varchar(150) NOT NULL,
  `navbar_color` varchar(10) NOT NULL,
  `account_mail` varchar(50) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `whatsappv2` varchar(20) NOT NULL,
  `email_contact` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `general`
--

INSERT INTO `general` (`id`, `app_name`, `slogan`, `navbar_color`, `account_mail`, `whatsapp`, `whatsappv2`, `email_contact`) VALUES
(1, 'Toko Darma', 'Easy and Reliable Online Shop', '#2d2d2d', '', '081907784650', '6281234567890', 'baiqfenijuniati946@gmail.com');

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
(15, 43, '1650183541575'),
(16, 43, '1650183551015'),
(17, 44, '1651391282609'),
(19, 44, '1651391298161'),
(20, 44, '1651391320099'),
(21, 45, '1651391597862'),
(22, 46, '1655296033347'),
(23, 47, '1659202389418'),
(24, 47, '1659202396624');

-- --------------------------------------------------------

--
-- Table structure for table `img_refund`
--

CREATE TABLE `img_refund` (
  `id` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `img` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_refund`
--

INSERT INTO `img_refund` (`id`, `id_invoice`, `img`) VALUES
(24, 515961, '1655913995367'),
(25, 515961, '1655914012515'),
(27, 0, '1659218773215'),
(28, 403369, '1659218872181');

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
  `region` int(11) NOT NULL COMMENT 'not used',
  `province` char(5) NOT NULL,
  `city` char(5) NOT NULL,
  `address` text NOT NULL,
  `ongkir` int(10) NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_all` int(11) NOT NULL,
  `date_input` datetime NOT NULL,
  `status_payment` int(1) NOT NULL,
  `status_delivery` int(1) NOT NULL,
  `bukti_transfer` varchar(100) NOT NULL,
  `no_resi` varchar(50) NOT NULL,
  `expedisi` varchar(50) NOT NULL,
  `status_refund` int(1) NOT NULL,
  `refund_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_code`, `name`, `email`, `telp`, `region`, `province`, `city`, `address`, `ongkir`, `total_price`, `total_all`, `date_input`, `status_payment`, `status_delivery`, `bukti_transfer`, `no_resi`, `expedisi`, `status_refund`, `refund_text`) VALUES
(176, '623966', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 9, '1', '114', 'Test', 5000, 89100, 94100, '2022-04-30 18:53:43', 1, 3, '1652373380894', '10987654321', 'SICEPAT', 0, ''),
(177, '212117', 'Bagus', 'user2@gmail.com', '085', 12, '1', '114', 'Jl. Jalan No. 123', 40000, 309975, 349975, '2022-05-01 10:20:12', 0, 0, '', '', '', 0, ''),
(178, '435671', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 12, '1', '114', 'Jl. Jalan sama kamu no 1', 8000, 208100, 216100, '2022-05-11 17:53:55', 1, 3, '1652288215039', '1234567890', 'JNE', 0, ''),
(179, '321699', 'Mister Potato Chips', 'me@potatochips.com', '082321654789', 13, '1', '114', 'Jl. potato chips no 99', 15000, 192000, 207000, '2022-05-14 06:08:41', 1, 3, '1652501670768', '030000414567', 'TIKI', 0, ''),
(180, '021804', 'Mister Potato Chips', 'me@potatochips.com', '082321654789', 13, '1', '114', 'Jl. potato chips no 99', 30000, 123990, 153990, '2022-05-14 06:37:01', 1, 3, '1652503158751', 'QWE12344321', 'JNE', 0, ''),
(181, '177183', 'Mister Potato Chips', 'me@potatochips.com', '082321654789', 13, '1', '114', 'Jl. jalan no 890', 15000, 101499, 116499, '2022-06-01 09:22:57', 1, 3, '1654068240620', 'ASD0987654321', 'J&T', 0, ''),
(182, '982456', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 9, '1', '114', 'Jl. Gatot Subroto III', 5000, 192000, 197000, '2022-06-05 18:03:02', 1, 2, '1654445009995', 'JNE123456789', 'JNE', 0, ''),
(183, '515961', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 12, '1', '114', 'Jl. Jalan Sama Kamu', 16000, 169900, 185900, '2022-06-15 14:51:55', 1, 2, '1655297535614', 'ASDZXC123QWE', 'KANTOR POS', 2, 'Barang sudah rusak'),
(184, '403369', 'Qwerty Uiop', 'user@gmail.com', '081246319759', 9, '1', '114', 'Jl. Sunset Road No. 123', 5000, 89100, 94100, '2022-06-15 15:06:43', 1, 2, '1655298442292', '11111111', 'JNE', 1, 'Barang Tidak Sesuai'),
(185, '428335', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 11, '1', '114', 'test', 10000, 119000, 129000, '2022-06-15 15:40:28', 0, 0, '', '', '', 0, ''),
(186, '576971', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 9, '1', '114', 'Jl. Jalan sama kamu no 1', 5000, 13570000, 13575000, '2022-07-30 20:26:16', 1, 3, '1659205707311', '1234567', 'JNE', 0, ''),
(187, '989837', 'Qwerty Uiop', 'user@gmail.com', '081234567890', 0, '1', '114', 'Jl. Jalan sama kamu no 1', 22000, 253995, 275995, '2022-07-31 02:39:49', 0, 0, '', '', '', 0, '');

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
  `price` int(50) NOT NULL,
  `purchase_price` int(50) NOT NULL,
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
  `viewer` int(11) NOT NULL,
  `region` varchar(50) NOT NULL,
  `province` char(5) NOT NULL,
  `city` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `purchase_price`, `stock`, `category`, `condit`, `weight`, `img`, `description`, `date_submit`, `publish`, `link`, `transaction`, `viewer`, `region`, `province`, `city`) VALUES
(42, 'KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat', 192000, 180000, 10, 13, 1, 100, '1602920836385.jpg', '<p>KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat adalah kerudung segiempat berbahan Nuvoile yang didesain comfy dalam patterned dan mudah diatur sehingga nyaman saat digunakan. Ukuran : 115x115 cm</p>', '2020-10-17 14:47:16', 1, 'kami-yarra-print-scarf-nuvoile-aster-jilbab-segiempat', 2, 3, 'Kota Denpasar', '22', '240'),
(43, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100, 80000, 50, 12, 1, 250, '1650183481044', '<p>Sepatu Sneakers joemen slip on dan Kasual Pria untuk jalan sekolah olahraga kuliah kerja, salah satu model baru dan trendy untuk anda miliki. Didesain untuk bisa dipakai dalam berbagai acara. Sangat nyaman dan kokoh saat anda pakai sehingga dapat menunjang penampilan dan kepercayaan diri anda.&nbsp;</p><p>Detail produk ; - ukuran ready 38/39/40/41/42/43 - bahan kulit pu sintetis - include box joemen original - fitur : ringan.empuk.nyaman di pakai Produk ORIGINAL 100% Model simple dan elegan trend terbaru Kualitas bagus harga terjangkau Nyaman saat dipakai Perawatan mudah<br>&nbsp;</p>', '2022-04-17 10:18:01', 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 5, 0, 'Kota Denpasar', '22', '240'),
(44, 'Goto Capsule Blender Cutter Quatre Kapsul Penggiling Daging', 119000, 100000, 70, 10, 1, 750, '1651391152546', '<p>Ingin membuat jus buah dengan es batu sekaligus?&nbsp;<br>Sering kesulitan menggiling daging sapi, ayam atau ikan?&nbsp;<br>Repot menghaluskan makanan bayi?&nbsp;</p><p>Bikin semua cepat beres dengan GOTO Press Capsule Cutter Quatre Hand Blender yang punya banyak kelebihan.&nbsp;<br>1.Memiliki 4 mata pisau yang tajam, sehingga menghaluskan lebih cepat dibandingkan blender lainnya&nbsp;<br>2.Watt relatif kecil yang hemat listrik&nbsp;<br>3.Pemakaian mudah dengan cara menekan bagian atas selama memblender&nbsp;<br>4.Membantu kegiatan rumah tangga seperti menghaluskan makanan bayi, sayuran, buah, daging dan kacang.&nbsp;</p><p>Cari yang pasti, belinya di GOTO Hardware saja.&nbsp;<br>1. Karena GOTO Hardware barangnya bener-bener berkualitas dan orisinil.&nbsp;<br>2. Karena GOTO Hardware bener-bener tidak pernah mengecewakan selama 20 tahun.<br>3. Karena GOTO Hardware Hebat - Hemat Banget.&nbsp;<br>4. Karena Customer Service nya GOTO Hardware bener-bener ramah dan fast response.&nbsp;<br>5. Karena pengemasan barangnya GOTO Hardware bener-bener rapih dan aman.&nbsp;<br><br>Spesifikasi Material:&nbsp;<br>Material: Akrilik Daya listrik: 220 Watt&nbsp;<br>Voltase: 220 Volt&nbsp;<br>Kapasitas: 200gr&nbsp;<br>Ukuran : Panjang 23,3 cm x Lebar : 11.6 cm<br>&nbsp;</p>', '2022-05-01 09:45:52', 1, 'goto-capsule-blender-cutter-quatre-kapsul-penggiling-daging', 3, 0, 'Kota Denpasar', '22', '240'),
(45, 'INDOCAFE COFFEMIX 3IN1 20GR RENCENG (ISI 10)', 12399, 10000, 1500, 19, 1, 200, '1651391521314', '<p>indocafe coffemix 3in1 1 renceng isi 10pc&nbsp;</p><p>adalah kopi instant 3in1 yg mempunyai rasa nikmat serta cocok disajikan dlm berbagai suasana&nbsp;<br>&nbsp;</p>', '2022-05-01 09:52:01', 1, 'indocafe-coffemix-3in1-20gr-renceng-isi-10', 3, 0, 'Kota Denpasar', '22', '240'),
(46, 'MIYAKO Rice Cooker Mini Magic Com PSG 607 (0.6 Liter)', 169900, 150000, 20, 10, 1, 2000, '1655295596672', '<p>Rice Cooker Serbaguna<br>&nbsp;---- TIDAK BISA UNTUK MENGHANGATKAN ------&nbsp;<br>*Motif batik dapat berubah disesuaikan keluaran terbaru pabrik*&nbsp;<br>Fungsi Utama :&nbsp;<br>- Memasak Nasi atau Mie&nbsp;<br>- Kapasitas Nasi 0,63 L&nbsp;<br>- Daya 300 Watt&nbsp;<br>- Tegangan 220 VAC-50 Hz&nbsp;<br>- Panci aluminium coating teflon ( anti lengket )&nbsp;</p><p>Dimensi produk : Diameter panci : 17cm ; Tinggi 10.5cm&nbsp;<br>Garansi : 1 Tahun Service&nbsp;</p><p>Multi Cooker&nbsp;<br>Nikmati multi fungsi untuk memasak nasi dan memasak mie. Multi cooker dengan fungsi yang terdapat di dalam 1 alat, Anda tidak perlu lagi harus repot menyiapkan banyak perangkat.&nbsp;</p><p>Hemat Listrik&nbsp;<br>Khawatir apabila perangkat dapur Anda akan mengunakan daya listrik yang besar? Miyako PSG-607 Multi Cooker hanya memerlukan daya listrik hanya sebesar 300 Watt untuk memasak.&nbsp;</p><p>Kapasitas 0.6 L Kapasitas penanak nasinya mampu menampung hingga 0.63L. Kapasitas ini membuat Anda dapat memasak untuk keluarga kecil tanpa kekurangan dan kesulitan. Multi cooker ini juga mampu memasak air dengan kapasitas 1.85 L. Multi cooker yang mini ini cocok digunakan di kos, kantor, kios / konter dan untuk bepergian.&nbsp;</p><p>Desain Minimalis&nbsp;<br>Dibuat dengan bodi plastik dan alumunium pan Spray, Miyako PSG-607 cocok diletakkan di mana saja. Multi cooker kecil ini memiliki bentuk bulat dengan warna putih dan bercorak batik yang cantik sehingga pas sebagai pendamping wadah di meja makan.</p>', '2022-06-15 14:19:56', 1, 'miyako-rice-cooker-mini-magic-com-psg-607-06-liter', 1, 0, 'Kota Denpasar', '22', '240'),
(47, 'Apple MacBook Air 2020 13.3` 512GB Up to 3.5GHz MVH22 Touch ID - GOLD JAPAN SET', 13570000, 11790000, 29, 10, 1, 3, '1659202226772', '<p>Apple MacBook Air 2020 13.3` 512GB 1.1GHz Up to 3.5GHz MVH22 Touch ID<br><br>10th Gen Intel Core i5,processor,1.1GHz up to 3.5GHz<br>8GB of 3733MHz LPDDR4X Memory, 512GB SSD storage<br>Intel Iris Plus Graphics Thunderbolt 3 Ports 2<br>Backlit Keyboard - US English Retina Display<br>WithTouch ID sensor<br><br><br>----------------------------------------------<br>MEMBAYAR = SETUJU<br>Budayakan Membaca sebelum membeli, barang yg kami jual sesuai iklan sesuai deksripsi<br><br>PRODUK :<br>1.BARANG DIJAMIN BRAND NEW IN BOX + SEGEL<br>2.Barang Asli dari APPLE STORE (tidak asli uang kembali 100%)<br>3.GARANSI 1 Tahun Resmi Apple INTERNASIONAL bisa klaim di semua negara termasuk INDO (TITIP KLAIM GRATIS)<br>4.GARANSI 7 Hari Tukar Baru Langsung (Sejak Barang Diterima)<br>5.Cek Resmi dan Garansi : checkcoverage.apple.com<br><br><br>TOKOHAPEDIA :<br>1.Order dikirim dihari yg sama, setelah order masuk<br>2.LUAR JAKARTA - JNE YES / TIKI ONS 1 Hari sampai<br>3.JAKARTA - Pilih GOJEK diganti KURIR KAMI, Dikarenakan rawan kehilangan (Mekanisme bisa tanya langsung)<br>4.GOJEK : jika pembeli ingin tetap pilih gojek, semua kehilangan tetap kami bantu, klaimnya pembeli yg followup<br><br>NB : Kami tidak punya toko, toko fisik kami hanya untuk bantuan klaim<br>Alamat : ITC FATMAWATI LT.Dasar No.2<br><br>APA SAJA..??<br>1.Menerima Split Payment (harga akan dibuatkan sesuai limit, kekurangan transfer)<br>2.RESELLER Harga Khusus (Next Order)<br>3.Pembelian lebih dari 1pcs Harga NEGO<br>4.Pembelian disertai nota invoice untuk memudahkan proses klaim garansi<br>5.Markup Nota silakan info kami, Dropshipper AMAN<br>6.Menerima Pengadaan kantor atau pt<br>&nbsp;</p>', '2022-07-30 19:30:26', 1, 'apple-macbook-air-2020-133-512gb-up-to-35ghz-mvh22-touch-id-gold-japan-set', 1, 0, '', '22', '240'),
(48, 'Xiaomi Redmi note9 RAM 6GB/128GB 13MP depan 48MP kamera Smartphone - Redmi9A-Hitam', 1550000, 1420000, 100, 10, 1, 500, '1659228680202', '<p>BODY Dimensions 164.9 x 77.1 x 9 mm (6.49 x 3.04 x 0.35 in)<br>Weight 196 g (6.91 oz)<br>SIM Dual SIM (Nano-SIM, dual stand-by)<br>DISPLAY Type IPS LCD, 400 nits (typ)<br>Size 6.53 inches, 102.9 cm2 (~81.0% screen-to-body ratio)<br>Resolution 720 x 1600 pixels, 20:9 ratio (~269 ppi density)<br>PLATFORM OS Android 10, MIUI 12<br>Chipset MediaTek MT6762G Helio G25 (12 nm)<br>CPU Octa-core (4x2.0 GHz Cortex-A53 &amp; 4x1.5 GHz Cortex-A53)<br>GPU PowerVR GE8320<br>MEMORY Card slot microSDXC (dedicated slot)<br>Internal 32GB 2GB RAM, 32GB 3GB RAM, 64GB 4GB RAM, 128GB 4GB RAM, 128GB 6GB RAM<br>eMMC 5.1<br>MAIN CAMERA Single 13 MP, f/2.2, 28mm (wide), 1.0Âµm, PDAF<br>Features LED flash, HDR<br>Video 1080p@30/60fps<br>SELFIE CAMERA Single 5 MP, f/2.2, (wide), 1.12Âµm<br>Features HDR<br>Video 1080p@30fps<br>SOUND Loudspeaker Yes<br>3.5mm jack Yes<br>COMMS WLAN Wi-Fi 802.11 b/g/n, Wi-Fi Direct, hotspot<br>Bluetooth 5.0, A2DP, LE<br>GPS Yes, with A-GPS, GLONASS, BDS<br>NFC No<br>Radio FM radio<br>USB microUSB 2.0, USB On-The-Go<br>FEATURES Sensors Accelerometer, proximity<br>BATTERY Type Li-Po 5000 mAh, non-removable</p>', '2022-07-31 02:51:20', 1, 'xiaomi-redmi-note9-ram-6gb128gb-13mp-depan-48mp-kamera-smartphone-redmi9a-hitam', 0, 0, '', '22', '240');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ID` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` varchar(2) NOT NULL,
  `rating` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`ID`, `nama`, `email`, `deskripsi`, `status`, `rating`, `id_product`, `id_invoice`, `parent`, `datetime`) VALUES
(58, 'Mister Potato Chips', 'me@potatochips.com', 'barang bagus', '1', 5, 43, 177183, NULL, '2022-06-01 10:36:19'),
(59, 'Mister Potato Chips', 'me@potatochips.com', 'gaenak', '1', 2, 45, 177183, NULL, '2022-06-01 10:36:19'),
(60, 'Mister Potato Chips', 'me@potatochips.com', 'kopi nikmat', '1', 5, 45, 21804, NULL, '2022-06-01 10:39:31'),
(67, 'Qwerty Uiop', 'user@gmail.com', '', '1', 1, 43, 435671, NULL, '2022-06-05 02:36:16'),
(68, 'Qwerty Uiop', 'user@gmail.com', '', '1', 1, 44, 435671, NULL, '2022-06-05 02:36:16'),
(69, 'Qwerty Uiop', 'user@gmail.com', 'mantap ðŸ‘', '1', 5, 43, 623966, NULL, '2022-06-05 05:48:03');

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
(9, 'Denpasar Utara', 5000),
(10, 'Badung', 7500),
(11, 'Gianyar', 10000),
(12, 'Tabanan', 8000),
(13, 'Tangerang Kota', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `short_desc` text NOT NULL,
  `address` varchar(100) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `favicon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `short_desc`, `address`, `logo`, `favicon`) VALUES
(1, 'Toko Darma merupakan....', 'Jl. Jalan sama kamu no.1', '1602916934871.jpg', '1602916934871.jpg');

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
  `link` varchar(100) NOT NULL,
  `ket` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `id_invoice`, `product_name`, `price`, `qty`, `link`, `ket`) VALUES
(227, 623966, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100, 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 'ukuran 43'),
(228, 212117, 'INDOCAFE COFFEMIX 3IN1 20GR RENCENG (ISI 10)', 12399, 25, 'indocafe-coffemix-3in1-20gr-renceng-isi-10', ''),
(229, 507119, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100, 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', ''),
(230, 507119, 'Goto Capsule Blender Cutter Quatre Kapsul Penggiling Daging', 119000, 1, 'goto-capsule-blender-cutter-quatre-kapsul-penggiling-daging', ''),
(231, 435671, 'Goto Capsule Blender Cutter Quatre Kapsul Penggiling Daging', 119000, 1, 'goto-capsule-blender-cutter-quatre-kapsul-penggiling-daging', ''),
(232, 435671, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100, 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 'ukuran 43'),
(233, 321699, 'KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat', 192000, 1, 'kami-yarra-print-scarf-nuvoile-aster-jilbab-segiempat', ''),
(234, 21804, 'INDOCAFE COFFEMIX 3IN1 20GR RENCENG (ISI 10)', 12399, 10, 'indocafe-coffemix-3in1-20gr-renceng-isi-10', ''),
(235, 177183, 'INDOCAFE COFFEMIX 3IN1 20GR RENCENG (ISI 10)', 12399, 1, 'indocafe-coffemix-3in1-20gr-renceng-isi-10', 'test'),
(236, 177183, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100, 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', ''),
(237, 982456, 'KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat', 192000, 1, 'kami-yarra-print-scarf-nuvoile-aster-jilbab-segiempat', 'warna abu abu'),
(238, 515961, 'MIYAKO Rice Cooker Mini Magic Com PSG 607 (0.6 Liter)', 169900, 1, 'miyako-rice-cooker-mini-magic-com-psg-607-06-liter', ''),
(239, 403369, 'Joemen Sepatu Pria J 21 Ori Import Casual Kulit Kerja Kantor Santai Pesta Fashion Pria', 89100, 1, 'joemen-sepatu-pria-j-21-ori-import-casual-kulit-kerja-kantor-santai-pesta-fashion-pria', 'ukuran 41'),
(240, 428335, 'Goto Capsule Blender Cutter Quatre Kapsul Penggiling Daging', 119000, 1, 'goto-capsule-blender-cutter-quatre-kapsul-penggiling-daging', ''),
(241, 576971, 'Apple MacBook Air 2020 13.3` 512GB Up to 3.5GHz MVH22 Touch ID - GOLD JAPAN SET', 13570000, 1, 'apple-macbook-air-2020-133-512gb-up-to-35ghz-mvh22-touch-id-gold-japan-set', ''),
(242, 989837, 'KAMI. Yarra Print Scarf Nuvoile Aster Jilbab Segiempat', 192000, 1, 'kami-yarra-print-scarf-nuvoile-aster-jilbab-segiempat', ''),
(243, 989837, 'INDOCAFE COFFEMIX 3IN1 20GR RENCENG (ISI 10)', 12399, 5, 'indocafe-coffemix-3in1-20gr-renceng-isi-10', '');

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
  `level` enum('admin','user','pemilik') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `poscode`, `telp`, `email`, `password`, `level`) VALUES
(1, 'Qwerty Uiop', 'Jl. Jalan sama kamu no 1', '65152', '081234567890', 'user@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user'),
(2, 'Administrator', 'Jl. Gatot Subroto VI F', '', '081234567890', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(3, 'Bagus', 'Jl. Jalan No. 123', '65150', '085', 'user2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user'),
(4, 'Pemilik', 'Jl. Gatot Subroto VI F', '', '089123098345', 'pemilik@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'pemilik'),
(8, 'Admin2', 'Jl. Test 1', '65123', '083222223', 'admin2@gmail.com', '040b7cf4a55014e185813e0644502ea9', 'admin'),
(9, 'Mister Potato Chips', 'Tangerang, Indonesia', '15136', '082321654789', 'me@potatochips.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `video_product`
--

CREATE TABLE `video_product` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `video` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_product`
--

INSERT INTO `video_product` (`id`, `id_product`, `video`) VALUES
(5, 46, '1659199545782'),
(6, 47, '1659202760805');

-- --------------------------------------------------------

--
-- Table structure for table `video_refund`
--

CREATE TABLE `video_refund` (
  `id` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `video` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_refund`
--

INSERT INTO `video_refund` (`id`, `id_invoice`, `video`) VALUES
(4, 403369, '1659218888413');

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
-- Indexes for table `img_refund`
--
ALTER TABLE `img_refund`
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
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `video_product`
--
ALTER TABLE `video_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_refund`
--
ALTER TABLE `video_refund`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `general`
--
ALTER TABLE `general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `img_product`
--
ALTER TABLE `img_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `img_refund`
--
ALTER TABLE `img_refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `video_product`
--
ALTER TABLE `video_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `video_refund`
--
ALTER TABLE `video_refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
