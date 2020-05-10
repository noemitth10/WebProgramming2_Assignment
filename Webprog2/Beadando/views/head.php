<?php if(!defined('INDEX')) { exit; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ComicBook Database</title>
    <link rel="stylesheet" href="./css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One&display=swap" rel="stylesheet">
</head>
<body>
<style>
body {
  background-image: url('backg.png');
}
</style>
<header>
<div class="h-container">
    <a class="logo" href="#">GUARDIAN COMICS</a>
</div>
</header>
<div class="container">
    <div class="container-left">
        <h1 class="title-text">Navigation</h1>

                <a href="<?php echo url('home') ?>" <?php echo $page == 'home' ? 'class="active"' : ''; ?>>HOME</a><br>

                <?php if(!(isset($_SESSION['logged']) && $_SESSION['logged'] == 1)) :?>
                    <a href="<?php echo url('login') ?>" <?php echo $page == 'login' ? 'class="active"' : ''; ?>>Login</a> 
                <?php else : ?>
                <a href="<?php echo url('logout') ?>">Logout</a> 
                <?php endif; ?><br>

                <a href="<?php echo url('registration') ?>" <?php echo $page == 'registration' ? 'class="active"' : ''; ?>>Registration</a><br>

                <a href="<?php echo url('comics') ?>" <?php echo $page == 'comics' ? 'class="active"' : ''; ?>>Comics</a><br>

                 <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 1) : ?>
                    <a href="<?php echo url('upload') ?>" <?php echo $page == 'upload' ? 'class="active"' : ''; ?>>Upload</a> 
                <?php endif;?><br>

                <a href="<?php echo url('about') ?>" <?php echo $page == 'about' ? 'class="active"' : ''; ?>>About us</a><br>
    </div>
    <div class="container-right">
