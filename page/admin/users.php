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
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Data Ujian</h5>
                    <table class="mb-0 table table-bordered text-center">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nama Peserta</th>
                            <th class="text-center">Nomor Peserta Ujian</th>
                            <th class="text-center">Tanggal Ujian</th>
                            <th class="text-center">Nilai Ujian</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nama Peserta</th>
                                <th class="text-center">Nomor Peserta Ujian</th>
                                <th class="text-center">Tanggal Ujian</th>
                                <th class="text-center">Nilai Ujian</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM tb_test 
                            INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
                            INNER JOIN tb_users_status ON tb_test.test_id = tb_users_status.test_id
                            INNER JOIN tb_users_cbt ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                $no = 1;

                            ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $no++ ?></td>
                                    <td>
                                        <div class="widget-heading"><?php echo $row['name'] ?></div>
                                    </td>
                                    <td>
                                        <div class="widget-heading"><?php echo $row['username'] ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php echo tgl_indo(date("Y-m-d", strtotime($row['users_cbt_date']))) ?>
                                    </td>
                                    <td><?php
                                        if ($row['exam_status'] == 'TERDAFTAR') {
                                            echo "--";
                                        } else {
                                            echo $row['grade'];
                                        }
                                        ?></td>
                                    <td class="text-center">
                                        <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" href="showusers?user_id=<?php echo $row['id_users_cbt']; ?>">Detail</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../template/script.php'; ?>

</body>

</html>