<?php
require 'department.php';

if (isset($_POST['add'])) {
    $department_name = $_POST['department_name'];
    
    // Kiểm tra nếu department_name hợp lệ
    if (!empty($department_name)) {
        add_department($department_name);
        header("Location: department_list.php"); // Chuyển hướng sau khi thêm thành công
        exit(); // Thoát để đảm bảo không có mã nào được thực thi sau khi chuyển hướng
    } else {
        echo "Vui lòng nhập tên phòng ban";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm Department</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Thêm Department</h1>
    <form method="post" action="">
        <label>Department Name:</label><br/>
        <input type="text" name="department_name" required/><br/><br/>
        <input type="submit" name="add" value="Thêm"/>
    </form>
</body>
</html>
