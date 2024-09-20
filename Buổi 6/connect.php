<?php
$servername = "sql110.infinityfree.com";
$username = "if0_37098463";
$password = "HuyTung2707";
$dbname = "if0_37098463_b5_mydb";

// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password);

// Chọn cơ sở dữ liệu
if (!mysqli_select_db($conn, $dbname)) {
    die("Failed to select database: " . mysqli_error($conn));
}
?>
