<?php
$page = "module/admin/dashboard.php";
if(isset($_GET['page'])){
    $url = $_GET['page'];
    if($url == "home"){
        $page = "module/admin/dashboard.php";
    }else if($url == "categories"){
        $page = "module/admin/categories.php";
    }else if($url == "products"){
        $page = "module/admin/products.php";
    }else if($url == "settings"){
        $page = "module/admin/settings.php";
    }
}