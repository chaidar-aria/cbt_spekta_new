<?php

include '../../config/conn.php';
include '../../helper/url.php';
include '../../helper/dateIndo.php';

session_start();
// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../../?pesan=belum_login");
} else if ($_SESSION['level'] != "user") {
    header("location:../../?pesan=forbidden");
}


$test_id = $_GET['tes_id'];

$username = $_SESSION['username'];

$query = "SELECT * FROM tb_users_cbt
          INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
          INNER JOIN tb_test ON tb_test.test_id = tb_users_status.test_id
          INNER JOIN tb_users_utilities ON tb_users_utilities.id_users_cbt = tb_users_cbt.id_users_cbt
          WHERE tb_users_cbt.username = '$username'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {


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

        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <img src="<?php echo $urlAsset ?>images/logo.png" alt="logo" width="150">
                </div>
            </div>
            <div class="app-main">
                <div class="row">
                    <div class="col-sm-5 mt-5">
                        <div class="main-card mt-3 ml-5 card" style="width: 20rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title">CBT SPEKTA</h5>
                                <h6 class="mb-0 card-subtitle"><?php echo $row['test_name'] ?></h6>
                            </div>
                            <div class="image text-center">
                                <?php if ($row['foto_users'] == NULL) { ?>
                                    <img src="<?php echo $urlSpekta . 'assets/img/logo SS.png' ?>" alt="img user" width="150">
                                <?php } else { ?>
                                    <img src="<?php echo $urlSpekta . 'assets/img/user/' . $row['foto_users']; ?>" alt="img user" width="150">
                                <?php } ?>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label text-md-right">Nomor Peserta</label>
                                    <div class="col-sm-7">
                                        <p class="mg-t-8 tx-medium mt-2"><?php echo $row['username']; ?></p>
                                    </div>
                                    <label class="col-sm-5 col-form-label text-md-right">Nama Peserta</label>
                                    <div class="col-sm-7">
                                        <p class="mg-t-8 tx-medium mt-2"><?php echo $row['name']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-main__inner disable-select">
                    <div class="col-lg-7">
                        <div class="main-card card" style="width: 65rem;">
                            <div class="card-body">
                                <h5 class="card-title">Data Ujian</h5>
                                <table class="mb-0 table table-bordered text-start">
                                    <thead>
                                        <?php
                                        $query2 = "SELECT * FROM tb_test 
                                                    INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
                                                    WHERE tb_test.test_id = '$test_id'
                                        ";
                                        $result2 = $conn->query($query2);
                                        while ($row2 = $result2->fetch_assoc()) {
                                            $idtest = $row2['test_id'];
                                            if ($row['work_status'] == '0') {
                                                header('location: ../confirm/?tes_id= ' . $idtest);
                                            }

                                        ?>
                                            <tr>
                                                <th>Nama Ujian</th>
                                                <td><?php echo $row2['test_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Ujian</th>
                                                <td><?php echo tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_end']))); ?>
                                            </tr>
                                            <tr>
                                                <th>Durasi Ujian</th>
                                                <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status Ujian</th>
                                                <td>
                                                    <?php if ($row['exam_status'] == 'TERDAFTAR') { ?>
                                                        <span class="badge bg-info text-white">Terdaftar</span>
                                                    <?php } elseif ($row['exam_status'] == 'FINISH') { ?>
                                                        <span class="badge bg-success text-white">Selesai</span>
                                                    <?php } elseif ($row['exam_status'] == 'TIMEOUT') { ?>
                                                        <span class="badge bg-warning">Waktu Habis</span>
                                                    <?php } elseif ($row['exam_status'] == 'VIOLATION') { ?>
                                                        <span class="badge bg-danger text-white">Pelanggaran</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </thead>
                                </table>
                                <div class="d-block text-center card-footer mt-3">
                                    <a class="btn-shadow p-1 btn btn-info text-white" role="button" onclick="saveExam()" id="saveExam">LOGOUT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo $urlAsset ?>scripts/alert.js"></script>
        <?php
        include '../template/script.php'; ?>


        <script>
            document.getElementById("saveExam");

            function saveExam() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger",
                    },
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons
                    .fire({
                        title: "Terima Kasih",
                        text: "Ujian anda telah tersimpan, silahkan Log Out dari CBT",
                        icon: "success",
                        showCancelButton: false,
                        confirmButtonText: "Keluar",
                        reverseButtons: true,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo $urlConfig ?>logout.php";
                        }
                    });
            }
            window.location.hash = "";

            // Again because Google Chrome doesn't insert
            // the first hash into the history
            window.location.hash = "";

            window.onhashchange = function() {
                window.location.hash = "";
            }
        </script>

        <?php
        if (isset($_GET['mes'])) {
            if ($_GET['mes'] == 'finish') {
        ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'UJIAN TELAH SELESAI',
                        text: "Anda telah menyelesaikan ujian ini",
                        showConfirmButton: false,
                        timer: 4000
                    }).then((result) => {
                        window.location.href =
                            "/page/finish/?tes_id=<?php
                                                    $idtest = $_GET['tes_id'];
                                                    echo $idtest ?>";
                    });
                </script>
            <?php
            } elseif ($_GET['mes'] == "timeout") {
            ?>
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'WAKTU ANDA HABIS',
                        text: "Ujian anda telah tersimpan",
                        showConfirmButton: false,
                        timer: 4000
                    }).then((result) => {
                        window.location.href = "/page/finish/?tes_id=<?php
                                                                        $idtest = $_GET['tes_id'];
                                                                        echo $idtest ?>";
                    });
                </script>
            <?php
            } elseif ($_GET['mes'] == "disqualified") {
            ?>
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'ANDA DIDISKUALIFIKASI',
                        text: "Anda melakukan pelanggaran selama ujian berlangsung",
                        showConfirmButton: false,
                        timer: 4000
                    }).then((result) => {
                        window.location.href = "/page/finish/";
                    });
                </script>
        <?php
            }
        }
        ?>

    </body>

    </html>
<?php }
?>