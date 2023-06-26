<?php
include '../../config/conn.php';
include '../../helper/url.php';

$username = $_SESSION['username'];
if ($_SESSION['level'] == "user") {

    $query = "SELECT * FROM tb_users_cbt
          INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
          INNER JOIN tb_test ON tb_test.test_id = tb_users_status.test_id
          WHERE tb_users_cbt.username = '$username'";

    $result = $conn->query($query);

    while ($d = $result->fetch_assoc()) {
?>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
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
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Dashboards</li>
                            <li>
                                <a href="<?php echo $urlCbt ?>">
                                    <i class="metismenu-icon pe-7s-rocket"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Ujian</li>
                            <li>
                                <a href="<?php echo $urlExam ?>">
                                    <i class="metismenu-icon pe-7s-note"></i>
                                    Ujian
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Logout</li>
                            <li>
                                <a href="#" onclick="logout()">
                                    <i class="metismenu-icon pe-7s-back"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        <?php }
} else if ($_SESSION['level'] == "admin") {

    $query = "SELECT * FROM tb_users_cbt
WHERE username = '$username'";

    $result = $conn->query($query);

    while ($d = $result->fetch_assoc()) {
        ?>
            <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
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
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>
                    <div class="scrollbar-sidebar">
                        <div class="scrollbar-sidebar">
                            <div class="app-sidebar__inner">
                                <ul class="vertical-nav-menu">
                                    <li class="app-sidebar__heading">Dashboards</li>
                                    <li>
                                        <a href="<?php echo $urlCbt ?>">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="app-sidebar__heading">Data Ujian</li>
                                    <li>
                                        <a href="data">
                                            <i class="metismenu-icon pe-7s-note"></i>
                                            Data Ujian
                                        </a>
                                        <a href="ujian">
                                            <i class="metismenu-icon pe-7s-note2"></i>
                                            Ujian Aktif
                                        </a>
                                    </li>
                                    <li class="app-sidebar__heading">Data Peserta</li>
                                    <li>
                                        <a href="users">
                                            <i class="metismenu-icon pe-7s-users"></i>
                                            Data Peserta
                                        </a>
                                    </li>
                                    <li class="app-sidebar__heading">Logout</li>
                                    <li>
                                        <a href="#" onclick="logout()">
                                            <i class="metismenu-icon pe-7s-back"></i>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
} ?>