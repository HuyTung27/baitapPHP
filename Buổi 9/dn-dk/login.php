<?php
session_start();
include 'db_connect.php';  // Tệp này chứa kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để lấy người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM user WHERE name = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['pass'])) {
        $_SESSION['user'] = $user['user'];
        echo "Login successful!";
        // Chuyển hướng sau khi đăng nhập thành công
        if ($user['role'] == 'admin') {
            header('Location: ../employee_db/dashboard.php');
        } else {
            header('Location: ../employee_db/dashboard1.php');
        }
        exit(); 
    } else {
        echo "Invalid username or password!";
    }
}
?>
