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

$query2 = "SELECT * FROM tb_test WHERE test_id = '$test_id' ";
$result2 = $conn->query($query2);
while ($row = $result2->fetch_assoc()) {
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
                                    <td><?php echo $row['test_name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Ujian</th>
                                    <td><?php echo tgl_indo(date("Y-m-d", strtotime($row['cbt_date_start']))) . ' ~ ' . tgl_indo(date("Y-m-d", strtotime($row['cbt_date_end']))); ?>
                                </tr>
                            </thead>
                        </table>
                        <div class="card-body">
                            <h5 class="card-title">UNGGAH SOAL</h5>
                            <form action="<?php echo $urlConfig ?>soal" method="post" enctype="multipart/form-data">
                                <div>
                                    <div class="form-group">
                                        <label for="name">UNGGAH SOAL</label>
                                        <input type="file" name="fileSoal" class="form-control" aria-describedby="basic-addon1" accept=".xlsx, .xls" required autocomplete="off">
                                        <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
                                    </div>
                                </div>
                                <div class="d-block text-center card-footer">
                                    <button type="submit" class="btn-wide btn btn-success" name="unggahSoal">UNGGAH
                                        DATA SOAL</button>
                                </div>
                                <div class="d-block text-center card-footer">
                                    <a href="<?php echo $urlFile . 'format soal.xlsx'; ?>" type="btn" class="btn-wide btn btn-info">UNDUH FORMAT UNGGAH DATA SOAL</a>
                                </div>
                            </form>
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
<?php
} ?>