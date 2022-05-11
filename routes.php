<?php
$page = "module/pages/product_index.php";
$css = 'style.css';
$responsive = 'style-responsive.css';
if(isset($_GET['page'])){
    $url = $_GET['page'];
    if($url == "about"){
        $page = "module/pages/about.php";
        $css  = 'page.css';
        $responsive = '';
    }else if($url == "cara_pemesanan"){
        $page = "module/pages/cara_pemesanan.php";
        $css  = 'page.css';
        $responsive = '';
    }else if($url == "rekening"){
        $page = "module/pages/norekening.php";
        $css  = 'page.css';
        $responsive = '';
    }else if($url == "cart"){
        $page = "module/pages/cart.php";
        $css  = 'cart.css';
        $responsive = '';
    }else if($url == "products"){
        $page = "module/pages/products.php";
        $css = 'products.css';
        $responsive = 'product-responsive.css';
    }else if($url == "payment"){
        $page = "module/pages/payment.php";
        $css = 'payment.css';
        $responsive = '';
    }else if($url == "history"){
        $page = "module/pages/history.php";
        $css = 'page.css';
        $responsive = '';
    }   
}

if(isset($_GET['p'])){
    $url = $_GET['p'];
    $page = "module/pages/detail.php";
    $css = 'detail.css';
}
if(isset($_GET['c'])){
    $url = $_GET['c'];
    $page = "module/pages/categories.php";
    $css = 'products.css';
    $responsive = 'product-responsive.css';
}