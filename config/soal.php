<?php

include 'conn.php';
include '../vendor/autoload.php';

// Menggunakan PHPSpreadsheet untuk membaca file Excel
use PhpOffice\PhpSpreadsheet\IOFactory;


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

    if ($result->num_rows >= 1) {
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
            SET work_status = '$work_status', 
            exam_status = '$exam_status' 
            WHERE tb_users_cbt.id_users_cbt = '$user_id'";
    if ($conn->query($sql4) === TRUE) {
        $sql5 = "INSERT INTO tb_cbt_grade (test_id, id_users_cbt, grade) VALUES ('$test_id','$user_id','$hasil')";
        if ($conn->query($sql5)) {
            header('location: ../page/finish/?tes_id=' . $test_id . '&mes=finish');
        }
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
} else if (isset($_POST['testId']) && isset($_POST['userId'])) {
    $testId = $_POST['testId'];
    $userId = $_POST['userId'];

    // Validate $testId and $userId if needed.

    $query = "SELECT * FROM tb_test WHERE test_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $testId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cbt_date_start = $row['cbt_date_start'];
        $cbt_date_end = $row['cbt_date_end'];

        // Convert date strings to DateTime objects
        $cbt_date_start = new DateTime($cbt_date_start);
        $cbt_date_end = new DateTime($cbt_date_end);

        // Get the timestamps of the start and end dates
        $start_timestamp = strtotime($cbt_date_start->format('Y-m-d'));
        $end_timestamp = strtotime($cbt_date_end->format('Y-m-d'));

        // Generate a random timestamp within the date range
        $random_timestamp = rand($start_timestamp, $end_timestamp);

        // Convert the random timestamp back to a date format
        $random_date = date('Y-m-d', $random_timestamp);

        // Now, $random_date contains the randomly generated date within the date range

        // Insert the data into tb_cbt_users_date using prepared statement
        $insert_query = "UPDATE tb_cbt_users_date SET test_id = ?, users_cbt_date = ? WHERE id_users_cbt = ?";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iss", $testId, $random_date, $userId);

        if ($stmt->execute()) {
            $insert_query = "UPDATE tb_users_status SET test_id = ? WHERE id_users_cbt = ?";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("is", $testId, $userId);
            if ($stmt->execute()) {
                http_response_code(200); // Success
            } else {
                http_response_code(500); // Internal Server Error
            }
        } else {
            http_response_code(500); // Internal Server Error
        }
    } else {
        http_response_code(400); // Bad Request
    }
} elseif (isset($_POST['tambahPeserta'])) {
    $username = $_POST['username'];
    $name = strtoupper($_POST['name']);
    $birthdate = $_POST['birthDate'];
    $birthplace = strtoupper($_POST['birthPlace']);
    $jenisKelamin = $_POST['jenisKelamin'];

    $password = $username;

    // Cek apakah data sudah ada di database
    $existingDataQuery = "SELECT * FROM tb_users_cbt WHERE username = '$username'";
    $existingDataResult = $conn->query($existingDataQuery);

    if ($existingDataResult->num_rows == 0) {
        // Data belum ada, lakukan operasi INSERT
        $query = "INSERT INTO tb_users_cbt (username, password, name, birth_place, birth_date, gender) VALUES ('$username', '$password','$name','$birthplace','$birthdate','$jenisKelamin')";

        if ($conn->query($query)) {
            $sql = mysqli_query($conn, "SELECT * FROM tb_users_cbt WHERE username = '$username'");
            while ($d = mysqli_fetch_array($sql)) {
                $idcbt = $d['id_users_cbt'];
                $lv = "INSERT INTO tb_level (id_users_cbt) VALUES ('$idcbt');";
                if ($conn->query($lv) === TRUE) {
                    $usrdate = "INSERT INTO tb_cbt_users_date (id_users_cbt) VALUES ('$idcbt')";
                    if ($conn->query($usrdate) === TRUE) {
                        $usrsts = "INSERT INTO tb_users_status (id_users_cbt) VALUES ('$idcbt')";
                        if ($conn->query($usrsts) === TRUE) {
                            $usrutlts = "INSERT INTO tb_users_utilities (id_users_cbt) VALUES ('$idcbt')";
                            if ($conn->query($usrutlts) === TRUE) {
                                header('location: ../page/admin/users?mes=cracc');
                            } else {
                                header('location: ../page/admin/users?mes=gagal');
                            }
                        } else {
                            header('location: ../page/admin/users?mes=gagal');
                        }
                    } else {
                        header('location: ../page/admin/users?mes=gagal');
                    }
                } else {
                    header('location: ../page/admin/users?mes=gagal');
                }
            }
        } else {
            echo "Gagal menyimpan data: " . $conn->error;
        }
    } else {
        // Data sudah ada di database, berikan tindakan yang sesuai
        header('location: ../page/admin/users?mes=duplicate');
    }
} else if (isset($_POST['action']) && $_POST['action'] === 'acak_tanggal') {
    // Perform the database insertion here
    // Replace the following line with your database insertion logic
    // For example:
    // $result = insert_data_to_database();

    // Assuming the insertion is successful, return 'success'
    // If there is an error during insertion, return 'error'
    $result = 'success'; // Change this based on your database operation

    echo $result;
} else if (isset($_POST['unggahPeserta'])) {
    $file = $_FILES['filePeserta']['tmp_name'];
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
    $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    $spreadsheet = $objReader->load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Melakukan impor data ke database
    foreach ($sheetData as $row) {
        $username = $row['A']; // Ganti 'A' dengan nama kolom di Excel (misalnya 'A', 'B', 'C', dst.)
        $name = $row['B'];
        $birthPlace = $row['C'];
        $birthDate = $row['D'];
        $gender = $row['E'];
        $password = $username;

        // Mengubah Format Tanggal
        $tanggal_lahir = date_create_from_format('d/m/Y', $birthDate); // Konversi format tanggal
        $tanggal_lahir_mysql = $tanggal_lahir ? date_format($tanggal_lahir, 'Y-m-d') : null; // Format sesuai dengan format di MySQL (YYYY-MM-DD)

        // Cek apakah data sudah ada di database
        $existingDataQuery = "SELECT * FROM tb_users_cbt WHERE username = '$username'";
        $existingDataResult = $conn->query($existingDataQuery);

        if ($existingDataResult->num_rows == 0) {

            // Query untuk menyimpan data ke tabel MySQL
            $sql = "INSERT INTO tb_users_cbt (username, password, name, birth_place, birth_date, gender) VALUES ('$username', '$password', '$name','$birthPlace','$tanggal_lahir_mysql','$gender')";
            $result = $conn->query($sql);

            if ($result) {
                $sql = mysqli_query($conn, "SELECT * FROM tb_users_cbt WHERE username = '$username'");
                while ($d = mysqli_fetch_array($sql)) {
                    $idcbt = $d['id_users_cbt'];
                    $lv = "INSERT INTO tb_level (id_users_cbt) VALUES ('$idcbt');";
                    if ($conn->query($lv) === TRUE) {
                        $usrdate = "INSERT INTO tb_cbt_users_date (id_users_cbt) VALUES ('$idcbt')";
                        if ($conn->query($usrdate) === TRUE) {
                            $usrsts = "INSERT INTO tb_users_status (id_users_cbt) VALUES ('$idcbt')";
                            if ($conn->query($usrsts) === TRUE) {
                                $usrutlts = "INSERT INTO tb_users_utilities (id_users_cbt) VALUES ('$idcbt')";
                                if ($conn->query($usrutlts) === TRUE) {
                                    header('location: ../page/admin/users?mes=cracc');
                                } else {
                                    header('location: ../page/admin/users?mes=gagal');
                                    // echo 'errro1' . $conn->connect_error;
                                }
                            } else {
                                header('location: ../page/admin/users?mes=gagal');
                                // echo 'errro1' . $conn->connect_error;
                            }
                        } else {
                            header('location: ../page/admin/users?mes=gagal');
                            // echo 'errro1' . $conn->connect_error;
                        }
                    } else {
                        header('location: ../page/admin/users?mes=gagal');
                        // echo 'errro1' . $conn->connect_error;
                    }
                }
            } else {
                echo "Gagal menyimpan data: " . $conn->error;
            }
        } else {
            header('location: ../page/admin/users?mes=duplicate');
            continue;
        }
    }
} elseif (isset($_POST['unggahSoal'])) {
    $tes_id = $_POST['test_id'];
    $file = $_FILES['fileSoal']['tmp_name'];
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
    $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    $spreadsheet = $objReader->load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Melakukan impor data ke database
    foreach ($sheetData as $row) {
        $soal = $row['A']; // Ganti 'A' dengan nama kolom di Excel (misalnya 'A', 'B', 'C', dst.)
        $pilA = $row['B'];
        $pilB = $row['C'];
        $pilC = $row['D'];
        $pilD = $row['E'];
        $pilE = $row['F'];
        $true = $row['G'];
        $nilai = $row['H'];

        // Query untuk menyimpan data ke tabel MySQL
        $sql = "INSERT INTO tb_question (test_id, que_desc, ans1, ans2, ans3, ans4, ans5, true_ans, que_score) VALUES ('$tes_id', '$soal', '$pilA','$pilB','$pilC','$pilD','$pilE','$true','$nilai')";
        $result = $conn->query($sql);

        if ($result) {
            header('location: ../page/admin/edit?tes_id=' . $tes_id . '&mes=berhasilTambah');
        } else {
            header('location: ../page/admin/edit?tes_id=' . $tes_id . '&mes=gagal');
            // echo 'errro1' . $conn->connect_error;
        }
    }
    // Periksa apakah permintaan berasal dari fungsi mouseOut()
} else {
    echo "Permintaan tidak valid.";
}
