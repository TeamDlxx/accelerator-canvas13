<?php
include 'include/website_settings.php';
include 'include/functions.php';
$get_last_menu_id = get_last_menu_id($connection_string);
$get_last_menu_id = $get_last_menu_id['get_info'];
$menu_id = $get_last_menu_id['menu_id'];
$get_menu_info = get_menu_items_by_id($connection_string, $menu_id);
$get_menu_info = $get_menu_info['get_info'];


?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title> <?= $brand_title; ?></title>
    <meta name="title" content="<?= $meta_title; ?>" />
    <meta name="keywords" content=" <?= $meta_keyword; ?>" />
    <meta name="description" content="<?= $meta_description; ?>" />
    <link rel="icon" type="image/x-icon" href="<?= $base_url . $fav_icons; ?>" />
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="assets/fonts/stylesheet.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">

                    <div class="logo ml-lg-5 mt-3">
                        <?php if ($show_logo == 1) { ?>
                            <a href="index.php"><img src="<?= $logo_brand; ?>"></a>
                        <?php } else {
                        ?>
                            <a href="index.php">
                                <?= $business_title; ?>
                            </a>
                        <?php
                        } ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <nav class="navbar navbar-expand-md">
                        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"><i class="fa fa-bars fa-1x"></i></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarResponsive">
                            <ul class="navbar-nav">
                                <?php foreach ($get_menu_info as $menu_list) {
                                    if ($menu_list['is_url'] == 0) {
                                        $href =  "#" . $menu_list['item_link'];
                                        $blank = "";
                                    } else {
                                        $href = $menu_list['item_link'];
                                        $blank = "_blank";
                                    } ?>
                                    <li class="nav-item"><a style="margin-top: 10px;" class="nav-link" target="<?= $blank ?>" href="<?= $href ?>"><?= $menu_list['item_name']; ?></a></li>
                                <?php } ?>
                                <!-- <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Benefits</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="btm-border"></div>
    </header>