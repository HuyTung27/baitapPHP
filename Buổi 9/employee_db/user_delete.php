<?php
require 'user.php';

if (isset($_POST['delete'])) {
    $user_id = $_POST['id'];

    // Kết nối và xóa người dùng khỏi cơ sở dữ liệu
    $conn = connect_db();
    $sql = "DELETE FROM user WHERE id_user = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    disconnect_db($conn);

    // Chuyển hướng về danh sách người dùng sau khi xóa thành công
    header('Location: user_list.php');
    exit();
}
?>
