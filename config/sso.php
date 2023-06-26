<?php

session_start();

include 'conn.php';

$username = $_GET['username'];
$password = $_GET['password'];

$query = "SELECT * FROM tb_users_cbt 
                INNER JOIN tb_level ON tb_level.id_users_cbt = tb_users_cbt.id_users_cbt
                INNER JOIN tb_level_name ON tb_level.id_level_name = tb_level_name.id_level_name
                WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    if ($data['level_name'] == "USER") {
        $_SESSION['level'] = "user";
        $_SESSION['username'] = $username;
        header("location: ../page/cbt/");
    } else if ($data['level_name'] == "ADMIN") {
        $_SESSION['level'] = "admin";
        $_SESSION['username'] = $username;
        header("location: ../page/admin/");
    } else if ($data['level_name'] == "SUPERADMIN") {
        $_SESSION['level'] = "admin";
        $_SESSION['username'] = $username;
        header("location: ../page/admin/");
    }
} else {
    echo $conn->connect_error;
    // header("location: ../?mes=gagalLogin");
}