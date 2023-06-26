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
$que_id = $_GET['que_id'];

$query = "SELECT * FROM tb_test WHERE test_id = '$test_id'";

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
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <?php
                            $no = 1;
                            $query2 = "SELECT * FROM tb_question WHERE que_id = '$que_id'";
                            $result2 = $conn->query($query2);
                            while ($row2 = $result2->fetch_assoc()) {
                            ?>
                        <h5 class="card-title">EDIT DATA SOAL</h5>
                        <form action="<?php echo $urlConfig ?>soal" method="post">
                            <div>
                                <div class="form-group">
                                    <label for="username">SOAL</label>
                                    <input type="hidden" name="test_id" value="<?php echo $row2['test_id']; ?>">
                                    <input type="hidden" name="que_id" value="<?php echo $row2['que_id']; ?>">
                                    <textarea id="que_desc" rows="10" cols="80" name="que_desc"
                                        require><?php echo $row2['que_desc'] ?></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">JAWABAN A</label>
                                    <textarea id="ans1" rows="10" cols="80"
                                        name="ans1"><?php echo $row2['ans1'] ?></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">JAWABAN B</label>
                                    <textarea id="ans2" rows="10" cols="80"
                                        name="ans2"><?php echo $row2['ans2'] ?></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">JAWABAN C</label>
                                    <textarea id="ans3" rows="10" cols="80"
                                        name="ans3"><?php echo $row2['ans3'] ?></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">JAWABAN D</label>
                                    <textarea id="ans4" rows="10" cols="80"
                                        name="ans4"><?php echo $row2['ans4'] ?></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">JAWABAN E</label>
                                    <textarea id="ans5" rows="10" cols="80"
                                        name="ans5"><?php echo $row2['ans5'] ?></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="username">JAWABAN BENAR</label>
                                    <select class="form-control-sm form-control" name="true_ans" id="true_ans">
                                        <option value="">Pilih Jawaban Benar</option>
                                        <option value="A">Jawaban A</option>
                                        <option value="B">Jawaban B</option>
                                        <option value="C">Jawaban C</option>
                                        <option value="D">Jawaban D</option>
                                        <option value="E">Jawaban E</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="username">SKOR SOAL</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">NILAI</span>
                                    <input type="number" name="que_score" class="form-control" placeholder="Nilai Soal"
                                        aria-label="Nilai Soal" aria-describedby="basic-addon1" require
                                        autocomplete="off" value="<?php echo $row2['que_score'] ?>">
                                </div>
                            </div>
                    </div>
                    <div class="d-block text-center card-footer">
                        <a href="<?php echo $urlConfig . 'deleteque?que_id=' . $que_id . '&tes_id=' . $test_id ?>"
                            class="mr-2 btn-icon btn-icon-only btn btn-outline-danger" name="hapusSoal"><i
                                class="pe-7s-trash btn-icon-wrapper"> </i></a>
                        <button type="submit" class="btn-wide btn btn-success" name="editSoal">EDIT
                            SOAL</button>
                    </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php }
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
</script>

</body>

</html>