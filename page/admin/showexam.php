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
$test_id = $_GET['tes_id'];

$query = "SELECT * FROM tb_users_cbt
            INNER JOIN tb_users_utilities ON tb_users_cbt.id_users_cbt = tb_users_utilities.id_users_cbt
            INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
            INNER JOIN tb_test ON tb_users_status.test_id = tb_test.test_id
            INNER JOIN tb_cbt_grade ON tb_users_cbt.id_users_cbt = tb_cbt_grade.id_users_cbt
            INNER JOIN tb_cbt_users_date ON tb_cbt_users_date.id_users_cbt = tb_users_cbt.id_users_cbt
            WHERE tb_users_cbt.id_users_cbt = '$user_id'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {

    include '../template/head.php';
    include '../template/sidebar.php';
    $query2 = "SELECT * FROM tb_test WHERE test_id = '$test_id'";
    $result2 = $conn->query($query2);
    while ($row2 = $result2->fetch_assoc()) {

?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Data Diri Peserta CBT</h5>
                        <div class="row mt-5">
                            <div class="col-xl-6">
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
                                            <td><?php echo tgl_indo(date("Y-m-d", strtotime($row['users_cbt_date']))) ?></td>
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
                            <div class="col-xl-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-md-right">NILAI</label>
                                    <div class="col-sm-8">
                                        <?php if ($row['grade'] <= 50) { ?>
                                            <h1 class="mt-2 tx-medium text-danger ">
                                                <?php echo $row['grade'] ?>
                                            </h1>
                                        <?php } else if ($row['grade'] > 50 && $row['grade'] <= 80) { ?>
                                            <h1 class="mt-2 tx-medium text-warning">
                                                <?php echo $row['grade'] ?>
                                            </h1>
                                        <?php } else if ($row['grade'] > 80) { ?>
                                            <h1 class="mt-2 tx-medium text-success">
                                                <?php echo $row['grade'] ?>
                                            </h1>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card card">
                    <div class="card-body">
                        <h5 class="card-title text-center">CBT SPEKTA</h5>
                        <h6 class="mb-0 card-subtitle text-center"><?php echo $row2['test_name'] ?></h6>
                        <?php
                        $query3 = "SELECT * FROM tb_question WHERE test_id = '$test_id'";
                        $result3 = $conn->query($query3);
                        while ($row3 = $result3->fetch_assoc()) {
                            $que_id = $row3['que_id'];
                            $trueans = $row3['true_ans'];
                            $sql = "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND que_id = '$que_id' AND id_users_cbt = '$user_id'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $sql = "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND que_id = '$que_id' AND id_users_cbt = '$user_id'";
                                $result = $conn->query($sql);
                                while ($d = mysqli_fetch_array($result)) {
                                    $userans = $d['user_answer'];
                                }
                            } else {
                                $userans = "";
                            }
                        ?>
                            <p class="card-text text-justify mt-md-3 ">
                                <?php echo $row3['que_desc'] ?>
                            </p>
                            <fieldset class="position-relative form-group" disabled>
                                <div class="position-relative form-check">
                                    <label class="form-check-label">
                                        <?php if ($trueans == 'A') { ?>
                                            <div class="alert alert-success" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="A">
                                                <?php
                                                echo $row3['ans1'];
                                                if ($trueans == $userans) {
                                                    echo '<br>JAWABAN PESERTA SESUAI KUNCI';
                                                } else {
                                                    echo '<br>KUNCI JAWABAN';
                                                }
                                                ?>
                                            </div>
                                        <?php } else if ($userans == "A") { ?>
                                            <div class="alert alert-warning" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="A">
                                                <?php echo $row3['ans1'] ?> JAWABAN PESERTA
                                            </div>
                                        <?php } else if ($trueans ==  $userans) { ?>
                                            <div class="alert alert-success" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="A">
                                                <?php echo $row3['ans1'] ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="A">
                                                <?php echo $row3['ans1'] ?>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </div>
                                <div class="position-relative form-check">
                                    <label class="form-check-label">
                                        <?php if ($trueans == 'B') { ?>
                                            <div class="alert alert-success" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="B">
                                                <?php
                                                echo $row3['ans2'];
                                                if ($trueans == $userans) {
                                                    echo '<br>JAWABAN PESERTA SESUAI KUNCI';
                                                } else {
                                                    echo '<br>KUNCI JAWABAN';
                                                }
                                                ?>
                                            </div>
                                        <?php } else if ($userans == "B") { ?>
                                            <div class="alert alert-warning" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="B">
                                                <?php echo $row3['ans2'] ?> JAWABAN PESERTA
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="B">
                                                <?php echo $row3['ans2'] ?>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </div>
                                <div class="position-relative form-check">
                                    <label class="form-check-label">
                                        <?php if ($trueans == 'C') { ?>
                                            <div class="alert alert-success" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="C">
                                                <?php
                                                echo $row3['ans3'];
                                                if ($trueans == $userans) {
                                                    echo '<br>JAWABAN PESERTA SESUAI KUNCI';
                                                } else {
                                                    echo '<br>KUNCI JAWABAN';
                                                }
                                                ?>
                                            </div>
                                        <?php } else if ($userans == "C") { ?>
                                            <div class="alert alert-warning" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="C">
                                                <?php echo $row3['ans3'] ?> JAWABAN PESERTA
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="C">
                                                <?php echo $row3['ans3'] ?>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </div>
                                <div class="position-relative form-check">
                                    <label class="form-check-label">
                                        <?php if ($trueans == 'D') { ?>
                                            <div class="alert alert-success" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="D">
                                                <?php
                                                echo $row3['ans4'];
                                                if ($trueans == $userans) {
                                                    echo '<br>JAWABAN PESERTA SESUAI KUNCI';
                                                } else {
                                                    echo '<br>KUNCI JAWABAN';
                                                }
                                                ?>
                                            </div>
                                        <?php } else if ($userans == "D") { ?>
                                            <div class="alert alert-warning" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="D">
                                                <?php echo $row3['ans4'] ?> JAWABAN PESERTA
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="D">
                                                <?php echo $row3['ans4'] ?>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </div>
                                <div class="position-relative form-check">
                                    <label class="form-check-label">
                                        <?php if ($trueans == 'E') { ?>
                                            <div class="alert alert-success" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="E">
                                                <?php
                                                echo $row3['ans5'];
                                                if ($trueans == $userans) {
                                                    echo '<br>JAWABAN PESERTA SESUAI KUNCI';
                                                } else {
                                                    echo '<br>KUNCI JAWABAN';
                                                }
                                                ?>
                                            </div>
                                        <?php } else if ($userans == "E") { ?>
                                            <div class="alert alert-warning" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="E">
                                                <?php echo $row3['ans5'] ?> JAWABAN PESERTA
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <input name="answer" type="radio" class="form-check-input" value="E">
                                                <?php echo $row3['ans5'] ?>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </div>
                            </fieldset>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>

<?php }
}
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