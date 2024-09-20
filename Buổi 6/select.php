<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include 'connect.php';

    // Thực hiện truy vấn để lấy tất cả dữ liệu từ bảng
    $sql = "SELECT id, firstname, lastname, reg_date FROM MyGuests";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra xem có dữ liệu không
    if (mysqli_num_rows($result) > 0) {
        // Tạo bảng HTML để hiển thị dữ liệu
        echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Reg_Date</th>
        </tr>";

        // Hiển thị dữ liệu
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td>" . $row["id"] . "</td>
            <td>" . $row["firstname"] . "</td>
            <td>" . $row["lastname"] . "</td>
            <td>" . $row["reg_date"] . "</td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }
    // Đóng kết nối
    mysqli_close($conn);
    ?>
    <br><a href="update.php"><button>Đổi tên James thành Jane</button></a>
    <a href="delete.php"><button>Xóa dữ liệu có ID 3</button></a>
</body>
</html>
