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
                        <h5 class="card-title">TAMBAH DATA PESERTA</h5>
                        <form action="<?php echo $urlConfig ?>soal" method="post">
                            <div>
                                <div class="form-group">
                                    <label for="name">USERNAME</label>
                                    <input type="text" name="username" class="form-control" placeholder="USERNAME" aria-label="USERNAME" aria-describedby="basic-addon1" required autocomplete="off">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="name">NAMA PESERTA</label>
                                    <input type="text" name="name" class="form-control" placeholder="NAMA PESERTA" aria-label="NAMA PESERTA" aria-describedby="basic-addon1" required autocomplete="off">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="cbt_start">TANGGAL LAHIR PESERTA</label>
                                    <input type="date" name="birthDate" class="form-control" placeholder="TANGGAL LAHIR PESERTA" aria-label="TANGGAL LAHIR PESERTA" aria-describedby="basic-addon1" required autocomplete="off" autocapitalize="on">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="cbt_end">TEMPAT LAHIR PESERTA</label>
                                    <input type="text" name="birthPlace" class="form-control" placeholder="TEMPAT LAHIR PESERTA" aria-label="TEMPAT LAHIR PESERTA" aria-describedby="basic-addon1" required autocomplete="off">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="jenisKelamin">JENIS KELAMIN</label>
                                    <select name="jenisKelamin" class="form-control" required>
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-block text-center card-footer">
                                <button type="submit" class="btn-wide btn btn-success" name="tambahPeserta">TAMBAH
                                    DATA PESERTA</button>
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