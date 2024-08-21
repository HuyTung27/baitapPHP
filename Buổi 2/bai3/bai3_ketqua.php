<?php
require 'bai3_ham.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number1 = isset($_POST['number1']) ? $_POST['number1'] : '';
    $number2 = isset($_POST['number2']) ? $_POST['number2'] : '';
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    if (is_numeric($number1) && is_numeric($number2) && $operation) {
        $number1 = (float)$number1;
        $number2 = (float)$number2;

        $result = tinhtoan($number1, $number2, $operation);
    } else {
        $result = ['result' => "Vui lòng nhập số hợp lệ và chọn phép tính."];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Phép tính trên 2 số</h1>
        <p>Chọn phép tính: <?php echo $operation?></p>
        <p>Số thứ nhất: <?php echo $number1; ?></p>
        <p>Số thứ hai: <?php echo $number2; ?></p>
        <p>kết quả: <?php echo $result['result']; ?></p>
        <p><a href="bai3_nhap.php">Quay lại trang nhập</a></p>
    </div>
</body>
</html>
