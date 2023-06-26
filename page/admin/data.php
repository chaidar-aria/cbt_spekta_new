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

$query = "SELECT * FROM tb_users_cbt WHERE username = '$username'";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {

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
                                <?php

                                $no = 1;
                                $query2 = "SELECT * FROM tb_test INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id";
                                $result2 = $conn->query($query2);
                                while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row2['test_name'] ?></td>
                                    <td><?php echo tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row2['cbt_date_end']))); ?>
                                    </td>
                                    <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                    <td class="text-center">
                                        <?php if ($row2['cbt_status'] == '1') { ?>
                                            <span class="badge bg-success text-white">TERSEDIA</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger text-white">TIDAK TERSEDIA</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($row2['cbt_token'] != '' || NULL) { ?>
                                            <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" disabled onclick="sudahMulai()" id="sudahMulai">Edit
                                                Data</a>
                                        <?php } else { ?>
                                            <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" href="edit?tes_id=<?php echo $row2['test_id']; ?>">Edit Data</a>
                                        <?php } ?>
                                    </td>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer">
                        <a href="tambahdata" class="btn-wide btn btn-success">TAMBAH DATA UJIAN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }
include '../template/script.php'; ?>
<script>
    function sudahMulai() {
        Swal.fire({
            icon: 'warning',
            title: 'UJIAN SEDANG BERLANGSUNG',
            text: 'Data tidak dapat diubah',
        });
    }
</script>

</body>

</html>