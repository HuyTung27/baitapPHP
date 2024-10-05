<?php
require 'roles.php';

if (isset($_POST['add'])) {
    $role_name = $_POST['role_name'];
    
    // Kiểm tra nếu role_name hợp lệ
    if (!empty($role_name)) {
        add_role($role_name);
        header("Location: roles_list.php"); // Chuyển hướng sau khi thêm thành công
        exit(); // Thoát để đảm bảo không có mã nào được thực thi sau khi chuyển hướng
    } else {
        echo "Vui lòng nhập tên chức vụ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm chức vụ</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Thêm chức vụ</h1>
    <form method="post" action="">
        <label>Role Name:</label><br/>
        <input type="text" name="role_name" required/><br/><br/>
        <input type="submit" name="add" value="Thêm"/>
    </form>
</body>
</html>
