<?php
require 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $role = $_POST['role'];

    // Thêm người dùng vào cơ sở dữ liệu
    $conn = connect_db();
    $sql = "INSERT INTO user (name, email, pass, role) VALUES (:username, :email, :pass, :role)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    disconnect_db($conn);

    // Chuyển hướng về danh sách người dùng sau khi thêm thành công
    header('Location: user_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Thêm người dùng</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Thêm người dùng mới</h1>
        <form method="POST" action="">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="role">Vai trò:</label>
            <input type="text" id="role" name="role" required><br><br>

            <button type="submit">Thêm người dùng</button>
        </form>
        <br>
        <a href="user_list.php">Quay lại danh sách người dùng</a>
    </body>
</html>
