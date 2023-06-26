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
$test_id = $_GET['test_id'];

// hitung total peserta cbt
$cbtUser = mysqli_query($conn, "SELECT * FROM tb_users_cbt 
                                INNER JOIN tb_level ON tb_level.id_users_cbt = tb_users_cbt.id_users_cbt
                                INNER JOIN tb_level_name ON tb_level.id_level_name = tb_level_name.id_level_name
                                INNER JOIN tb_users_status ON tb_users_status.id_users_cbt = tb_users_cbt.id_users_cbt
                                INNER JOIN tb_test ON tb_test.test_id = tb_users_status.test_id
                                WHERE tb_level_name.level_name = 'USER' AND tb_test.test_id='$test_id'");
$totalCbtUser = mysqli_num_rows($cbtUser);

// hitung total cbt
$cbt = mysqli_query($conn, "SELECT * FROM tb_test");
$totalCbt = mysqli_num_rows($cbt);

// hitung selesai cbt
$cbtEnd = mysqli_query($conn, "SELECT * FROM tb_users_cbt 
                                INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
                                INNER JOIN tb_level ON tb_level.id_users_cbt = tb_users_cbt.id_users_cbt
                                INNER JOIN tb_level_name ON tb_level.id_level_name = tb_level_name.id_level_name
                                INNER JOIN tb_test ON tb_test.test_id = tb_users_status.test_id
                                WHERE tb_level_name.level_name = 'USER' AND tb_users_status.work_status = '1'AND tb_test.test_id='$test_id'");
$totalEnd = mysqli_num_rows($cbtEnd);

$query = "SELECT * FROM tb_users_cbt WHERE username = '$username'";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $query2 = "SELECT * FROM tb_test
    INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
    WHERE tb_cbt_time.test_id = '$test_id'";
    $result2 = $conn->query($query2);
    while ($row2 = $result2->fetch_assoc()) {
        $test_id = $row2['test_id'];
        include '../template/head.php';
        include '../template/sidebar.php';


?>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Data Ujian</h5>
                            <form action="<?php echo $urlConfig ?>soal" method="post" class="needs-validation" novalidate>
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
                                            <td><?php echo $row2['cbt_timer'] . ' menit'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Peserta Ujian</th>
                                            <td><?php echo $totalCbtUser ?></td>
                                        </tr>
                                        <tr>
                                            <th>Selesai Ujian</th>
                                            <td><?php echo $totalEnd ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status Ujian</th>
                                            <td>
                                                <?php if ($row2['cbt_token'] != '') { ?>
                                                    <marquee direction="down">
                                                        <h6 class="badge bg-success text-white">DIMULAI</h6>
                                                    </marquee>
                                                <?php } else { ?>
                                                    <span class="badge bg-danger text-white">BELUM DIMULAI</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TOKEN</th>
                                            <td>
                                                <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
                                                <input name="token" id="token" type="text" class="form-control" autocomplete="off" required style="width:50%;" value="<?php echo $row2['cbt_token'] ?>" disabled>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="d-block text-center card-footer mt-3">
                                    <h4>WAKTU TOKEN OTOMATIS</h4>
                                    <h5 id="Timer"></h5>
                                    <br>
                                    <button type="submit" class="btn-shadow p-1 btn btn-info btn-sm text-white" role="button" name="buatToken">Buat Token Ujian</button>
                                    <button type="submit" class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" name="hapusToken">Hapus Token Ujian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php

        include '../template/script.php';
        ?>
        <script>
            var timeLeft = 300;
            var elem = document.getElementById('Timer');

            var timerId = setInterval(countdown, 1000);

            function countdown() {
                if (timeLeft == 0) {
                    clearInterval(timerId);
                    window.location = "<?php echo $urlConfig . 'soal?resetToken&test_id=' . $test_id ?>"
                    doSomething();
                } else {
                    elem.innerHTML = timeLeft + ' detik';
                    timeLeft--;
                }
            }
        </script>
        </body>

        </html>
<?php }
} ?>