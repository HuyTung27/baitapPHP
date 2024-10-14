<?php
require 'user.php';
$users = get_all_users();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Danh sách người dùng</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Danh sách người dùng</h1>
        <a href="user_add.php">Thêm người dùng</a> <br/> <br/>
        <table width="100%" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td><b>Tên người dùng</b></td>
                <td>Email</td>
                <td>Password</td>
                <td>Vai trò</td>
                <td>Chọn thao tác</td>
            </tr>
            <?php foreach ($users as $user){ ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['pass']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <form method="post" action="user_delete.php">
                        <input onclick="window.location = 'user_edit.php?id=<?php echo $user['id_user']; ?>'" type="button" value="Sửa"/>
                        <input type="hidden" name="id" value="<?php echo $user['id_user']; ?>"/>
                        <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>
