<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    function tong($a, $b){
        return $a +$b;
    }
    function hieu($a, $b){
        return $a - $b;
    }
    function tich($a, $b){
        return $a *$b;
    }
    function thuong($a, $b){
        if($b != 0){
            return $a/$b;
        } 
        else {
            return "Mẫu đang bằng 0";
        }
    }
    function ktraNto($a){
        if ($a < 2) {
            return false;
        }
        for ($i = 2; $i <= sqrt($a); $i++) {
            if ($a % $i == 0) {
                return false;
            }
        }
        return true;
    }
    function ktraChan($a){
        if($a % 2 ==0) return 1;
        else return 0;
    }
        $a=4;
        $b=7;
        echo "Tổng của $a và $b là: " . tong($a, $b) . "<br>";
        echo "Hiệu của $a và $b là: " . hieu($a, $b) . "<br>";
        echo "Tích của $a và $b là: " . tich($a, $b) . "<br>";
        echo "Thương của $a và $b là: " . thuong($a, $b) . "<br>";
        echo "$b " . (ktraNto($b) ? "là" : "không phải là") . " số nguyên tố<br>";
        echo "$a " . (ktraChan($a) ? "là" : "không phải là") . " số chẵn<br>";
?>
</body>
</html>