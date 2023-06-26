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

$test_id = $_GET['tes_id'];

$username = $_SESSION['username'];

// hitung total peserta cbt
$cbtUser = mysqli_query($conn, "SELECT * FROM cbt_users WHERE level = 'user' AND sk_status='1'");
$totalCbtUser = mysqli_num_rows($cbtUser);

// hitung total cbt
$cbt = mysqli_query($conn, "SELECT * FROM cbt_test");
$totalCbt = mysqli_num_rows($cbt);

// hitung selesai cbt
$cbtEnd = mysqli_query($conn, "SELECT * FROM cbt_users WHERE level = 'user' AND work_status = '1'");
$totalEnd = mysqli_num_rows($cbtEnd);

$query = "SELECT * FROM cbt_users WHERE username = '$username'";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $query2 = "SELECT * FROM cbt_test WHERE test_id = '$test_id' ";
    $result2 = $conn->query($query2);
    while ($row2 = $result2->fetch_assoc()) {
        $test_id = $row2['test_id'];
        $query2 = "SELECT * FROM cbt_test WHERE test_id = '$test_id' ";
        $result2 = $conn->query($query2);
        while ($row2 = $result2->fetch_assoc()) {
            include '../template/head.php';
            include '../template/sidebar.php';


?>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Data Ujian</h5>
                                <table class="mb-0 table table-bordered text-start">
                                    <thead>
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
                                            <td><?php echo $row2['cbt_time'] . ' menit'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Peserta Ujian</th>
                                            <td><?php echo $totalCbtUser ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Soal</th>
                                            <td><?php echo $totalEnd ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="d-block card-footer mt-3">
                                    <h5>UPLOAD DATA SOAL</h5>
                                    <div class="mb-3">
                                        <input class="form-control" type="file" id="formFile" accept=".xlsx,.xls" style="width: 50%;">
                                    </div> <br>
                                    <a href="#" class="btn-shadow btn btn-info text-white" data-toggle="tooltip" data-placement="bottom" title="Upload Data Soal">
                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                            <i class="fa fa-file-upload fa-w-20"></i>
                                        </span>
                                        Import Data Soal
                                    </a>
                                    <a href="<?php echo $urlAsset ?>file/formatsoal.xls" download class="btn-shadow btn btn-info text-white">
                                        <span class="btn-icon-wrapper pr-2 opacity-7">
                                            <i class="fa fa-file-upload fa-w-20"></i>
                                        </span>
                                        Contoh data soal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php

            include '../template/script.php';
            ?>
            </body>

            </html>
<?php }
    }
} ?>