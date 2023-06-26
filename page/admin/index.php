<?php

include '../../config/conn.php';
include '../../helper/url.php';

session_start();
// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../../?pesan=belum_login");
} else if ($_SESSION['level'] != "admin") {
    header("location:../../?pesan=forbidden");
}

$username = $_SESSION['username'];

// hitung total peserta cbt
$cbtUser = mysqli_query($conn, "SELECT * FROM tb_users_cbt 
                                INNER JOIN tb_level ON tb_level.id_users_cbt = tb_users_cbt.id_users_cbt
                                INNER JOIN tb_level_name ON tb_level.id_level_name = tb_level_name.id_level_name
                                WHERE tb_level_name.level_name = 'USER'");
$totalCbtUser = mysqli_num_rows($cbtUser);

// hitung total cbt
$cbt = mysqli_query($conn, "SELECT * FROM tb_test");
$totalCbt = mysqli_num_rows($cbt);

// hitung selesai cbt
$cbtEnd = mysqli_query($conn, "SELECT * FROM tb_users_cbt 
                                INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
                                INNER JOIN tb_level ON tb_level.id_users_cbt = tb_users_cbt.id_users_cbt
                                INNER JOIN tb_level_name ON tb_level.id_level_name = tb_level_name.id_level_name
                                WHERE tb_level_name.level_name = 'USER' AND tb_users_status.work_status = '1'");
$totalEnd = mysqli_num_rows($cbtEnd);

$query = "SELECT * FROM tb_users_cbt
WHERE username = '$username'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {

    include '../template/head.php';
    include '../template/sidebar.php';


?>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Peserta CBT </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span><?php echo $totalCbtUser ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total CBT</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span><?php echo $totalCbt ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Selesai CBT</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span><?php echo $totalEnd ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Data Diri Admin CBT</h5>
                    <div class="row mt-5">
                        <div class="col-xl-9">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Nomor Registrasi Admin</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php
                                        echo $row['no_regis_admin'];
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Nama Admin</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo $row['username']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }
include '../template/script.php'; ?>

</body>

</html>