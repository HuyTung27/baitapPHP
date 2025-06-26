<?php
// session_start();
include '../DN_DK/kiemtra_role.php';
checkRole('admin');
require '../libs/qtv_control.php';
$email = $_SESSION['email'];
$students = get_all_students();
$teachers = get_all_teachers();
$coures = get_all_course();
if (!empty($_POST['QTV'])) {

    $buttonValue = $_POST['QTV-btn'];

    if ($buttonValue == "add_st") {
        $data['st_name']        = isset($_POST['name_st']) ? $_POST['name_st'] : '';
        $data['st_mail']        = isset($_POST['mail_st']) ? $_POST['mail_st'] : '';
        $data['st_sex']         = isset($_POST['gender_st']) ? $_POST['gender_st'] : '';
        $data['st_birthday']    = isset($_POST['dob_st']) ? $_POST['dob_st'] : '';

        // Validate thông tin
        $errors = array();
        if (empty($data['st_name'])) {
            $errors[] = 'Chưa nhập tên học sinh';
        }

        if (empty($data['st_mail'])) {
            $errors[] = 'Chưa nhập email học sinh';
        }

        // Nếu không có lỗi về thông tin thì gọi hàm add_student
        if (empty($errors)) {
            $result = add_student($data['st_name'], $data['st_mail'], $data['st_sex'], $data['st_birthday']);

            // Nếu hàm add_student trả về chuỗi lỗi
            if ($result !== true) {
                $errors[] = $result; // Thêm lỗi từ hàm add_student vào mảng lỗi
            }
        }

        // Nếu có lỗi, hiển thị thông báo lỗi bằng JavaScript
        if (!empty($errors)) {
            // Chuyển mảng lỗi thành chuỗi JSON để truyền sang JavaScript
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);  // Sử dụng alert để hiện lỗi
            </script>";
        } else {
            // Nếu thành công
            echo "<script>alert('Đăng ký thành công!');</script>";
            $students = get_all_students();
        }
    }

    //Thêm giảng viên
    else if ($buttonValue == 'add_tc') {
        $data['tc_name']        = isset($_POST['name_tc']) ? $_POST['name_tc'] : '';
        $data['tc_mail']        = isset($_POST['mail_tc']) ? $_POST['mail_tc'] : '';
        $data['tc_degree']      = isset($_POST['degree_tc']) ? $_POST['degree_tc'] : '';
        $data['tc_major']       = isset($_POST['major_tc']) ? $_POST['major_tc'] : '';

        // Validate thông tin
        $errors = array();
        if (empty($data['tc_name'])) {
            $errors[] = 'Chưa nhập tên giảng viên';
        }

        if (empty($data['tc_mail'])) {
            $errors[] = 'Chưa nhập email giảng viên';
        }

        // Nếu có lỗi
        if (!empty($errors)) {
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);
            </script>";
        } else {
            // Nếu không có lỗi thì thêm giảng viên
            add_teacher($data['tc_name'], $data['tc_mail'], $data['tc_degree'], $data['tc_major']);
            $teachers = get_all_teachers();
        }
    }
    // Xoa hoc sinh
    else if ($buttonValue == 'delete_st') {
        $data['st_id'] = isset($_POST['id_st']) ? $_POST['id_st'] : '';

        // Validate thông tin
        $errors = array();
        if (empty($data['st_id'])) {
            $errors[] = 'Chưa nhập mã cần xóa';
        }

        if (!empty($errors)) {
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);
            </script>";
        } else {
            delete_st($data['st_id']);
            header("Location: " . $_SERVER['PHP_SELF'] . "#sv");
            exit();
        }
    }
    // Xoa giang vien
    else if ($buttonValue == 'delete_tc') {
        $data['tc_id'] = isset($_POST['id_tc']) ? $_POST['id_tc'] : '';

        // Validate thông tin
        $errors = array();
        if (empty($data['tc_id'])) {
            $errors[] = 'Chưa nhập mã cần xóa';
        }

        if (!empty($errors)) {
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);
            </script>";
        } else {
            delete_tc($data['tc_id']);
            header("Location: " . $_SERVER['PHP_SELF'] . "#gv");
            exit();
        }
    }
    // Sua hoc sinh
    else if ($buttonValue == 'update_st') {
        $data['st_name'] = isset($_POST['name']) ? $_POST['name'] : '';
        $data['st_mail'] = isset($_POST['mail']) ? $_POST['mail'] : '';
        $data['st_sex']  = isset($_POST['gender']) ? $_POST['gender'] : '';
        $data['st_birthday'] = isset($_POST['dob']) ? $_POST['dob'] : '';

        // Validate thông tin
        $errors = array();
        if (empty($data['st_name'])) {
            $errors[] = 'Chưa nhập tên học sinh';
        }

        if (empty($data['st_mail'])) {
            $errors[] = 'Chưa nhập email học sinh';
        }

        if (!empty($errors)) {
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);
            </script>";
        } else {
            update_student($data['st_name'], $data['st_mail'], $data['st_sex'], $data['st_birthday']);
            header("Location: " . $_SERVER['PHP_SELF'] . "#sv");
            exit();
        }
    }
    // Sua giang vien
    else if ($buttonValue == 'update_tc') {
        $data['tc_name']   = isset($_POST['name']) ? $_POST['name'] : '';
        $data['tc_mail']   = isset($_POST['email']) ? $_POST['email'] : '';
        $data['tc_degree'] = isset($_POST['degree']) ? $_POST['degree'] : '';
        $data['tc_major']  = isset($_POST['major']) ? $_POST['major'] : '';
        $data['tc_exp']    = isset($_POST['experience']) ? $_POST['experience'] : '';

        // Validate thông tin
        $errors = array();
        if (empty($data['tc_name'])) {
            $errors[] = 'Chưa nhập tên giảng viên';
        }

        if (empty($data['tc_mail'])) {
            $errors[] = 'Chưa nhập email giảng viên';
        }

        if (!empty($errors)) {
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);
            </script>";
        } else {
            update_teacher($data['tc_name'], $data['tc_mail'], $data['tc_degree'], $data['tc_major'], $data['tc_exp']);
            header("Location: " . $_SERVER['PHP_SELF'] . "#gv");
            exit();
        }
    } else if ($buttonValue == 'news') {
        $content_news = $_POST['notification'];
        $file = 'noti.txt';
        file_put_contents($file, $content_news);
    }
    //Them khoa hoc 
    else if ($buttonValue == 'add_course') {
        $course_name = $_POST['name_cou'];
        $teacher_email = $_POST['tc'];
        $description = $_POST['des_cou'];
        $time = $_POST['time'];
        $cost=$_POST['cost'];

        // Validate thông tin
        $errors = array();
        if (empty($course_name)) {
            $errors[] = 'Chưa nhập tên khóa học';
        }

        if (empty($teacher_email)) {
            $errors[] = 'Chưa chọn giảng viên';
        }

        if (!empty($errors)) {
            $errors_json = json_encode($errors);
            echo "<script>
                const errors = $errors_json;
                let errorMessage = 'Đã xảy ra lỗi:\\n';
                errors.forEach(function(error) {
                    errorMessage += '- ' + error + '\\n';
                });
                alert(errorMessage);
            </script>";
        } else {
            if (add_course($course_name, $teacher_email, $description, $time,$cost)) {
                header("Location: " . $_SERVER['PHP_SELF'] . "#kh");
                exit();
            } else {
                echo "<script>alert('Lỗi khi thêm khóa học. Vui lòng thử lại.');</script>";
            }
        }
    } else if ($buttonValue == 'find_st') {
        $require = $_POST['require_st'];
        $find = $_POST['findd_st'];
        if ($find == 'Email') {
            $students = get_students_by_email($require);
        } else if ($find == "Tên") {
            $students = get_students_by_name($require);
        } else if ($find == "Giới tính") {
            $gender = $_POST['gender_st'];
            $students = get_students_by_gender($gender);
        }else if ($find == 'Tài khoản bị khóa'){
            $students=get_locked_students();
        }
         else {
            $students = get_all_students();
        }
    } else if ($buttonValue == 'find_kh') {
        $require = $_POST['require_kh'];
        $find = $_POST['findd_kh'];
        if ($find == 'Tên khóa học') {
            $coures = get_course_by_name($require);
        } else if ($find == "Giảng viên") {
            $email = $_POST['tc'];
            $coures = get_course_by_email($email);
        } else if ($find == "Thời lượng") {
            $coures = get_course_by_time($require);
        } else if ($find == "Chi phí") {
            $coures = get_course_by_cost($require);
        } else {
            $coures = get_all_course();
        }
    } else if ($buttonValue == 'find_tc') {
        $require = $_POST['require_tc'];
        $find = $_POST['findd_tc'];
        if ($find == 'Email') {
            $teachers = get_teacher_by_mail($require);
        } else if ($find == "Tên") {
            $teachers = get_teacher_by_name($require);
        } else if ($find == "Trình độ") {
            $degree = $_POST['degree_tc'];
            $teachers = get_teacher_by_degree($degree);
        } else if ($find == "Chuyên môn") {
            $teachers = get_teacher_by_major($require);
        } else if ($find == "Năm kinh nghiệm") {
            $teachers = get_teacher_by_exp($require);
        }else if ($find == 'Tài khoản bị khóa'){
            $teachers=get_locked_teachers();
        } else {
            $teachers = get_all_teachers();
        }
    } else if ($buttonValue == 'doimk') {
        $oldpass = $_POST['oldpass'];
        $new = $_POST['newpass'];
        $confpass = $_POST['confpass'];

        // Mảng để lưu các lỗi
        $errors = array();

        // Kiểm tra xác nhận mật khẩu mới có khớp không
        if ($new != $confpass) {
            $errors['confpass'] = 'Mật khẩu xác nhận không trùng khớp với mật khẩu mới.';
        }

        // Nếu không có lỗi, thực hiện việc thay đổi mật khẩu
        if (empty($errors)) {
            $result = change_pass($email, $oldpass, $new);

            if ($result) {
                // Mật khẩu thay đổi thành công
                echo "<script>alert('Đổi mật khẩu thành công.'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            } else {
                // Thông báo lỗi khi không thể đổi mật khẩu
                echo "<script>alert('Mật khẩu hiện tại không chính xác hoặc có lỗi.');</script>";
            }
        } else {
            // Hiển thị thông báo lỗi nếu có
            foreach ($errors as $error) {
                echo "<script>alert('$error');</script>";
            }
        }
    }
}
disconnect_db();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="QTV.css">
    <script src="https://kit.fontawesome.com/c73158e4d5.js" crossorigin="anonymous"></script>
    <title>FastLearn</title>
    <script src="QTV.js"></script>
