<?php
session_start();
if(!isset($_SESSION['level']) || $_SESSION['level'] <> "admin"){
    header('location: index.php?page=home');
}
require_once 'routes-admin.php';
require_once 'include/cfg.php';
require_once 'include/func.php';

include "module/templates/index-admin.php";