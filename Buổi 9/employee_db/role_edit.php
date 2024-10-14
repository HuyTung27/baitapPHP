<?php
require 'role.php'; // File chứa các phương thức xử lý cho role

// Lấy thông tin role để sửa
$role_id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if ($role_id) {
    $data = get_role($role_id);
    if ($data) {
        $role_name = $data['role_name'];
    } else {
        header("location: role_list.php"); // Nếu không tìm thấy, trở về trang danh sách
    }
}

// Nếu người dùng submit form sửa
if (!empty($_POST['edit_role'])) {
    $role_name = isset($_POST['role_name']) ? $_POST['role_name'] : '';

    // Kiểm tra thông tin
    $errors = array();
    if (empty($role_name)) {
        $errors['role_name'] = 'Tên role không được để trống';
    }

    // Nếu không có lỗi, cập nhật thông tin
    if (!$errors) {
        edit_role($role_id, $role_name);
        header("location: role_list.php"); // Trở về trang danh sách sau khi cập nhật
    }
}

disconnect_db();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Role</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Sửa Thông Tin Role</h1>
    <a href="role_list.php">Trở về</a><br/><br/>
    <form method="post" action="role_edit.php?id=<?php echo $role_id; ?>">
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>Tên Role</td>
                <td>
                    <input type="text" name="role_name" value="<?php echo $role_name; ?>"/>
                    <?php if (!empty($errors['role_name'])) echo $errors['role_name']; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="edit_role" value="Lưu"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