</head>

<body>
    <div class="container" id="container">
        <div class="icon-container">
            <i class="fas fa-user-circle user-icon"></i>
        </div>
        <div class="button-container">
            <button class="option-button doimk">Thay Đổi Mật Khẩu</button>
        </div>
        <div class="close-button">
            <i class="fas fa-times"></i>
        </div>
    </div>

    <dialog id="dialog-form-huy">
        <form method="POST" class="form-dang-ky" action="QTV.php">
            <input type="hidden" name="QTV" value="1">
            <!-- Thêm input hidden để gửi giá trị QTV-btn -->
            <input type="hidden" name="QTV-btn" value="doimk">
            <div class="header-dialog">
                <h1>Đổi Mật Khẩu</h1>
            </div>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>"
                readonly />
            <input type="password" name="oldpass" placeholder="Mật khẩu hiện tại" required />
            <input type="password" name="newpass" placeholder="Mật khẩu mới" required />
            <input type="password" name="confpass" placeholder="Nhập lại mật khẩu mới" required />
            <button type="button" class="confirm-btn">Đổi Mật Khẩu</button>
        </form>
    </dialog>

    <!-- Dialog xác nhận đổi mật khẩu -->
    <dialog id="dialog-confirm">
        <form method="dialog" class="form-confirm">
            <h2>Xác nhận</h2>
            <p>Bạn có chắc chắn muốn đổi mật khẩu?</p>
            <menu>
                <button value="cancel" class="btn_huy" onclick="document.getElementById('dialog-form-sgv').close();">Hủy</button>
                <button type="button" class="confirm btn_xacnhan">Xác nhận</button>
            </menu>
        </form>
    </dialog>


    <header class="dau-trang">
        <div class="khung-dau-trang">
            <div class="logo">
                <a href=""><img src="logo_web.png" alt="Logo"></a>
            </div>
            <nav class="dieu-huong">
                <ul>
                    <li><a href="#kh">Các Khóa Học</a></li>
                    <li><a href="#sv">Sinh Viên</a></li>
                    <li><a href="#gv">Giảng Viên</a></li>
                    <li><a href="#tb">Thông Báo</a></li>
                    <li><a href="../SubPage/TL.php">Thảo Luận</a></li>
                </ul>
            </nav>
            <div class="menu-icon">
                <i class="fa-solid fa-bars" style="font-size: 30px;cursor: pointer;"></i>
            </div>

        </div>
    </header>


    <main class="noi-dung-chinh">
        <section class="giao-vien">
            <h2 id="kh">Khóa Học</h2>
            <table class="bang-giao-vien">
                <thead>
                    <tr>
                        <th>Mã khóa học</th>
                        <th>Tên khóa học</th>
                        <th>Giảng viên</th>
                        <th>Mô tả</th>
                        <th>Thời lượng</th>
                        <th>Chi phí</th>
                    </tr>
                </thead>
            </table>
            <div class="table-container">
                <table class="bang-giao-vien">
                    <tbody>
                        <?php foreach ($coures as $item) { ?>
                        <tr>
                            <td><?php echo $item['id_cou']; ?></td>
                            <td><?php echo $item['cou_name']; ?></td>
                            <td><?php echo $item['teacher_name']; ?></td>
                            <td><?php echo $item['cou_des']; ?></td>
                            <td><?php echo $item['cou_time']; ?></td>
                            <td><?php echo $item['cost']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="nut-dieu-khien">
                <button class="nut nut-them tkh">Thêm</button>
                <button class="nut nut-tim kkh" style="background-color: blueviolet;color: aliceblue;">Tìm</button>
            </div>
        </section>

        <!-- Dialog box tim khoa hoc -->
        <dialog id="dialog-form-kkh">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Tìm kiếm Khóa Học</h3>

                <label for="gender">Tìm kiếm theo:</label>
                <select id="select" name="findd_kh" onchange="toggleTeacherField()">
                    <option value="None">Lựa chọn cách tìm kiếm</option>
                    <option value="Tên khóa học">Tên khóa học</option>
                    <option value="Giảng viên">Giảng viên</option>
                    <option value="Thời lượng">Thời lượng</option>
                    <option value="Chi phí">Chi phí</option>
                </select>

                <label for="course">Nhập :</label>
                <input type="text" id="course" name="require_kh">

                <!-- Phần label và select của giáo viên sẽ được ẩn/hien -->
                <div id="teacherField" style="display: none;">
                    <label for="teacher">Giảng viên:</label>
                    <select id="teacher" name="tc" required>
                        <?php
                        // Loop through the $teachers variable to generate dropdown options
                        foreach ($teachers as $teacher) {
                            $name = $teacher['name'];
                            $email = $teacher['email'];
                            echo "<option value='$email'>$name - $email</option>";
                        }
                        ?>
                    </select>
                </div>

                <menu>
                    <button type="button" value="cancel"
                        onclick="document.getElementById('dialog-form-kkh').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="find_kh">Tìm kiếm</button>
                </menu>
            </form>
        </dialog>

        <!-- Dialog box thêm khoa hoc -->
        <dialog id="dialog-form-tkh">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Thêm Khóa Học</h3>

                <label for="name_cou">Tên khóa học</label>
                <input type="text" id="name_cou" name="name_cou" required>

                <label for="teacher">Giảng viên:</label>
                <select id="teacher" name="tc" required>
                    <?php
                    // Loop through the $teachers variable to generate dropdown options
                    foreach ($teachers as $teacher) {
                        $name = $teacher['name'];
                        $email = $teacher['email'];
                        echo "<option value='$email'>$name - $email</option>";
                    }
                    ?>
                </select>

                <label for="des_cou">Mô tả</label>
                <input type="text" id="des_cou" name="des_cou" required>

                <label for="time">Thời lượng</label>
                <input type="text" id="time" name="time" required>

                <label for="time">Chi phí</label>
                <input type="text" id="cost" name="cost" required>

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button value="cancel" onclick="document.getElementById('dialog-form-tkh').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="add_course">Thêm Khóa Học</button>
                </menu>
            </form>
        </dialog>




        </section>

        <section class="giao-vien">
            <h2 id="sv">Sinh Viên</h2>
            <table class="bang-giao-vien">
                <thead>
                    <tr>
                        <th>Mã học sinh</th>
                        <th>Họ và Tên</th>
                        <th>Email</th>
                        <th>Giới Tính</th>
                        <th>Ngày Sinh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
            </table>
            <div class="table-container">
                <table class="bang-giao-vien">
                    <tbody>
                        <?php foreach ($students as $item) { ?>
                        <tr>
                            <td><?php echo $item['id_st']; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php echo $item['sex']; ?></td>
                            <td><?php echo $item['birth_d']; ?></td>
                            <td>
                                <button class="nut nut-xoa xsv" data-id="<?php echo $item['id_st']; ?>">Khóa</button>
                                <button class="nut nut-sua ssv">Sửa</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="nut-dieu-khien">
                <button class="nut nut-them tsv">Thêm</button>
                <button class="nut nut-tim ksv" style="background-color: blueviolet;color: aliceblue;">Tìm</button>
            </div>
        </section>

        <!-- Dialog box tim sinh viên -->
        <dialog id="dialog-form-ksv">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Tìm kiếm Sinh Viên</h3>

                <label for="gender">Tìm kiếm theo:</label>
                <select id="select1" name="findd_st" onchange="toggleStudentField()">
                    <option value="None">Lựa chọn cách tìm kiếm</option>
                    <option value="Email">Email</option>
                    <option value="Tên">Tên</option>
                    <option value="Giới tính">Giới tính</option>
                    <option value="Tài khoản bị khóa">Tài khoản bị khóa</option>
                </select>

                <label for="course">Nhập :</label>
                <input type="text" id="course" name="require_st">

                <div id="studentField" style="display: none;">
                    <label for="gender">Giới Tính:</label>
                    <select id="gender" name="gender_st">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
                <menu>
                    <button type="button" value="cancel"
                        onclick="document.getElementById('dialog-form-ksv').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="find_st">Tìm kiếm</button>
                </menu>
            </form>
        </dialog>


        <!-- Dialog box thêm sinh viên -->
        <dialog id="dialog-form-tsv">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Đăng Ký Sinh Viên</h3>
                <label for="course">Email:</label>
                <input type="text" id="course" name="mail_st">

                <label for="name">Họ và Tên:</label>
                <input type="text" id="name" name="name_st" required>

                <label for="gender">Giới Tính:</label>
                <select id="gender" name="gender_st">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>

                <label for="dob">Ngày Sinh:</label>
                <input type="date" id="dob" name="dob_st">

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button value="cancel" onclick="document.getElementById('dialog-form-tsv').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="add_st">Đăng Ký</button>
                </menu>
            </form>
        </dialog>

        <!-- Dialog box xóa sinh viên -->
        <dialog id="dialog-form-xsv">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Xóa Sinh Viên</h3>
                <label for="name">Mã sinh viên:</label>
                <input type="text" id="name" name="id_st">

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button value="cancel" onclick="document.getElementById('dialog-form-xsv').close();">Hủy</button>
                    <button type="submit" name='QTV-btn' value="delete_st">Khóa</button>
                </menu>
            </form>
        </dialog>

        <!-- Dialog box sửa sinh viên -->
        <dialog id="dialog-form-ssv">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Sửa thông tin Sinh Viên</h3>

                <label for="studentName">Họ và Tên:</label>
                <input type="text" id="studentName" name="name" value="">

                <label for="studentEmail">Email:</label>
                <input type="text" id="studentEmail" name="mail" value="" readonly>

                <label for="studentGender">Giới Tính:</label>
                <select id="studentGender" name="gender">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>

                <label for="studentDob">Ngày Sinh:</label>
                <input type="date" id="studentDob" name="dob" value="">

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button type="button" value="cancel"
                        onclick="document.getElementById('dialog-form-ssv').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="update_st">Sửa</button>
                </menu>
            </form>
        </dialog>

        <section class="giao-vien">
            <h2 id="gv">Giảng Viên</h2>
            <table class="bang-giao-vien">
                <thead>
                    <tr>
                        <th>Mã giảng viên</th>
                        <th>Họ và Tên</th>
                        <th>Email</th>
                        <th>Trình độ</th>
                        <th>Chuyên môn</th>
                        <th>Năm kinh nghiệm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
            </table>
            <div class="table-container">
                <table class="bang-giao-vien">
                    <tbody>
                        <?php
                        foreach ($teachers as $item) { ?>
                        <tr>
                            <td><?php echo $item['id_tc']; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php echo $item['degree']; ?></td>
                            <td><?php echo $item['major']; ?></td>
                            <td><?php echo $item['exp_years']; ?></td>
                            <td>
                                <button class="nut nut-xoa xgv" data-id="<?php echo $item['id_tc']; ?>">Khóa</button>
                                <button class="nut nut-sua sgv">Sửa</button>
                            </td>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="nut-dieu-khien">
                <button class="nut nut-them tgv">Thêm</button>
                <button class="nut nut-tim ktc" style="background-color: blueviolet;color: aliceblue;">Tìm</button>
            </div>
        </section>

        <!-- Dialog box tim sinh viên -->
        <dialog id="dialog-form-ktc">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Tìm kiếm Giảng viên</h3>

                <label for="gender">Tìm kiếm theo:</label>
                <select id="select2" name="findd_tc" onchange="toggleDegreeField()">
                    <option value="None">Lựa chọn cách tìm kiếm</option>
                    <option value="Email">Email</option>
                    <option value="Tên">Tên</option>
                    <option value="Trình độ">Trình độ</option>
                    <option value="Chuyên môn">Chuyên môn</option>
                    <option value="Năm kinh nghiệm">Năm kinh nghiệm</option>
                    <option value="Tài khoản bị khóa">Tài khoản bị khóa</option>
                </select>

                <label for="course">Nhập :</label>
                <input type="text" id="course" name="require_tc">

                <div id="DegreeField" style="display: none;">
                    <label for="gender">Trình độ:</label>
                    <select id="gender" name="degree_tc">
                        <option value="Thạc sĩ">Thạc sĩ</option>
                        <option value="Tiến sĩ">Tiến sĩ</option>
                    </select>
                </div>
                <menu>
                    <button type="button" value="cancel"
                        onclick="document.getElementById('dialog-form-ktc').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="find_tc">Tìm kiếm</button>
                </menu>
            </form>
        </dialog>

        <!-- Dialog box bảng giảng viên -->
        <dialog id="dialog-form-tgv">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="2">
                <h3>Đăng Ký Giảng Viên</h3>
                <label for="course">Email:</label>
                <input type="text" id="course" name="mail_tc">

                <label for="name">Họ và Tên:</label>
                <input type="text" id="name" name="name_tc" required>

                <label for="gender">Trình độ:</label>
                <select id="gender" name="degree_tc">
                    <option value="Thạc sĩ">Thạc sĩ</option>
                    <option value="Tiến sĩ">Tiến sĩ</option>
                </select>

                <label for="name">Chuyên môn:</label>
                <input type="text" id="name" name="major_tc" required>

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button type="button" value="cancel"
                        onclick="document.getElementById('dialog-form-tgv').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="add_tc">Thêm giảng viên</button>
                </menu>
            </form>
        </dialog>

        <!-- Dialog box xóa giang viên -->
        <dialog id="dialog-form-xgv">
            <form method="POST" class="form-dang-ky" action="QTV.php">
                <input type="hidden" name="QTV" value="1">
                <h3>Xóa Giảng Viên</h3>
                <label for="name">Mã giảng viên:</label>
                <input type="text" id="name" name="id_tc">

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button value="cancel">Hủy</button>
                    <button type="submit" name='QTV-btn' value="delete_tc">Khóa</button>
                </menu>
            </form>
        </dialog>

        <!-- Dialog box sua giảng viên -->
        <dialog id="dialog-form-sgv">
            <form method="POST" action="QTV.php" class="form-dang-ky">
                <input type="hidden" name="QTV" value="1">
                <h3>Sửa Giảng Viên</h3>
                <label for="teacher-name">Họ và Tên:</label>
                <input type="text" id="teacher-name" name="name" value="">

                <label for="teacher-email">Email:</label>
                <input type="email" id="teacher-email" name="email" readonly>

                <label for="teacher-degree">Trình độ:</label>
                <select id="teacher-degree" name="degree">
                    <option value="Thạc sĩ">Thạc sĩ</option>
                    <option value="Tiến sĩ">Tiến sĩ</option>
                </select>

                <label for="teacher-major">Chuyên Môn:</label>
                <input type="text" id="teacher-major" name="major" value="">

                <label for="teacher-experience">Năm Kinh Nghiệm:</label>
                <input type="number" id="teacher-experience" name="experience" value="">

                <!-- Nút trong form để gửi hoặc đóng -->
                <menu>
                    <button type="button" value="cancel"
                        onclick="document.getElementById('dialog-form-sgv').close();">Hủy</button>
                    <button type="submit" name="QTV-btn" value="update_tc">Sửa</button>
                </menu>
            </form>
        </dialog>


        <section class="thong-bao">
            <h2 id="tb">Thông Báo</h2>
            <form method="POST" action="QTV.php">
                <div class="noi-dung-thong-bao">
                    <input type="hidden" name="QTV" value="1">
                    <textarea id="noi-dung" placeholder="Nhập thông báo tại đây..." style="width: 100%; height: 250px;"
                        name='notification'></textarea>
                    <button class="nut-dang-thong-bao" name="QTV-btn" value="news">Đăng Thông Báo</button>
                </div>
            </form>
        </section>

    </main>

    <footer class="chan-trang">
        <div class="cot-chan-trang">
            <img class="logo-chan-trang" src="logo_web.png" alt="Logo" />
        </div>
        <div class="cot-chan-trang thong-tin-chan-trang">
            <p class="mo-ta">
                FastLearn là một nền tảng học tập trực tuyến, chuyên cung cấp các khóa học và tài liệu học tập trong
                nhiều lĩnh vực khác nhau, từ công nghệ thông tin, kinh doanh, tiếp thị, đến các kỹ năng mềm và phát
                triển cá nhân. Nền tảng này thường được thiết kế để giúp người học tiếp cận kiến thức một cách nhanh
                chóng và hiệu quả, với các khóa học ngắn gọn, tập trung vào thực hành và ứng dụng thực tế.
            </p>
            <div class="lien-he">
                <div class="email">fastlearn@gmail.com</div>
                <div class="facebook-text">www.facebook.com/FastLearn</div>
            </div>
        </div>
    </footer>

</body>

</html>
<script>
function toggleTeacherField() {
    // Lấy giá trị hiện tại của select tìm kiếm
    var selectValue = document.getElementById("select").value;

    // Tìm phần tử chứa label và select của giáo viên
    var teacherField = document.getElementById("teacherField");

    // Nếu lựa chọn là "Giảng viên", hiện phần tử
    if (selectValue === "Giảng viên") {
        teacherField.style.display = "block";
    } else {
        teacherField.style.display = "none";
    }
}

function toggleStudentField() {
    // Lấy giá trị hiện tại của select tìm kiếm
    var selectValue = document.getElementById("select1").value;

    // Tìm phần tử chứa label và select của giáo viên
    var teacherField = document.getElementById("studentField");

    // Nếu lựa chọn là "Giảng viên", hiện phần tử
    if (selectValue === "Giới tính") {
        studentField.style.display = "block";
    } else {
        studentField.style.display = "none";
    }
}

function toggleDegreeField() {
    // Lấy giá trị hiện tại của select tìm kiếm
    var selectValue = document.getElementById("select2").value;

    // Tìm phần tử chứa label và select của giáo viên
    var teacherField = document.getElementById("DegreeField");

    // Nếu lựa chọn là "Giảng viên", hiện phần tử
    if (selectValue === "Trình độ") {
        DegreeField.style.display = "block";
    } else {
        DegreeField.style.display = "none";
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút "Sửa"
    const editButtons = document.querySelectorAll('.ssv');

    // Lặp qua từng nút "Sửa"
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy dữ liệu từ hàng chứa nút "Sửa"
            const row = this.closest('tr');
            const studentId = row.cells[0].innerText;
            const studentName = row.cells[1].innerText;
            const studentEmail = row.cells[2].innerText;
            const studentSex = row.cells[3].innerText;
            const studentBirthday = row.cells[4].innerText;

            // Điền dữ liệu vào form
            document.getElementById('studentName').value = studentName;
            document.getElementById('studentEmail').value = studentEmail;
            document.getElementById('studentGender').value = studentSex;
            document.getElementById('studentDob').value = studentBirthday;

            // Hiển thị modal
            document.getElementById('dialog-form-ssv').showModal();
        });
    });

    // Lấy tất cả các nút "Sửa" giảng viên
    const editTeacherButtons = document.querySelectorAll('.sgv');

    // Lặp qua từng nút "Sửa" giảng viên
    editTeacherButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy dữ liệu từ hàng chứa nút "Sửa"
            const row = this.closest('tr');
            const teacherName = row.cells[1].innerText;
            const teacherEmail = row.cells[2].innerText;
            const teacherDegree = row.cells[3].innerText; // Thay đổi chỉ số cho phù hợp với cột
            const teacherMajor = row.cells[4].innerText; // Thay đổi chỉ số cho phù hợp với cột
            const teacherExperience = row.cells[5]
                .innerText; // Thay đổi chỉ số cho phù hợp với cột

            // Điền dữ liệu vào form
            document.getElementById('teacher-name').value = teacherName;
            document.getElementById('teacher-email').value =
                teacherEmail; // Thay đổi id cho phù hợp
            document.getElementById('teacher-degree').value =
                teacherDegree; // Thay đổi id cho phù hợp
            document.getElementById('teacher-major').value =
                teacherMajor; // Thay đổi id cho phù hợp
            document.getElementById('teacher-experience').value =
                teacherExperience; // Thay đổi id cho phù hợp

            // Hiển thị modal sửa giảng viên
            document.getElementById('dialog-form-sgv').showModal();
        });
    });

    const editCourseButtons = document.querySelectorAll('.skh');



    // Lấy tất cả các nút xóa sinh viên, giảng viên và khóa học
    const deleteStudentButtons = document.querySelectorAll('.nut-xoa.xsv'); // Nút xóa sinh viên
    const deleteTeacherButtons = document.querySelectorAll('.nut-xoa.xgv'); // Nút xóa giảng viên

    // Lấy các dialog và input tương ứng
    const studentDialog = document.getElementById('dialog-form-xsv');
    const teacherDialog = document.getElementById('dialog-form-xgv');
    const studentIdInput = studentDialog.querySelector('input[name="id_st"]');
    const teacherIdInput = teacherDialog.querySelector('input[name="id_tc"]');
    // Hàm xử lý sự kiện xóa sinh viên
    function handleDeleteStudent(button) {
        const studentId = button.getAttribute('data-id'); // Lấy mã sinh viên từ data-id
        const confirmDelete = confirm("Bạn có chắc chắn muốn xóa sinh viên với mã ID: " + studentId + "?");

        if (confirmDelete) {
            studentIdInput.value = studentId; // Điền mã sinh viên vào input trong form
            studentDialog.showModal(); // Hiển thị dialog để người dùng xác nhận lần cuối
        }
    }

    // Hàm xử lý sự kiện xóa giảng viên
    function handleDeleteTeacher(button) {
        const teacherId = button.getAttribute('data-id'); // Lấy mã giảng viên từ data-id
        const confirmDelete = confirm("Bạn có chắc chắn muốn xóa giảng viên với mã ID: " + teacherId + "?");

        if (confirmDelete) {
            teacherIdInput.value = teacherId; // Điền mã giảng viên vào input trong form
            teacherDialog.showModal(); // Hiển thị dialog để người dùng xác nhận lần cuối
        }
    }


    // Gắn sự kiện click cho các nút xóa sinh viên
    deleteStudentButtons.forEach(button => {
        button.addEventListener('click', function() {
            handleDeleteStudent(this); // Gọi hàm xử lý khi click nút xóa sinh viên
        });
    });

    // Gắn sự kiện click cho các nút xóa giảng viên
    deleteTeacherButtons.forEach(button => {
        button.addEventListener('click', function() {
            handleDeleteTeacher(this); // Gọi hàm xử lý khi click nút xóa giảng viên
        });
    });


});
</script>