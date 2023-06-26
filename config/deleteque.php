<?php

include 'conn.php';
$test_id = $_GET['tes_id'];
$que_id = $_GET["que_id"];
$query = "DELETE FROM tb_question WHERE que_id = '$que_id'";

if ($conn->query($query) === TRUE) {
    header('location: ../page/admin/edit?tes_id=' . $test_id . '&mes=berhasilHapus');
} else {
    echo 'error' . $conn->error;
}