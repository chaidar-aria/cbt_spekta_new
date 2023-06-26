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
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Agenda Ujian</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo $row['test_name'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Tanggal Ujian</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo tgl_indo($row['users_cbt_date']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-md-right">Waktu Ujian</label>
                                <div class="col-sm-8">
                                    <p class="mt-2 tx-medium">
                                        <?php echo $row['cbt_time_start'] . '~' . $row['cbt_time_end'] ?>
                                    </p>
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
                                    WHERE tb_users_cbt.id_users_cbt = '$user_id'";
                            $result2 = $conn->query($query2);
                            while ($row2 = $result2->fetch_assoc()) {
                            ?>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $row2['test_name'] ?></td>
                                <td><?php echo tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_end']))); ?>
                                </td>
                                <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                <td class="text-center">
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
                                <td><?php
                                    if ($row['exam_status'] == 'TERDAFTAR') {
                                        echo "--";
                                    } else {
                                        echo $row2['grade'];
                                    }
                                    ?></td>
                                <td>
                                    <?php if ($row['exam_status'] == 'TERDAFTAR') { ?>
                                        <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" disabled onclick="belumSelesai()" id="belumSelesai">DETAIL</a>
                                    <?php } else { ?>
                                        <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" href="showexam?<?php echo "user_id=" . $_GET['user_id'] . "&tes_id= " . $row2['test_id']; ?>">DETAIL</a>
                                    <?php } ?>
                                </td>
                        </tbody>
                    <?php } ?>
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
</script>

</body>

</html>