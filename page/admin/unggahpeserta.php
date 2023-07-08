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
                    TAMBAH DATA PESERTA
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">UNGGAH DATA PESERTA</h5>
                        <form action="<?php echo $urlConfig ?>soal" method="post" enctype="multipart/form-data">
                            <div>
                                <div class="form-group">
                                    <label for="name">UNGGAH DATA</label>
                                    <input type="file" name="filePeserta" class="form-control" aria-describedby="basic-addon1" required autocomplete="off">
                                </div>
                            </div>
                            <div class="d-block text-center card-footer">
                                <button type="submit" class="btn-wide btn btn-success" name="unggahPeserta">UNGGAH
                                    DATA PESERTA</button>
                            </div>
                            <div class="d-block text-center card-footer">
                                <a href="<?php echo $urlFile . 'data.xlsx'; ?>" type="btn" class="btn-wide btn btn-info">UNDUH FORMAT UNGGAH DATA</a>
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