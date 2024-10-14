<?php
require 'department.php'; // Giả sử file này chứa các hàm liên quan đến department
$departments = get_all_departments();
disconnect_db();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Danh sách phòng ban</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Danh sách phòng ban</h1>
        <a href="department_add.php">Thêm phòng ban</a> <br/> <br/>

        <?php if (count($departments) > 0) { ?>
            <table width="100%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td><b>Department ID</b></td>
                    <td>Department Name</td>
                    <td>Chọn thao tác</td>
                </tr>
                <?php foreach ($departments as $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['department_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['department_name']); ?></td>
                    <td>
                        <form method="post" action="department_delete.php">
                            <input onclick="window.location = 'department_edit.php?id=<?php echo $item['department_id']; ?>'" type="button" value="Sửa"/>
                            <input type="hidden" name="id" value="<?php echo $item['department_id']; ?>"/>
                            <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>Không có phòng ban nào trong danh sách.</p>
        <?php } ?>
    </body>
</html>
