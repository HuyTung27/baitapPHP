<?php
require 'department.php'; // Chứa các phương thức xử lý cho department

// Lấy thông tin phòng ban để sửa
$department_id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if ($department_id) {
    $data = get_department($department_id);
    if ($data) {
        $department_name = $data['department_name'];
    } else {
        header("location: department_list.php"); // Nếu không tìm thấy, trở về trang danh sách
    }
}

// Nếu người dùng submit form sửa
if (!empty($_POST['edit_department'])) {
    $department_name = isset($_POST['department_name']) ? $_POST['department_name'] : '';

    // Kiểm tra thông tin
    $errors = array();
    if (empty($department_name)) {
        $errors['department_name'] = 'Tên phòng ban không được để trống';
    }

    // Nếu không có lỗi, cập nhật thông tin
    if (!$errors) {
        edit_department($department_id, $department_name);
        header("location: department_list.php"); // Trở về trang danh sách sau khi cập nhật
    }
}

disconnect_db();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Phòng Ban</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Sửa Thông Tin Phòng Ban</h1>
    <a href="department_list.php">Trở về</a><br/><br/>
    <form method="post" action="department_edit.php?id=<?php echo $department_id; ?>">
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>Tên Phòng Ban</td>
                <td>
                    <input type="text" name="department_name" value="<?php echo $department_name; ?>"/>
                    <?php if (!empty($errors['department_name'])) echo $errors['department_name']; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="edit_department" value="Lưu"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
