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
$user_id = $_GET['user_id'];

$query = "SELECT * FROM tb_users_cbt
            INNER JOIN tb_users_utilities ON tb_users_cbt.id_users_cbt = tb_users_utilities.id_users_cbt
            INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
            INNER JOIN tb_test ON tb_users_status.test_id = tb_test.test_id
            WHERE tb_users_cbt.id_users_cbt = '$user_id'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {

    include '../template/head.php';
    include '../template/sidebar.php';
?>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Data Diri Peserta CBT</h5>
                    <div class="row mt-5">
                        <div class="col-xl-9">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Nomor Peserta</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo $row['username']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Nama Peserta</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo $row['name']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Tempat
                                    Lahir</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo $row['birth_place']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Tanggal Lahir</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo tgl_indo($row['birth_date']); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php if ($row['gender'] == 'L') { ?>
                                            LAKI-LAKI
                                        <?php } else if ($row['gender'] == 'P') { ?>
                                            PEREMPUAN
                                        <?php } ?> </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-3">
                            <div class="image text-center">
                                <?php if ($row['foto_users'] == NULL) { ?>
                                    <img src="<?php echo $urlSpekta . 'assets/img/Logo SS.png' ?>" alt="img user" width="200">
                                <?php } else { ?>
                                    <img src="<?php echo $urlSpekta . 'assets/img/user/' . $row['foto_users']; ?>" alt="img user" width="200">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">DATA UJIAN YANG DIIKUTI</h5>
                    <table class="mb-0 table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Ujian</th>
                                <th>Tanggal Ujian</th>
                                <th>Durasi Ujian</th>
                                <th>Status Ujian</th>
                                <th>Nilai Ujian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query2 = "SELECT * FROM tb_test 
                                INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
                                INNER JOIN tb_users_status ON tb_test.test_id = tb_users_status.test_id
                                INNER JOIN tb_users_cbt ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
                                LEFT JOIN tb_cbt_grade ON tb_users_cbt.id_users_cbt = tb_cbt_grade.id_users_cbt AND tb_cbt_grade.test_id = tb_test.test_id
                                WHERE tb_users_cbt.id_users_cbt = '$user_id'";
                            $result2 = $conn->query($query2);
                            while ($row2 = $result2->fetch_assoc()) {
                                $examStatus = $row2['exam_status'];
                                $grade = $row2['grade'];
                            ?>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $row2['test_name'] ?></td>
                                <td><?php echo tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_end']))); ?>
                                </td>
                                <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                <td class="text-center">
                                    <?php if ($examStatus == 'TERDAFTAR') { ?>
                                        <span class="badge bg-info text-white">Terdaftar</span>
                                    <?php } elseif ($examStatus == 'FINISH') { ?>
                                        <span class="badge bg-success text-white">Selesai</span>
                                    <?php } elseif ($examStatus == 'TIMEOUT') { ?>
                                        <span class="badge bg-warning">Waktu Habis</span>
                                    <?php } elseif ($examStatus == 'VIOLATION') { ?>
                                        <span class="badge bg-danger text-white">Pelanggaran</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $grade ? $grade : "Belum ada nilai"; ?></td>
                                <td>
                                    <?php if ($examStatus == 'TERDAFTAR') { ?>
                                        <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" disabled onclick="belumSelesai()" id="belumSelesai">DETAIL</a>
                                    <?php } else { ?>
                                        <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" href="showexam?<?php echo "user_id=" . $_GET['user_id'] . "&tes_id=" . $row2['test_id']; ?>">DETAIL</a>
                                    <?php } ?>
                                </td>
                        </tbody>
                    <?php } ?>
                    </table>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">DATA UJIAN YANG DAPAT DIIKUTI</h5>
                    <table class="mb-0 table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Ujian</th>
                                <th>Tanggal Ujian</th>
                                <th>Durasi Ujian</th>
                                <th>Status Ujian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query3 = "SELECT * FROM tb_test 
                                INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id";
                            $result2 = $conn->query($query3);
                            while ($row2 = $result2->fetch_assoc()) {
                                // Periksa apakah user terdaftar di tb_users_status
                                $query4 = "SELECT * FROM tb_users_status WHERE test_id = '" . $row2['test_id'] . "' AND id_users_cbt = '$user_id'";
                                $result3 = $conn->query($query4);
                                $isUserRegistered = $result3->num_rows > 0;

                                // Tampilkan data ujian yang sesuai berdasarkan status user
                                if (!$isUserRegistered) {
                                    // Data ujian yang belum diikuti
                            ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $row2['test_name'] ?></td>
                                        <td><?php echo tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_end']))); ?></td>
                                        <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                        <td class="text-center">
                                            <?php if ($row2['cbt_status'] == '1') { ?>
                                                <span class="badge bg-success text-white">TERSEDIA</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger text-white">TIDAK TERSEDIA</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($row2['cbt_status'] == '1') { ?>
                                                <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" name="ikutUjian" data-testid="<?php echo $row2['test_id']; ?>" data-userid="<?php echo $_GET['user_id']; ?>">IKUTKAN</a>
                                            <?php } else { ?>
                                                <a class=" btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" disabled onclick="tidakTersedia(this.getAttribute('data-testname'))" data-testname="<?php echo $row2['test_name']; ?>">IKUTKAN</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } else {
                                    // Data ujian yang sudah diikuti
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $row2['test_name'] ?></td>
                                        <td><?php echo tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_end']))); ?></td>
                                        <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                        <td class=" text-center">
                                            <span class="badge bg-primary text-white">DIKUTI</span>
                                        </td>
                                        <td>
                                            <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" disabled onclick="sudahDiikuti()" id="belumSelesai">IKUTKAN</a>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php }
include '../template/script.php'; ?>
<script>
    document.getElementById("belumSelesai");

    function belumSelesai() {
        Swal.fire({
            icon: 'warning',
            title: 'PERINGATAN',
            text: 'UJIAN BELUM TERSELESAIKAN',
        })

    }

    function sudahDiikuti() {
        Swal.fire({
            icon: 'warning',
            title: 'PERINGATAN',
            text: 'TIDAK DIPERBOLEHKAN MENGIKUTI DUA KALI!',
        })

    }

    function tidakTersedia(testName) {
        Swal.fire({
            icon: 'warning',
            title: 'PERINGATAN',
            text: 'UJIAN BELUM BISA DIAMBIL, SILAKAN AKTIFKAN UJIAN ' + testName,
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var ikutUjianBtns = document.getElementsByName('ikutUjian');
        for (var i = 0; i < ikutUjianBtns.length; i++) {
            ikutUjianBtns[i].addEventListener('click', function() {
                var testId = this.getAttribute('data-testid');
                var userId = this.getAttribute('data-userid');
                updateDatabase(testId, userId);
            });
        }

        function updateDatabase(testId, userId) {
            // Kirim permintaan AJAX ke file PHP yang akan mengupdate tabel di database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../config/soal.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Permintaan berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'BERHASIL',
                            text: 'PESERTA AKAN DIIKUTKAN UJIAN INI'
                        }).then(function() {
                            // Setelah alert ditutup, lakukan auto refresh
                            location.reload();
                        });
                    } else {
                        // Permintaan gagal
                        Swal.fire({
                            icon: 'error',
                            title: 'GAGAL',
                            text: 'Terjadi kesalahan saat memperbarui data'
                        });
                    }
                }
            };
            xhr.send('testId=' + encodeURIComponent(testId) + '&userId=' + encodeURIComponent(userId));
        }
    });
</script>

</body>

</html>