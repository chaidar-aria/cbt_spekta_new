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
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT tb_users_cbt.*, tb_level.*
                                    FROM tb_users_cbt 
                                    INNER JOIN tb_level ON tb_level.id_users_cbt = tb_users_cbt.id_users_cbt
                                    INNER JOIN tb_level_name ON tb_level.id_level_name = tb_level_name.id_level_name
                                    WHERE tb_level_name.level_name NOT IN ('SUPERADMIN', 'ADMIN')
                                    GROUP BY tb_users_cbt.id_users_cbt, tb_level.id_level";

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
                                        <a class="btn-shadow p-1 btn btn-primary btn-sm text-white" role="button" href="showusers?user_id=<?php echo $row['id_users_cbt']; ?>">Detail</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-block text-center card-footer">
                    <a href="tambahpeserta" class="btn-wide btn btn-success">TAMBAH DATA PESERTA</a>
                    <a href="unggahpeserta" class="btn-wide btn btn-success">UNGGAH DATA PESERTA</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../template/script.php'; ?>

</body>

</html>