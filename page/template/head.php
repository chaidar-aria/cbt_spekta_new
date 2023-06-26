<?php
date_default_timezone_set('Asia/Jakarta');

include '../../config/conn.php';
include '../../helper/url.php';
include '../../helper/dateIndo.php';

$username = $_SESSION['username'];

if ($_SESSION['level'] == "user") {

    $query = "SELECT * FROM tb_users_cbt
          INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
          INNER JOIN tb_test ON tb_test.test_id = tb_users_status.test_id
          WHERE tb_users_cbt.username = '$username'";

    $result = $conn->query($query);

    while ($d = $result->fetch_assoc()) {

?>

        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta http-equiv="Content-Language" content="en">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>CBT SPEKTA | Sistem Pencatatan Keuangan dan Keanggotaan Pramuka</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
            <meta name="description" content="This is an example dashboard created using build-in elements and components.">
            <meta name="msapplication-tap-highlight" content="no">
            <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
            <link href="<?php echo $urlAsset ?>css/main.css" rel="stylesheet">

        </head>

        <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
            <div class=" app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
                <div class="app-header header-shadow">
                    <div class="app-header__logo">
                        <img src="<?php echo $urlAsset ?>images/logo.png" alt="logo" width="150">
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__content">
                        <div class="app-header-right">
                            <div class="header-btn-lg pr-0">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left  ml-3 header-user-info">
                                            <div class="widget-heading">
                                                Nama Peserta: <?php echo $d['name']; ?>
                                            </div>
                                            <div class="widget-subheading">
                                                Nomor Peserta: <?php echo $d['username']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
    } else if (($_SESSION['level'] == "admin")) {

        $query = "SELECT * FROM tb_users_cbt
WHERE username = '$username'";

        $result = $conn->query($query);

        while ($d = $result->fetch_assoc()) {
            ?>

                <!doctype html>
                <html lang="en">

                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta http-equiv="Content-Language" content="en">
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>CBT SPEKTA | Sistem Pencatatan Keuangan dan Keanggotaan Pramuka</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
                    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
                    <meta name="msapplication-tap-highlight" content="no">
                    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.3/datatables.min.css" />

                    <link href="<?php echo $urlAsset ?>css/main.css" rel="stylesheet">
                </head>

                <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
                    <div class=" app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
                        <div class="app-header header-shadow">
                            <div class="app-header__logo">
                                <img src="<?php echo $urlAsset ?>images/logo.png" alt="logo" width="150">
                                <div class="header__pane ml-auto">
                                    <div>
                                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                            <span class="hamburger-box">
                                                <span class="hamburger-inner"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="app-header__mobile-menu">
                                <div>
                                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                        <span class="hamburger-box">
                                            <span class="hamburger-inner"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="app-header__content">
                                <div class="app-header-right">
                                    <div class="header-btn-lg pr-0">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left  ml-3 header-user-info">
                                                    <div class="widget-heading">
                                                        Nama : <?php echo $d['username']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
        } ?>