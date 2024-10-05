<?php
require 'department.php';
$departments = get_all_departments();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách phòng ban</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Danh sách Departments</h1>
    <a href="department_add.php">Thêm phòng ban</a> <br/> <br/>
    <a href="employee_list.php">Quay lại danh sách nhân viên </a> <br/> <br/>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>Department id</th>
            <th>Department Name</th>
            <th>Chọn thao tác</th>
        </tr>
        <?php foreach ($departments as $item) { ?>
        <tr>
            <td><?php echo $item['department_id']; ?></td>
            <td><?php echo $item['department_name']; ?></td>
            <td>
                <form method="post" action="department_delete.php">
                    <input type="button" onclick="window.location='department_edit.php?id=<?php echo $item['department_id']; ?>'" value="Sửa"/>
                    <input type="hidden" name="id" value="<?php echo $item['department_id']; ?>"/>
                    <input type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');" name="delete" value="Xóa"/>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
