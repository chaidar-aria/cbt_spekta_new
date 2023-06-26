<?php

include 'conn.php';

if (isset($_POST["editSoal"])) {
    $test_id = $_POST['test_id'];
    $que_id = $_POST["que_id"];
    $que_desc = $_POST["que_desc"];
    $ans1 = $_POST["ans1"];
    $ans2 = $_POST["ans2"];
    $ans3 = $_POST["ans3"];
    $ans4 = $_POST["ans4"];
    $ans5 = $_POST["ans5"];
    $true_ans = $_POST["true_ans"];
    $que_score = $_POST["que_score"];

    $query = "UPDATE tb_question SET que_desc = '$que_desc', ans1 = '$ans1', ans2 = '$ans2', ans3 = '$ans3', ans4 = '$ans4', ans5 = '$ans5', true_ans = '$true_ans', que_score = '$que_score' WHERE que_id = '$que_id'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=berhasilEdit');
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['tambahSoal'])) {
    $test_id = $_POST['test_id'];
    $que_desc = $_POST["que_desc"];
    $ans1 = $_POST["ans1"];
    $ans2 = $_POST["ans2"];
    $ans3 = $_POST["ans3"];
    $ans4 = $_POST["ans4"];
    $ans5 = $_POST["ans5"];
    $true_ans = $_POST["true_ans"];
    $que_score = $_POST["que_score"];

    $query = "INSERT INTO tb_question (que_id,test_id,que_desc,ans1,ans2,ans3,ans4,ans5,true_ans,que_score) VALUES (NULL,'$test_id','$que_desc','$ans1','$ans2','$ans3','$ans4','$ans5','$true_ans','$que_score')";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=berhasilTambah');
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['tambahData'])) {
    $test_name = strtoupper($_POST["test_name"]);
    $cbt_date_start = $_POST["cbt_date_start"];
    $cbt_date_end = $_POST["cbt_date_end"];
    $cbt_timer = $_POST["cbt_time"];

    $query = "INSERT INTO tb_test (test_id,test_name,cbt_date_start,cbt_date_end) VALUES (NULL,'$test_name','$cbt_date_start','$cbt_date_end')";

    if ($conn->query($query) === TRUE) {
        $sql = mysqli_query($conn, "SELECT * FROM tb_test WHERE test_name = '$test_name'");
        while ($d = mysqli_fetch_array($sql)) {
            $tes_id = $d['test_id'];
            $sql = "INSERT INTO tb_cbt_time (test_id) SELECT test_id FROM tb_test WHERE test_id = '$tes_id';";
            if ($conn->query($sql) === TRUE) {
                $sql = "UPDATE tb_cbt_time SET cbt_timer = '$cbt_timer' WHERE test_id = '$tes_id'";
                if ($conn->query($sql) === TRUE) {
                    header('location: ../page/admin/data?mes=berhasilTambah');
                }
            }
        }
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['editData'])) {
    $test_id = $_POST['test_id'];
    $test_name = strtoupper($_POST["test_name"]);
    $cbt_date_start = $_POST["cbt_date_start"];
    $cbt_date_end = $_POST["cbt_date_end"];
    $cbt_timer = $_POST["cbt_timer"];

    $query = "UPDATE tb_test
            INNER JOIN tb_cbt_time ON tb_test.test_id = tb_cbt_time.test_id
            SET test_name = '$test_name',cbt_date_start = '$cbt_date_start', cbt_date_end = '$cbt_date_end', cbt_timer = '$cbt_timer' WHERE tb_test.test_id = '$test_id'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=berhasilEditData');
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['queoff'])) {
    $test_id = $_POST["test_id"];
    $cbt_status = '0';

    $query = "UPDATE tb_test SET cbt_status = '$cbt_status' WHERE test_id = '$test_id'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=off');
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['queon'])) {
    $test_id = $_POST["test_id"];
    $cbt_status = '1';

    $sql = "SELECT * FROM tb_test WHERE cbt_status = '1'";
    $result = $conn->query($sql);

    if ($result->num_rows >= 3) {
        header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=onlyone');
    } else {
        $query = "UPDATE tb_test SET cbt_status = '$cbt_status' WHERE test_id = '$test_id'";

        if ($conn->query($query) === TRUE) {
            header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=on');
        } else {
            echo 'error' . $conn->error;
        }
    }
} elseif (isset($_POST['buatToken'])) {
    $test_id = $_POST["test_id"];
    $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shuffle  = substr(str_shuffle($karakter), 0, 5);
    $query = "UPDATE tb_test SET cbt_token = '$shuffle' WHERE test_id = '$test_id'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/aktif?test_id=' . $test_id);
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_GET['resetToken'])) {
    $test_id = $_GET["test_id"];
    $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shuffle  = substr(str_shuffle($karakter), 0, 5);
    $query = "UPDATE tb_test SET cbt_token = '$shuffle' WHERE test_id = '$test_id'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/ujian');
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['hapusToken'])) {
    $test_id = $_POST["test_id"];
    $query = "UPDATE tb_test SET cbt_token = '' WHERE test_id = '$test_id'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/admin/aktif?test_id=' . $test_id);
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_POST['cekToken'])) {
    $test_id = $_GET['tes_id'];
    $token = $_POST["token"];

    $query = "SELECT * FROM tb_test WHERE cbt_token = '$token' AND test_id = '$test_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        if (ctype_upper($token)) {
            $sql = "SELECT * FROM tb_question WHERE test_id = '$test_id' ORDER BY que_id LIMIT 1";
            $r = $conn->query($sql);
            while ($d = mysqli_fetch_array($r)) {
                $que_id = $d['que_id'];
            }
            $_SESSION['mulai'];
            header('location: ../page/ljk/?tes_id=' . $test_id . '&page=1');
        } else {
            header('location: ../page/confirm/?tes_id=' . $test_id  . '&mes=huruf');
        }
    } else {
        header('location: ../page/confirm/?tes_id=' . $test_id . '&mes=token');
    }
} elseif (isset($_GET['endExam'])) {
    $test_id = $_GET['tes_id'];
    // $que_id = $_POST['que_id'];
    $work_status = '1';
    $exam_status = 'FINISH';
    $username = $_GET['username'];
    $user_id = $_GET['user_id'];

    $score    = 0;
    $benar    = 0;
    $salah    = 0;
    $kosong    = 0;

    $quejumlah = mysqli_query($conn, "SELECT * FROM tb_question WHERE test_id = '$test_id'");
    $jumlah = mysqli_num_rows($quejumlah);
    while ($row = mysqli_fetch_array($quejumlah)) {
        $rows[] = $row['que_id'];
    }

    $ansbenar = mysqli_query($conn, "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND id_users_cbt = '$user_id' ORDER BY que_id");
    while ($d = mysqli_fetch_array($ansbenar)) {
        $jawaban[] = $d['user_answer'];
    }

    for ($i = 0; $i < $jumlah; $i++) {
        $query    = mysqli_query($conn, "SELECT * FROM tb_question WHERE que_id='$rows[$i]' AND true_ans='$jawaban[$i]' ORDER BY que_id");
        $cek    = mysqli_num_rows($query);

        // jika jawaban benar (cocok dengan database)
        if ($cek) {
            $benar++;
        }
        // jika jawaban salah (tidak cocok dengan database)
        else {
            $salah++;
        }
    }
    // hitung skor
    $score    = ($benar / $jumlah) * 100;
    $hasil    = number_format($score, 2);

    $sql4 = "UPDATE tb_users_cbt 
            INNER JOIN tb_users_status ON tb_users_cbt.id_users_cbt = tb_users_status.id_users_cbt
            SET grade = '$hasil',
            work_status = '$work_status', 
            exam_status = '$exam_status' 
            WHERE tb_users_cbt.id_users_cbt = '$user_id'";
    if ($conn->query($sql4) === TRUE) {
        header('location: ../page/finish/?tes_id=' . $test_id . '&mes=finish');
    } else {
        echo 'error' . $conn->error;
    }
} elseif (isset($_GET['timeout'])) {
    $test_id = $_GET['tes_id'];
    $que_id = $_GET['que_id'];
    $work_status = '1';
    $exam_status = 'TIMEOUT';
    $username = $_GET['username'];

    $query = "UPDATE tb_users_cbt 
            INNER JOIN tb_users ON tb_users.id_users = tb_users_cbt.id_users
            INNER JOIN tb_users_status ON tb_users.id_users = tb_users_status.id_users
            SET work_status = '$work_status', exam_status = '$exam_status' 
            WHERE tb_users_cbt.username = '$username'";

    if ($conn->query($query) === TRUE) {
        header('location: ../page/finish/?tes_id=' . $test_id . '&mes=timeout');
    } else {
        echo 'error' . $conn->error;
    }
}
