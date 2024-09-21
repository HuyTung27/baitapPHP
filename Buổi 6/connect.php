<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "b5_mydb";

// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password);

// Chọn cơ sở dữ liệu
if (!mysqli_select_db($conn, $dbname)) {
    die("Failed to select database: " . mysqli_error($conn));
}
?>
