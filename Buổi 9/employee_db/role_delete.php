<?php 
require 'role.php'; 

// Thực hiện xóa
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
if ($id){
    // Gọi hàm xóa role
    delete_role($id);
}

// Trở về trang danh sách
header("location: role_list.php");
?>
