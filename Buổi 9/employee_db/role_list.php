<?php
require 'role.php'; // Giả sử file này chứa các hàm liên quan đến role
$roles = get_all_roles();
disconnect_db();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Danh sách chức vụ</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Danh sách chức vụ</h1>
        <a href="role_add.php">Thêm chức vụ</a> <br/> <br/>

        <?php if (count($roles) > 0) { ?>
            <table width="100%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td><b>Role ID</b></td>
                    <td>Role Name</td>
                    <td>Chọn thao tác</td>
                </tr>
                <?php foreach ($roles as $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['role_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['role_name']); ?></td>
                    <td>
                        <form method="post" action="role_delete.php">
                            <input onclick="window.location = 'role_edit.php?id=<?php echo $item['role_id']; ?>'" type="button" value="Sửa"/>
                            <input type="hidden" name="id" value="<?php echo $item['role_id']; ?>"/>
                            <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>Không có chức vụ nào trong danh sách.</p>
        <?php } ?>
    </body>
</html>
