<?php
// Kết nối cơ sở dữ liệu
function connect_db() {
    $conn = new PDO('mysql:host=localhost;dbname=employee_db', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

// Ngắt kết nối cơ sở dữ liệu
function disconnect_db($conn) {
    $conn = null;
}

// Lấy tất cả người dùng
function get_all_users() {
    $conn = connect_db();
    $sql = "SELECT * FROM user"; 
    $stmt = $conn->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    disconnect_db($conn);
    return $users;
}
// Lấy thông tin người dùng dựa trên user_id
function get_user_by_id($user_id) {
    $conn = connect_db();
    $sql = "SELECT * FROM user WHERE id_user = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    disconnect_db($conn);
    return $user;
}

// Cập nhật thông tin người dùng
function update_user($user_id, $username, $email, $role) {
    $conn = connect_db();
    $sql = "UPDATE user SET name = :username, email = :email, role = :role WHERE id_user = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    disconnect_db($conn);
}

?>

