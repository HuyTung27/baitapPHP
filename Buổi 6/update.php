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

    // Chọn cơ sở dữ liệu
    mysqli_select_db($conn, 'b5_mydb');

    // SQL để cập nhật firstname từ "James" thành "Jane"
    $sql = "UPDATE MyGuests SET firstname = 'Jane' WHERE firstname = 'James'";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Đóng kết nối
    mysqli_close($conn);
    ?>
    <a href="select.php"><button>xem bảng sau khi xóa</button></a>
</body>
</html>