<!DOCTYPE html>
<html>
<head>
    <title>Danh sách nhân viên</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Sử dụng Ajax để tải dữ liệu nhân viên
        $(document).ready(function() {
            $.ajax({
                url: 'employee_list_api.php',
                type: 'GET',
                success: function(data) {
                    // Hiển thị danh sách nhân viên trong bảng
                    let rows = '';
                    data.forEach(function(item) {
                        rows += `<tr>
                                    <td>${item.first_name}</td>
                                    <td>${item.last_name}</td>
                                    <td>${item.role_name}</td>
                                    <td>${item.department_name}</td>
                                    <td>
                                        <form method="post" action="employee_delete.php">
                                            <input onclick="window.location = 'employee_edit.php?id=${item.employee_id}'" type="button" value="Sửa"/>
                                            <input type="hidden" name="id" value="${item.employee_id}"/>
                                            <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                                        </form>
                                    </td>
                                </tr>`;
                    });
                    $('#employee-table tbody').html(rows);
                },
                error: function() {
                    alert("Đã xảy ra lỗi khi tải dữ liệu.");
                }
            });
        });
    </script>
</head>
<body>
    <h1>Danh sách nhân viên</h1>
    <a href="employee_add.php">Thêm nhân viên</a> <br/> <br/>
    <a href="dashboard.php">Trở về</a> <br/> <br/>
    <table id="employee-table" width="100%" border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <td><b>First name</b></td>
                <td>Last name</td>
                <td>Role</td>
                <td>Departments</td>
                <td>Chọn thao tác</td>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu nhân viên sẽ được hiển thị ở đây bằng Ajax -->
        </tbody>
    </table>
</body>
</html>
