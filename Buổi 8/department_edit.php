<?php
require 'department.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Lấy thông tin phòng ban từ database
    $departments = get_all_departments();
    foreach ($departments as $department) {
        if ($department['department_id'] == $id) {
            $name = $department['department_name'];
            break;
        }
    }
} else {
    // Chuyển hướng nếu không có ID
    header("Location: department_list.php");
    exit();
}

// Xử lý khi nhấn nút Cập nhật
if (isset($_POST['edit'])) {
    $id = $_POST['id']; // Lấy id từ POST
    $name = $_POST['department_name']; // Lấy tên phòng ban đã chỉnh sửa
    
    // Gọi hàm cập nhật thông tin
    edit_department($id, $name);
    
    // Sau khi cập nhật, chuyển hướng về trang danh sách phòng ban
    header("Location: department_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa Department</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Chỉnh sửa Department</h1>

    <form method="post" action="">
        <!-- Sử dụng input ẩn để giữ id của department -->
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        
        <label>Tên Phòng Ban:</label><br/>
        <input type="text" name="department_name" value="<?php echo $name; ?>" required/><br/><br/>
        
        <input type="submit" name="edit" value="Cập nhật"/>
    </form>
</body>
</html>
