<?php
require 'bai4_ham.php'; 
$socantim = 7;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Mảng</title>
    <link rel="stylesheet" href="bai4.css">
</head>
<body>
    <header>
        <h1>Array Function</h1>
    </header>
    <div class="container">
        <div class="content">
            <p><span class="highlight">Mảng ban đầu:</span> <?php echo implode(", ", $mang); ?></p>
            <p><span class="highlight">Giá trị lớn nhất trong mảng:</span> <?php echo lonnhat($mang); ?></p>
            <p><span class="highlight">Giá trị nhỏ nhất trong mảng:</span> <?php echo nhonhat($mang); ?></p>
            <p><span class="highlight">Tổng các phần tử trong mảng:</span> <?php echo tong($mang); ?></p>
            <p><span class="highlight">Mảng sau khi sắp xếp:</span> <?php echo implode(", ", sapxep($mang)); ?></p>
            <p><span class="highlight"><?php echo timkiem($mang, $socantim); ?></span></p>
        </div>
    </div>
</body>
</html>
