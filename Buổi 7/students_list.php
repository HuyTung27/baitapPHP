<?php
require './libs/students.php';

// Lấy danh sách sinh viên
$students = get_all_students();

// Ngắt kết nối
disconnect_db();
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <a href="students_add.php">Thêm sinh viên</a> <br/> <br/>
    <table width="100%" border="1" cellspacing="0" cellpadding="10">
        <tr>
            <td><b>Mã sinh viên</b></td>
            <td>Họ tên</td>
            <td>Giới tính</td>
            <td>Ngày sinh</td>
            <td>Chọn thao tác</td>
        </tr>
        <?php foreach ($students as $item){ ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['hoten']; ?></td>
            <td><?php echo $item['gioitinh']; ?></td>
            <td><?php echo $item['ngaysinh']; ?></td>
            <td>
                <form method="post" action="students_delete.php">
                    <input onclick="window.location = 'students_edit.php?id=<?php echo $item['id']; ?>'" type="button" value="Sửa"/>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
                    <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
