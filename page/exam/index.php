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

$username = $_SESSION['username'];

$sql = "SELECT * FROM tb_users_cbt INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt WHERE tb_users_cbt.username = '$username'";
$res = $conn->query($sql);
while ($d = $res->fetch_array()) {
    $tesid = $d['test_id'];
}

$query = "SELECT * FROM tb_users_cbt
            INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
            INNER JOIN tb_test ON tb_users_status.test_id = tb_test.test_id
            INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
            INNER JOIN tb_cbt_users_date ON tb_cbt_users_date.id_users_cbt = tb_users_cbt.id_users_cbt
            WHERE tb_users_cbt.username = '$username' AND tb_users_status.test_id = '$tesid'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $no = 1;


    include '../template/head.php';
    include '../template/sidebar.php';


?>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Data Ujian</h5>
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
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $row['test_name'] ?></td>
                                <td><?php echo tgl_indo(date("Y-m-d", strtotime($row['users_cbt_date']))) ?></td>
                                <td><?php echo $row['cbt_timer'] . ' menit'; ?></td>
                                <td class="text-center">
                                    <?php if (date("Y-m-d") < $row['cbt_date_start']) { ?>
                                        <div class="badge badge-danger">BELUM DIMULAI</div>
                                    <?php } else if (date("Y-m-d") >= $row['cbt_date_start'] && date("Y-m-d") <= $row['cbt_date_end']) { ?>
                                        <?php if ($row['exam_status'] == 'TERDAFTAR') { ?>
                                            <span class="badge bg-info text-white">Terdaftar</span>
                                        <?php } elseif ($row['exam_status'] == 'FINISH') { ?>
                                            <span class="badge bg-success text-white">Selesai</span>
                                        <?php } elseif ($row['exam_status'] == 'TIMEOUT') { ?>
                                            <span class="badge bg-warning">Waktu Habis</span>
                                        <?php } elseif ($row['exam_status'] == 'VIOLATION') { ?>
                                            <span class="badge bg-danger text-white">Pelanggaran</span>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="badge badge-success">UJIAN TELAH SELESAI</div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php
                                    if (date("Y-m-d") < $row['users_cbt_date']) { ?>
                                        <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" href="javascript:void(0);" onclick="belumDimulai()">Mulai
                                            Kerjakan</a>
                                    <?php } else if (date("Y-m-d") > $row['users_cbt_date']) { ?>
                                        <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" href="javascript:void(0);" onclick="sudahselesai()">Mulai
                                            Kerjakan</a>
                                    <?php } else if (empty($row['cbt_token']) || is_null($row['cbt_token'])) { ?>
                                        <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" href="javascript:void(0);" onclick="belumTersedia()">Mulai
                                            Kerjakan</a>
                                    <?php } else { ?>
                                        <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" href="<?php echo $urlConfirm . '?tes_id=' . $row['test_id']; ?>" id="startExam">Mulai Kerjakan</a>
                                    <?php } ?>
                                </td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }
include '../template/script.php';

if (isset($_GET['mes'])) {
    if ($_GET['mes'] == 'token') {
    ?>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'ANDA TIDAK DAPAT MENGAKSES HALAMAN INI',
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/exam/?";
            });
        </script>
    <?php
    }
    ?>
<?php
}

?>
<script>
    function sudahselesai() {
        Swal.fire({
            icon: 'warning',
            title: 'UJIAN TELAH SELESAI',
            text: 'Anda tidak dapat mengakses ujian ini karena jadwal ujian telah terlewat. Jika merasa belum mengikuti ujian silahkan untuk menghubungi panitia seleksi',
        });
    }

    function belumDimulai() {
        Swal.fire({
            icon: 'warning',
            title: 'UJIAN BELUM DIMULAI',
            text: 'Anda tidak dapat mengakses ujian ini karena jadwal ujian belum dimulai',
        });
    }

    function belumTersedia() {
        Swal.fire({
            icon: 'warning',
            title: 'UJIAN BELUM TERSEDIA',
            text: 'Anda tidak dapat mengakses ujian ini karena jadwal ujian belum tersedia',
        });
    }
</script>
</body>

</html>