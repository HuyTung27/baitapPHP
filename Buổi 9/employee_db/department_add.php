<?php
require 'department.php'; // File chứa các hàm liên quan đến Department

// Nếu người dùng submit form
if (!empty($_POST['add_department'])) {
    // Lấy dữ liệu
    $data['department_name'] = isset($_POST['department_name']) ? $_POST['department_name'] : '';
    
    // Validate thông tin
    $errors = array();
    if (empty($data['department_name'])) {
        $errors['department_name'] = 'Chưa nhập tên phòng ban';
    }
    
    // Nếu không có lỗi thì thêm vào cơ sở dữ liệu
    if (!$errors) {
        add_department($data['department_name']); // Hàm thêm department vào database
        
        // Trở về trang danh sách phòng ban
        header("location: department_list.php");
    }
}
disconnect_db();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Thêm phòng ban</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Thêm phòng ban</h1>
        <a href="department_list.php">Trở về</a> <br/><br/>
        <form method="post" action="department_add.php">
            <table width="50%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td>Tên phòng ban</td>
                    <td>
                        <input type="text" name="department_name" value="<?php echo !empty($data['department_name']) ? $data['department_name'] : ''; ?>"/>
                        <?php if (!empty($errors['department_name'])) echo $errors['department_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="add_department" value="Lưu"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
