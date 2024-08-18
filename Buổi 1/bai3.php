<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .phep_tinh {
            display: flex;
            align-items: center; 
            gap: 20px; 
        }
        .phep_tinh1 {
            display: flex;
            align-items: center;
        }
        .phep_tinh1 input {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<h2>PHÉP TÍNH TRÊN 2 SỐ</h2>
<form method="post" action="">
    <div class="phep_tinh">
        <p>Chọn phép tính:</p>
        <div class="phep_tinh1">
            <input type="radio" name="gender" value="cong"> Cộng
        </div>
        <div class="phep_tinh1">
            <input type="radio" name="gender" value="tru"> Trừ
        </div>
        <div class="phep_tinh1">
            <input type="radio" name="gender" value="nhan"> Nhân
        </div>
        <div class="phep_tinh1">
            <input type="radio" name="gender" value="chia"> Chia
        </div>
    </div>

    <label for="number1">Số thứ nhất:</label>
    <input type="text" id="number1" name="number1"><br><br>

    <label for="number2">Số thứ hai:</label>
    <input type="text" id="number2" name="number2"><br><br>
    
    <input type="submit" value="Tính">

</form>

<?php
function tong($a, $b){
    return $a + $b;
}
function hieu($a, $b){
    return $a - $b;
}
function tich($a, $b){
    return $a * $b;
}
function thuong($a, $b){
    if ($b != 0) {
        return $a / $b;
    } else {
        return "Mẫu số không thể bằng 0";
    }
}
function nto($a){
    if ($a < 2) {
        echo $a ."không phải là số nguyên tố";
    }
    for ($i = 2; $i <= sqrt($a); $i++) {
        if ($a % $i == 0) {
            echo $a ."không phải là số nguyên tố";
        }
    }
    echo $a ."là số nguyên tố";
}
function so_chan($a){
    if($a % 2==0) return true;
    else return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number1 = isset($_POST['number1']) ? $_POST['number1'] : '';
    $number2 = isset($_POST['number2']) ? $_POST['number2'] : '';
    $operation = isset($_POST['gender']) ? $_POST['gender'] : '';

    if (is_numeric($number1) && is_numeric($number2) && $operation) {
        $number1 = (float)$number1;
        $number2 = (float)$number2;

        switch ($operation) {
            case 'cong':
                $result = tong($number1, $number2);
                break;
            case 'tru':
                $result = hieu($number1, $number2);
                break;
            case 'nhan':
                $result = tich($number1, $number2);
                break;
            case 'chia':
                $result = thuong($number1, $number2);
                break;
            default:
                $result = "Không có phép tính nào được chọn.";
                break;
        }
        echo "Kết quả: " . $result;
    } else {
        echo "Vui lòng nhập số hợp lệ và chọn phép tính.";
    }
}
?>

    
    
</body>
</html>
