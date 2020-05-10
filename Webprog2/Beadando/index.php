<?php
define('INDEX', 'TRUE');
session_start();

include_once "config.php";
include_once "functions.php";

$page = isset($_GET['p']) ? $_GET['p']  :'home';

$db = db_connect();

if(file_exists("./views/{$page}.php")) 
{
    include_once "./views/{$page}.php";
} else 
{
    include_once "./views/404.php";
}

$db->close();
