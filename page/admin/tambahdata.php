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
                    TAMBAH DATA UJIAN
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">TAMBAH DATA UJIAN</h5>
                        <form action="<?php echo $urlConfig ?>soal" method="post">
                            <div>
                                <div class="form-group">
                                    <label for="name">NAMA UJIAN</label>
                                    <input type="text" name="test_name" class="form-control" placeholder="Nama Ujian"
                                        aria-label="Nama Ujian" aria-describedby="basic-addon1" required
                                        autocomplete="off">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="cbt_start">TANGGAL MULAI UJIAN</label>
                                    <input type="date" name="cbt_date_start" class="form-control"
                                        placeholder="Tanggal Mulai Ujian" aria-label="Tanggal Selesai Ujian"
                                        aria-describedby="basic-addon1" required autocomplete="off" autocapitalize="on">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="cbt_end">TANGGAL AKHIR UJIAN</label>
                                    <input type="date" name="cbt_date_end" class="form-control"
                                        placeholder="Tanggal Selesai Ujian" aria-label="Tanggal Selesi Ujian"
                                        aria-describedby="basic-addon1" required autocomplete="off">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">DURASI UJIAN</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">DALAM MENIT</span>
                                        <input type="number" name="cbt_time" class="form-control"
                                            placeholder="Durasi Ujian" aria-label="Durasi Ujian"
                                            aria-describedby="basic-addon1" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="d-block text-center card-footer">
                                <button type="submit" class="btn-wide btn btn-success" name="tambahData">TAMBAH
                                    DATA UJIAN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include '../template/script.php'; ?>
<script>
// Replace the <textarea id="editor1"> with a CKEditor 4
// instance, using default configuration.
CKEDITOR.replace('que_desc');
CKEDITOR.replace('ans1');
CKEDITOR.replace('ans2');
CKEDITOR.replace('ans3');
CKEDITOR.replace('ans4');
CKEDITOR.replace('ans5');
CKEDITOR.replace('true_ans');
</script>

</body>

</html>