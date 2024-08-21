<?php
function tong($a, $b) {
    return $a + $b;
}

function hieu($a, $b) {
    return $a - $b;
}

function tich($a, $b) {
    return $a * $b;
}

function thuong($a, $b) {
    if ($b != 0) {
        return $a / $b;
    } else {
        return "Mẫu số không thể bằng 0";
    }
}

function tinhtoan($a, $b, $operation) {
    switch ($operation) {
        case 'Cộng':
            return ['result' => tong($a, $b)];
        case 'Trừ':
            return ['result' => hieu($a, $b)];
        case 'Nhân':
            return ['result' => tich($a, $b)];
        case 'Chia':
            return $b != 0 ? 
                ['result' => thuong($a, $b)] : 
                ['result' => "Mẫu không được bằng 0"];
        default:
            return ['result' => "Chọn và nhập đầy đủ thông tin"];
    }
}
?>
