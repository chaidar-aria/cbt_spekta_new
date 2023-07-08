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

$query = "SELECT * FROM tb_test 
        INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
        WHERE tb_test.test_id = '$test_id'";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {

    include '../template/head.php';
    include '../template/sidebar.php';


?>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-pen icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        EDIT DATA <?php echo $row['test_name'] ?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <ol class="float-sm-right">
                        <form action="<?php echo $urlConfig . 'soal?tes_id=' . $test_id ?>" method="post">
                            <?php if ($row['cbt_status'] == '1') { ?>
                                <button type="submit" name="queoff" class="btn-shadow btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Klik untuk menonaktifkan">
                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                        <i class="fa fa-check fa-w-20"></i>
                                    </span>
                                    <input type="hidden" name="test_id" value="<?php echo $row['test_id']; ?>">
                                    Nonaktifkan Ujian
                                </button>
                            <?php } else { ?>
                                <button type="submit" name="queon" class="btn-shadow btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Klik untuk mengaktifkan">
                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                        <i class="fa fa-times fa-w-20"></i>
                                    </span>
                                    <input type="hidden" name="test_id" value="<?php echo $row['test_id']; ?>">
                                    Aktifkan Ujian
                                </button>
                            <?php } ?>
                        </form>
                    </ol>
                </div><!-- /.col -->
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">EDIT DATA UJIAN</h5>
                        <form action="<?php echo $urlConfig ?>soal" method="post">
                            <div>
                                <div class="form-group">
                                    <label for="name">NAMA UJIAN</label>
                                    <input type="hidden" name="test_id" value="<?php echo $row['test_id']; ?>">
                                    <input type="text" name="test_name" class="form-control" placeholder="Nama Ujian" aria-label="Nama Ujian" aria-describedby="basic-addon1" required autocomplete="off" value="<?php echo $row['test_name'] ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="cbt_start">TANGGAL MULAI UJIAN</label>
                                    <input type="date" name="cbt_date_start" class="form-control" placeholder="Tanggal Mulai Ujian" aria-label="Tanggal Mulai Ujian" aria-describedby="basic-addon1" required autocomplete="off" value="<?php echo $row['cbt_date_start'] ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="cbt_end">TANGGAL AKHIR UJIAN</label>
                                    <input type="date" name="cbt_date_end" class="form-control" placeholder="Tanggal Selesai Ujian" aria-label="Tanggal Selesi Ujian" aria-describedby="basic-addon1" required autocomplete="off" value="<?php echo $row['cbt_date_end'] ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">DURASI UJIAN</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">DALAM MENIT</span>
                                        <input type="number" name="cbt_timer" class="form-control" placeholder="Durasi Ujian" aria-label="Durasi Ujian" aria-describedby="basic-addon1" required autocomplete="off" value="<?php echo $row['cbt_timer'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="d-block text-center card-footer">
                                <button type="submit" class="btn-wide btn btn-success" name="editData">EDIT
                                    DATA UJIAN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h5 class="m-0">Data Ujian</h5>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <table class="mb-0 table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Soal</th>
                                    <th>Jawaban A</th>
                                    <th>Jawaban B</th>
                                    <th>Jawaban C</th>
                                    <th>Jawaban D</th>
                                    <th>Jawaban E</th>
                                    <th>Jawaban Benar</th>
                                    <th>Skor Soal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query2 = "SELECT * FROM tb_question WHERE test_id = '$test_id'";
                                $result2 = $conn->query($query2);
                                while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row2['que_desc'] ?></td>
                                    <td><?php echo $row2['ans1'] ?></td>
                                    <td><?php echo $row2['ans2'] ?></td>
                                    <td><?php echo $row2['ans3'] ?></td>
                                    <td><?php echo $row2['ans4'] ?></td>
                                    <td><?php echo $row2['ans5'] ?></td>
                                    <td><?php echo $row2['true_ans'] ?></td>
                                    <td><?php echo $row2['que_score'] ?></td>
                                    <td>
                                        <a class="btn-shadow p-1 btn btn-danger btn-sm text-white" role="button" href="editsoal?tes_id=<?php echo $test_id . '&que_id=' . $row2['que_id'] ?>">Edit
                                            Data</a>
                                    </td>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer">
                        <a href="tambahsoal?tes_id=<?php echo $test_id ?>" class="btn-wide btn btn-success">TAMBAH SOAL</a>
                        <a href="uploadsoal?tes_id=<?php echo $test_id ?>" class="btn-wide btn btn-info">UNGGAH SOAL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }
include '../template/script.php';
if (isset($_GET['mes'])) {
    if ($_GET['mes'] == 'gagal') {
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'LOGIN GAGAL !',
                text: "Saat ini sistem sedang sibuk atau sedang ada perbaikan, mohon untuk mengulangi dalam 5 menit",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "berhasilEdit") {
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL EDIT !',
                text: "Soal berhasil diedit",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "berhasilTambah") {
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL TAMBAH !',
                text: "Penambahan soal berhasil",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "berhasilHapus") {
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL HAPUS !',
                text: "Soal berhasil dihapus",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "on") {
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL AKTIF !',
                text: "Ujian Aktif",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "off") {
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL MENONAKTIFKAN !',
                text: "Ujian Nonaktif",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "onlyone") {
    ?>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'UJIAN SEDANG BERLANGSUNG !',
                text: "Anda tidak bisa mengaktifkan ujian ini",
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
    <?php
    } elseif ($_GET['mes'] == "berhasilEditData") {
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'DATA BERHASIL DIUBAH !',
                showConfirmButton: false,
                timer: 3000
            }).then((result) => {
                window.location.href = "/page/admin/edit?tes_id=<?php echo $test_id ?>";
            });
        </script>
<?php
    }
}
?>

</body>

</html>