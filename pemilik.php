<?php
session_start();
if(!isset($_SESSION['level']) || $_SESSION['level'] <> "pemilik"){
    header('location: index.php?page=home');
}
require_once 'routes-pemilik.php';
require_once 'include/cfg.php';
require_once 'include/func.php';

include "module/templates/index-pemilik.php";