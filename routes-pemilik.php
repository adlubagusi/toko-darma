<?php
$page = "module/pemilik/dashboard.php";
if(isset($_GET['page'])){
    $url = $_GET['page'];
    if($url == "home"){
        $page = "module/pemilik/dashboard.php";
    }else if($url == "users"){
        $page = "module/pemilik/users.php";
    }else if($url == "order_proccess"){
        $page = "module/pemilik/orders.php";
    }else if($url == "order_send"){
        $page = "module/pemilik/orders.php";
    }
}