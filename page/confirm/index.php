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
                <div class="app-main__inner">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Data Ujian</h5>
                                <form action="<?php echo $urlConfig . 'soal?tes_id=' . $test_id ?>" method="post" class="needs-validation" novalidate>
                                    <table class="mb-0 table table-bordered text-start">
                                        <thead>
                                            <?php
                                            $query2 = "SELECT * FROM tb_test 
                                            INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
                                            WHERE tb_test.test_id = '$test_id'";
                                            $result2 = $conn->query($query2);
                                            while ($row2 = $result2->fetch_assoc()) {
                                                if ($row['work_status'] == '1') {
                                                    header('location: ../finish/?tes_id=' . $test_id . '&mes=finish');
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
                                                        <?php if ($row2['cbt_token'] != '') { ?>
                                                            <marquee direction="down">
                                                                <h6 class="badge bg-success text-white">TERSEDIA</h6>
                                                            </marquee>
                                                        <?php } else { ?>
                                                            <span class="badge bg-danger text-white">TIDAK TERSEDIA</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>TOKEN</th>
                                                    <td>
                                                        <input name="token" id="token" placeholder="Masukkan token ujian" type="text" class="form-control" autocomplete="off" required style="width:50%;">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </thead>
                                    </table>
                                    <div class="d-block text-center card-footer mt-3">
                                        <button type="submit" name="cekToken" class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button">Mulai
                                            Kerjakan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Silahkan kerjakan soal yang telah di siapkan. Harap dipatuhi
                                    peraturan berikut!</h5>
                                <ul>
                                    <li>Masukkan <strong>TOKEN</strong> Ujian yang diberikan oleh petugas</li>
                                    <li>Jangan menekan tombol selesai saat mengerjakan soal, kecuali saat anda telah selesai
                                        mengerjakan seluruh soal</li>
                                    <li>Perhatikan sisa waktu ujian, sistem akan mengumpulkan jawaban saat waktu sudah
                                        selesai</li>
                                    <li>Waktu ujian akan dimulai saat tombol "<b>Mulai Kerjakan</b>" di klik</li>
                                    <li>Dilarang bekerjasama dengan teman</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
include '../template/script.php'; ?>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })
    </script>

    <?php
    if (isset($_GET['mes'])) {
        if ($_GET['mes'] == 'token') {
    ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'TOKEN SALAH !',
                    text: "Token yang anda masukkan tidak tersedia",
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    window.location.href = "/page/confirm/?tes_id=<?php
                                                                    $test_id = $_GET['tes_id'];
                                                                    echo $test_id ?>";
                });
            </script>
        <?php
        } elseif ($_GET['mes'] == "huruf") {
        ?>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'TOKEN HANYA BERISI HURUF KAPITAL',
                    text: "Silahkan masukkan kembali token ujian",
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    window.location.href = "/page/confirm/?tes_id=<?php
                                                                    $test_id = $_GET['tes_id'];
                                                                    echo $test_id ?>";
                });
            </script>
        <?php
        } elseif ($_GET['mes'] == "gagalLogin") {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'LOGIN GAGAL',
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    window.location.href = "/";
                });
            </script>
    <?php
        }
    }
    ?>
    </body>

    </html>