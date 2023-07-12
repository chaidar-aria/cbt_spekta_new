<?php

include '../../config/conn.php';
include '../../helper/url.php';

session_start();
// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../../?pesan=belum_login");
} else if ($_SESSION['level'] != "user") {
    header("location:../../?pesan=forbidden");
}

//set session dulu dengan nama $_SESSION["mulai"]
if (isset($_SESSION["mulai"])) {
    //jika session sudah ada
    $telah_berlalu = time() - $_SESSION["mulai"];
} else {
    //jika session belum ada
    $_SESSION["mulai"]  = time();
    $telah_berlalu      = 0;
}

$test_id = $_GET['tes_id'];
// $que_id = $_GET['que_id'];

// HALAMAN
$batas = 1;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$previous = $halaman - 1;
$next = $halaman + 1;

$data = mysqli_query($conn, "SELECT * FROM tb_question WHERE test_id = '$test_id'");
$jumlah_data = mysqli_num_rows($data);
$total_halaman = ceil($jumlah_data / $batas);

$username = $_SESSION['username'];


$query = "SELECT * FROM tb_users_cbt
          INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
          INNER JOIN tb_test ON tb_test.test_id = tb_users_status.test_id
          INNER JOIN tb_users_utilities ON tb_users_utilities.id_users_cbt = tb_users_cbt.id_users_cbt
          WHERE tb_users_cbt.username = '$username'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $id_users_cbt = $row['id_users_cbt'];
    $query2 = "SELECT * FROM tb_test WHERE test_id = '$test_id'";
    $result2 = $conn->query($query2);
    while ($row2 = $result2->fetch_assoc()) {
        $query3 = "SELECT * FROM tb_cbt_time WHERE test_id = '$test_id'";
        $result3 = $conn->query($query3);
        while ($row3 = $result3->fetch_assoc()) {

            $temp_waktu = ($row3['cbt_timer'] * 60) - $telah_berlalu; //dijadikan detik dan dikurangi waktu yang berlalu
            $temp_menit = (int)($temp_waktu / 60);                //dijadikan menit lagi
            $temp_detik = $temp_waktu % 60;                       //sisa bagi untuk detik

            if ($temp_menit < 60) {
                /* Apabila $temp_menit yang kurang dari 60 meni */
                $jam    = 0;
                $menit  = $temp_menit;
                $detik  = $temp_detik;
            } else {
                /* Apabila $temp_menit lebih dari 60 menit */
                $jam    = (int)($temp_menit / 60);    //$temp_menit dijadikan jam dengan dibagi 60 dan dibulatkan menjadi integer 
                $menit  = $temp_menit % 60;           //$temp_menit diambil sisa bagi ($temp_menit%60) untuk menjadi menit
                $detik  = $temp_detik;
            }


?>

            <!doctype html>
            <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta http-equiv="Content-Language" content="en">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>CBT SPEKTA</title>
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
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
                <link href="<?php echo $urlAsset ?>css/main.css" rel="stylesheet">
                <!-- Tambahkan CSS untuk mengatur video webcam -->
                <style>
                    .video-container {
                        position: relative;
                        width: 100%;
                        height: 0;
                        padding-top: 56.25%;
                        /* Untuk mengatur aspek rasio video (16:9) */
                    }

                    .video-frame {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                    }
                </style>

            </head>

            <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false" onmouseleave="mouseOut()">

                <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
                    <div class="app-header header-shadow">
                        <!-- Tempatkan video webcam di tengah atas halaman -->
                        <div class="video-container">
                            <video id="user-webcam" class="video-frame" autoplay></video>
                        </div>
                        <div class="app-header__content">
                            <div class="app-header-right">
                                <div class="header-btn-lg pr-0">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left  ml-3 header-user-info">
                                                <div class="widget-heading">
                                                    Nama Peserta: <?php echo $row['name']; ?>
                                                </div>
                                                <div class="widget-subheading">
                                                    Nomor Peserta: <?php echo $row['username']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="app-main">
                        <div class="app-sidebar sidebar-shadow">
                            <div class="scrollbar-sidebar">
                                <div class="app-sidebar__inner">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">CBT SPEKTA</h5>
                                        <h6 class="mb-0 card-subtitle"><?php echo $row2['test_name'] ?></h6>
                                    </div>
                                    <div class="image text-center">
                                        <?php if ($row['foto_users'] == NULL) { ?>
                                            <img src="<?php echo $urlAsset . 'images/bg_1.jpg' ?>" alt="img user" width="150">
                                        <?php } else { ?>
                                            <img src="<?php echo $urlAsset . 'images/user/' . $row['foto_users']; ?>" alt="img user" width="150">
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
                                        <div class="timer text-center">
                                            <h3>Waktu Ujian</h3>
                                            <h5 id="clock">00:00:00</h5>
                                        </div>
                                        <div class="button text-center mt-3">
                                            <a class="btn-shadow p-1 btn btn-danger btn-md text-white" role="button" onclick="endExam()" id="endExam">Akhiri Ujian</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="app-main__outer">
                            <div class="app-main__inner">
                                <div class="app-main__inner disable-select">
                                    <div class="col-lg-7">
                                        <div class="main-card card" style="width: 65rem;">
                                            <div class="card-body">
                                                <form action="<?php echo $urlConfig . 'answeruser.php?tes_id=' . $_GET['tes_id'] . "&user_id=" .  $row['id_users_cbt'] . "&page=" . $_GET['page'] ?>" class="needs-validation text-start" novalidate method="POST" id="formquiz">
                                                    <h5 class="card-title text-center">CBT SPEKTA</h5>
                                                    <h6 class="mb-0 card-subtitle text-center"><?php echo $row2['test_name'] ?></h6>
                                                    <?php

                                                    $query3 = "SELECT * FROM tb_question WHERE test_id = '$test_id' LIMIT $halaman_awal, $batas";
                                                    $result3 = $conn->query($query3);
                                                    while ($row3 = $result3->fetch_assoc()) {
                                                        $queid = $row3['que_id'];
                                                        if ($row['work_status'] == '1') {
                                                            $idtest = $row3['test_id'];
                                                            header('location: ../finish/?tes_id= ' . $idtest . '&mes=finish');
                                                        } ?>
                                                        <p class="card-text text-justify mt-md-3 ">
                                                            <?php echo $row3['que_desc'] ?>
                                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $row['id_users_cbt'] ?>">
                                                            <input type="hidden" name="que_id" id="que_id" value="<?php echo $queid ?>">
                                                        </p>
                                                        <!-- <?php
                                                                $sql = "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND que_id = '$queid' AND id_users_cbt = '$id_users_cbt'";
                                                                $result = $conn->query($sql);
                                                                if ($result->num_rows > 0) {
                                                                    $sql = "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND que_id = '$queid' AND id_users_cbt = '$id_users_cbt'";
                                                                    $result = $conn->query($sql);
                                                                    while ($d = mysqli_fetch_array($result)) {
                                                                        $userans = $d['user_answer'];
                                                                    }
                                                                } else {
                                                                    $userans = "";
                                                                }
                                                                ?> -->
                                                        <fieldset class="position-relative form-group">
                                                            <div class="position-relative form-check"><label class="form-check-label"><input name="answer" type="radio" class="form-check-input" value="A" <?php if ("A" == $userans) { ?> checked <?php } ?>>
                                                                    <?php echo $row3['ans1'] ?>
                                                                </label>
                                                            </div>
                                                            <div class="position-relative form-check"><label class="form-check-label"><input name="answer" type="radio" class="form-check-input" value="B" <?php if ("B" == $userans) { ?> checked <?php } ?>>
                                                                    <?php echo $row3['ans2'] ?>
                                                                </label>
                                                            </div>
                                                            <div class="position-relative form-check"><label class="form-check-label"><input name="answer" type="radio" class="form-check-input" value="C" <?php if ("C" == $userans) { ?> checked <?php } ?>>
                                                                    <?php echo $row3['ans3'] ?>
                                                                </label>
                                                            </div>
                                                            <div class="position-relative form-check"><label class="form-check-label"><input name="answer" type="radio" class="form-check-input" value="D" <?php if ("D" == $userans) { ?> checked <?php } ?>>
                                                                    <?php echo $row3['ans4'] ?>
                                                                </label>
                                                            </div>
                                                            <div class="position-relative form-check"><label class="form-check-label"><input name="answer" type="radio" class="form-check-input" value="E" <?php if ("E" == $userans) { ?> checked <?php } ?>>
                                                                    <?php echo $row3['ans5'] ?>
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                        <div class="d-flex justify-content-around">
                                                            <?php if ($row3['que_id'] == '1') { ?>
                                                                <div class="button text-center mt-3">
                                                                    <button class="btn-shadow p-1 btn btn-danger btn-md text-white" role="button" type="submit" name="prevque" id="prevque" disabled>SEBELUMNYA</button>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="button text-center mt-3">
                                                                    <button class="btn-shadow p-1 btn btn-danger btn-md text-white" role="button" type="submit" name="prevque" id="prevque">SEBELUMNYA</button>
                                                                </div>
                                                            <?php }

                                                            if ($halaman == $total_halaman) {
                                                            ?>
                                                                <div class="button text-center mt-3">
                                                                    <button class="btn-shadow p-1 btn btn-success btn-md text-white" role="button" type="submit" name="nextque" id="nextque" disabled>SELANJUTNYA</button>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="button text-center mt-3">
                                                                    <button class="btn-shadow p-1 btn btn-success btn-md text-white" role="button" type="submit" name="nextque" id="nextque">SELANJUTNYA</button>
                                                                </div>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="main-card card mt-3" style="width: 65rem;">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">NAVIGASI SOAL</h5>
                                                <nav>
                                                    <ul class="pagination justify-content-center">
                                                        <?php
                                                        for ($x = 1; $x <= $total_halaman; $x++) {
                                                        ?>
                                                            <li class="page-item"><a class="page-link" href="<?php echo "?tes_id=$test_id&page=$x" ?>"><?php echo $x; ?></a>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include '../template/script.php';
                ?>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
                <script src="<?php echo $urlAsset ?>scripts/jquery.idle.js"></script>

                <script>
                    function mouseOut() {

                        Swal.fire({
                            icon: 'warning',
                            title: 'PERINGATAN',
                            text: 'Anda meninggalkan ujian \n segala pelanggaran akan dilaporkan',
                        });
                    }

                    $(document).ready(function() {
                        /** Membuat Waktu Mulai Hitung Mundur Dengan 
                         * var detik;
                         * var menit;
                         * var jam;
                         */
                        var detik = <?= $detik; ?>;
                        var menit = <?= $menit; ?>;
                        var jam = <?= $jam; ?>;

                        /**
                         * Membuat function hitung() sebagai Penghitungan Waktu
                         */
                        function hitung() {
                            /** setTimout(hitung, 1000) digunakan untuk 
                             * mengulang atau merefresh halaman selama 1000 (1 detik) 
                             */
                            setTimeout(hitung, 1000);

                            /** Jika waktu kurang dari 1 menit maka Timer akan berubah menjadi warna merah */
                            if (menit < 1 && jam == 0) {
                                var peringatan = 'style="color:red"';
                            };

                            /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
                            $('#clock').html(
                                '<p align="center"' + peringatan + '>' + jam + ' : ' + menit +
                                ' : ' + detik + '</p><hr>'
                            );

                            /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
                            detik--;

                            /** Jika var detik < 0
                             * var detik akan dikembalikan ke 59
                             * Menit akan Berkurang 1
                             */
                            if (detik < 0) {
                                detik = 59;
                                menit--;

                                /** Jika menit < 0
                                 * Maka menit akan dikembali ke 59
                                 * Jam akan Berkurang 1
                                 */
                                if (menit < 0) {
                                    menit = 59;
                                    jam--;

                                    /** Jika var jam < 0
                                     * clearInterval() Memberhentikan Interval dan submit secara otomatis
                                     */

                                    if (jam < 0) {
                                        clearInterval(hitung);
                                        /** Variable yang digunakan untuk submit secara otomatis di Form */
                                        var frmSoal = document.getElementById("clock");
                                        window.location.href =
                                            "<?php echo $urlConfig . 'soal?timeout&tes_id=' . $_GET['tes_id'] . '&username=' . $username ?>";
                                    }
                                }
                            }
                        }
                        /** Menjalankan Function Hitung Waktu Mundur */
                        hitung();
                    });


                    document.getElementById("endExam");

                    function endExam() {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger",
                            },
                            buttonsStyling: false,
                        });

                        swalWithBootstrapButtons
                            .fire({
                                title: "Akhiri Ujian?",
                                text: "Apakah anda yakin ingin mengakhiri ujian",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Akhiri Ujian",
                                cancelButtonText: "Batalkan",
                                reverseButtons: true,
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Terima Kasih',
                                        text: 'Ujian anda telah disimpan',
                                    }).then(function() {
                                        window.location.href =
                                            "<?php echo $urlConfig . 'soal?endExam&tes_id=' . $_GET['tes_id'] . '&username=' . $username .  "&user_id=" .  $row['id_users_cbt']  ?>";
                                    });
                                }
                            });
                    }


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
                    })()
                </script>

            </body>

            </html>
<?php }
    }
}

?>