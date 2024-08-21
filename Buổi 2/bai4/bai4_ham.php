<?php
$mang = [5, 2, 9, 1, 7, 3];

function lonnhat($mang){
    $max = $mang[0];
    $number = count($mang);
    for($i = 1; $i < $number; $i++){
        if($mang[$i] > $max){
            $max = $mang[$i];
        }
    }
    return $max;
}

function nhonhat($mang){
    $min = $mang[0];
    $number = count($mang);
    for($i = 1; $i < $number; $i++){
        if($mang[$i] < $min){
            $min = $mang[$i];
        }
    }
    return $min;
}

function tong($mang){
    $tong = 0;
    $number = count($mang);
    for($i = 0; $i < $number; $i++){
        $tong += $mang[$i];
    }
    return $tong;
}

function timkiem($mang, $a){
    $number = count($mang);
    for($i = 0; $i < $number; $i++){
        if($a == $mang[$i]){
            return "$a có trong mảng";
        }
    }
    return "Không có số cần tìm";
}

function sapxep($mang) {
    $number = count($mang);
    for ($i = 0; $i < $number - 1; $i++) {
        for ($j = 0; $j < $number - $i - 1; $j++) {
            if ($mang[$j] > $mang[$j + 1]) {
                $temp = $mang[$j];
                $mang[$j] = $mang[$j + 1];
                $mang[$j + 1] = $temp;
            }
        }
    }
    return $mang;
}
?>
