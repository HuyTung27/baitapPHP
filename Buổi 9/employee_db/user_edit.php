<?php
require 'user.php';

// Lấy user_id từ URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = get_user_by_id($user_id);
} else {
    header('Location: user_list.php');
    exit();
}

// Kiểm tra nếu biểu mẫu được gửi để cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    update_user($user_id, $username, $email, $role);

    // Chuyển hướng sau khi cập nhật thành công
    header('Location: user_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Chỉnh sửa người dùng</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Chỉnh sửa thông tin người dùng</h1>
        <form method="POST" action="">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['name']; ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

            <label for="role">Vai trò:</label>
            <input type="text" id="role" name="role" value="<?php echo $user['role']; ?>" required><br><br>

            <button type="submit">Cập nhật thông tin</button>
        </form>
        <br>
        <a href="user_list.php">Quay lại danh sách người dùng</a>
    </body>
</html>
