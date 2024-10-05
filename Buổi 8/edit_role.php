<?php
require 'roles.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Lấy thông tin chức vụ từ database
    $employeeroles = get_all_role();
    foreach ($employeeroles as $employeerole) {
        if ($employeerole['role_id'] == $id) {
            $name = $employeerole['role_name'];
            break;
        }
    }
} else {
    // Chuyển hướng nếu không có ID
    header("Location: roles_list.php");
    exit();
}

// Xử lý khi nhấn nút Cập nhật
if (isset($_POST['edit'])) {
    $id = $_POST['id']; // Lấy id từ POST
    $name = $_POST['role_name']; // Lấy tên phòng ban đã chỉnh sửa
    
    // Gọi hàm cập nhật thông tin
    edit_role($id, $name);
    
    // Sau khi cập nhật, chuyển hướng về trang danh sách phòng ban
    header("Location: roles_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa chức vụ</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Chỉnh sửa chức vụ</h1>

    <form method="post" action="">
        <!-- Sử dụng input ẩn để giữ id của department -->
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        
        <label>Tên chức vụ:</label><br/>
        <input type="text" name="role_name" value="<?php echo $name; ?>" required/><br/><br/>
        
        <input type="submit" name="edit" value="Cập nhật"/>
    </form>
</body>
</html>
