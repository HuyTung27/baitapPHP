<?php
require 'roles.php';
$employeeroles = get_all_role();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách chức vụ</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Danh sách chức vụ</h1>
    <a href="add_role.php">Thêm chức vụ</a> <br/> <br/>
    <a href="employee_list.php">Quay lại danh sách nhân viên </a> <br/> <br/>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>Role id</th>
            <th>Role Name</th>
            <th>Chọn thao tác</th>
        </tr>
        <?php foreach ($employeeroles as $item) { ?>
        <tr>
            <td><?php echo $item['role_id']; ?></td>
            <td><?php echo $item['role_name']; ?></td>
            <td>
                <form method="post" action="delete_role.php">
                    <input type="button" onclick="window.location='edit_role.php?id=<?php echo $item['role_id']; ?>'" value="Sửa"/>
                    <input type="hidden" name="id" value="<?php echo $item['role_id']; ?>"/>
                    <input type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');" name="delete" value="Xóa"/>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
