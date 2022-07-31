<?php
$page = "module/pemilik/dashboard.php";
if(isset($_GET['page'])){
    $url = $_GET['page'];
    if($url == "home"){
        $page = "module/pemilik/dashboard.php";
    }else if($url == "users"){
        $page = "module/pemilik/users.php";
    }else if($url == "orders"){
        $page = "module/pemilik/orders.php";
    }else if($url == "print_orders"){
        $page = "module/pemilik/print_orders.php";
    }else if($url == "best_products"){
        $page = "module/pemilik/best_products.php";
    }else if($url == "print_best_products"){
        $page = "module/pemilik/print_best_products.php";
    }else if($url == "sales"){
        $page = "module/pemilik/sales.php";
    }else if($url == "print_sales"){
        $page = "module/pemilik/print_sales.php";
    }
}