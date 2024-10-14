<?php 
require 'department.php'; 

// Thực hiện xóa
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
if ($id){
    // Gọi hàm xóa department
    delete_department($id);
}

// Trở về trang danh sách
header("location: department_list.php");
?>
