<?php

require_once 'conn.php';

if (isset($_POST['nextque'])) {
    $test_id = $_GET['tes_id'];
    $que_id = $_POST['que_id'];
    $answer = $_POST['answer'];
    $id_users_cbt = $_GET['user_id'];
    $page = $_GET['page'];

    if ($answer == NULL || '') {
        $pages1 = $page + 1;
        header('location: ../page/ljk/?tes_id=' . $test_id . '&page=' . $pages1);
    } else {
        $sql = "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND que_id = '$que_id' AND id_users_cbt = '$id_users_cbt'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql2 = "UPDATE tb_useranswer
        SET user_answer = '$answer'
        WHERE test_id = '$test_id' AND que_id = '$que_id' AND id_users_cbt = '$id_users_cbt'
        ";
            if ($conn->query($sql2) === TRUE) {
                $pages2 = $page + 1;
                header('location: ../page/ljk/?tes_id=' . $test_id . '&page=' . $pages2);
            } else {
                echo 'error2' . $conn->connect_error;
            }
        } else {
            $sql3 = "INSERT INTO tb_useranswer (test_id, id_users_cbt, que_id, user_answer) VALUES ('$test_id','$id_users_cbt','$que_id','$answer')";
            if ($conn->query($sql3) === TRUE) {
                $pages3 = $page + 1;
                header('location: ../page/ljk/?tes_id=' . $test_id . '&page=' . $pages3);
            } else {
                echo 'error1' . $conn->connect_error;
            }
        }
    }
} else if (isset($_POST['prevque'])) {
    $test_id = $_GET['tes_id'];
    $que_id = $_POST['que_id'];
    $answer = $_POST['answer'];
    $id_users_cbt = $_GET['user_id'];
    $page = $_GET['page'];

    if ($answer == NULL || '') {
        $pages4 = $page - 1;
        header('location: ../page/ljk/?tes_id=' . $test_id . '&page=' . $pages4);
    } else {
        $sql = "SELECT * FROM tb_useranswer WHERE test_id = '$test_id' AND que_id = '$que_id' AND id_users_cbt = '$id_users_cbt'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql2 = "UPDATE tb_useranswer
        SET user_answer = '$answer'
        WHERE test_id = '$test_id' AND que_id = '$que_id' AND id_users_cbt = '$id_users_cbt'
        ";
            if ($conn->query($sql2) === TRUE) {
                $pages5 = $page - 1;
                header('location: ../page/ljk/?tes_id=' . $test_id . '&page=' . $pages5);
            } else {
                echo 'error2' . $conn->connect_error;
            }
        } else {
            $sql3 = "INSERT INTO tb_useranswer (test_id, id_users_cbt, que_id, user_answer) VALUES ('$test_id','$id_users_cbt','$que_id','$answer')";
            if ($conn->query($sql3) === TRUE) {
                $pages6 = $page - 1;
                header('location: ../page/ljk/?tes_id=' . $test_id . '&page=' . $pages6);
            } else {
                echo 'error1' . $conn->connect_error;
            }
        }
    }
} else {
    echo 'error2' . $conn->connect_error;
}
