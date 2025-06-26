<?php
session_start(); // Bắt đầu session
require '../libs/hs_control.php'; // Import thư viện điều khiển học sinh

// Lấy email từ session để lấy thông tin học sinh
$email = $_SESSION['email'];
$student = get_student_by_email($email);  // Lấy thông tin học sinh qua email
$teacher=get_teachers();
$id_st=get_id($email);
if (!empty($_POST['HS'])) {  // Kiểm tra xem có dữ liệu POST từ học sinh không
  $buttonValue = $_POST['btn-hs'];  // Lấy giá trị của nút bấm

  if ($buttonValue == 'cap-nhat') {
    // Lấy dữ liệu từ form
    $data['name']        = isset($_POST['name']) ? $_POST['name'] : '';
    $data['email']       = isset($_POST['email']) ? $_POST['email'] : '';
    $data['id_st']       = isset($_POST['id_st']) ? $_POST['id_st'] : ''; // Lấy mã sinh viên
    $data['birth_d']     = isset($_POST['birth_d']) ? $_POST['birth_d'] : ''; // Lấy ngày sinh
    $data['sex']         = isset($_POST['sex']) ? $_POST['sex'] : ''; // Lấy giới tính

    // Validate thông tin
    $errors = array();
    if (empty($data['name'])) {
      $errors['name'] = 'Chưa nhập tên học sinh';
    }
    if (empty($data['id_st'])) {
      $errors['id_st'] = 'Chưa nhập mã sinh viên';
    }
    if (empty($data['birth_d'])) {
      $errors['birth_d'] = 'Chưa nhập ngày sinh';
    }

    // Nếu không có lỗi, thực hiện cập nhật
    if (!$errors) {
      update_student_info($data['email'], $data['name'], $data['id_st'], $data['birth_d'], $data['sex']);
      $_SESSION['message'] = 'Cập nhật thông tin thành công!';
      header("Location: " . $_SERVER['PHP_SELF']); // Load lại trang sau khi cập nhật
      exit();
    } else {
      // Hiển thị lỗi (nếu có)
      foreach ($errors as $error) {
        echo "<script>alert('" . $error . "');</script>";
      }
    }

  } else if ($buttonValue == 'doimk') {
    // Xử lý đổi mật khẩu
    $email = $_POST['email'];
    $oldPass = $_POST['old_pass'];
    $newPass = $_POST['new_pass'];
    $checkPass = $_POST['check_pass'];  // Lấy giá trị mật khẩu xác nhận

    // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp nhau không
    if ($newPass !== $checkPass) {
      echo "<script>alert('Mật khẩu xác nhận không khớp với mật khẩu mới!');</script>";
    } else {
      // Gọi hàm change_pass để xử lý đổi mật khẩu
      $result = change_pass($email, $oldPass, $newPass);

      // Kiểm tra kết quả trả về từ hàm change_pass
      if ($result['success']) {
        echo "<script>alert('" . $result['message'] . "');</script>";
      } else {
        echo "<script>alert('" . $result['message'] . "');</script>";
      }
    }
  }
  elseif($buttonValue=='gui'){
    $teacher_id = $_POST['teacher_id'];
    $question = $_POST['question'];
    $errors = array();
    if (empty($question)) {
      $errors['question'] = 'chưa đặt câu hỏi';
    }
    if (!$errors) {
      add_discussion($id_st, $teacher_id,$question);
      header("Location: " . $_SERVER['PHP_SELF']); // Load lại trang sau khi cập nhật
      exit();
    } else {
      // Hiển thị lỗi (nếu có)
      foreach ($errors as $error) {
        echo "<script>alert('" . $error . "');</script>";
      }
    }
  }
  elseif($buttonValue == 'feedback'){ 
    $feedback = $_POST['feedback']; 
} 

$errors = array(); 

if (empty($feedback)) { 
    $errors['feedback'] = 'chưa nhập feedback'; 
} 

if (!$errors) { 
    if (add_feedback($id_st, $feedback)) {
        // Hiển thị thông báo feedback thành công
        echo "<script>alert('Đã gửi feedback thành công!');</script>";
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>"; // Load lại trang sau khi cập nhật
        exit();
    }
} else { 
    // Hiển thị lỗi (nếu có) 
    foreach ($errors as $error) { 
        echo "<script>alert('" . $error . "');</script>"; 
    } 
}
}
?>
<?php

if (isset($_SESSION['message'])) {
    echo '<script>alert("' . $_SESSION['message'] . '");</script>';
    // Xóa thông báo sau khi hiển thị để tránh hiển thị lại khi tải trang lần sau
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="HS.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>
  <body>
    
    <div >
      <div class="div">
        <div class="overlap">
        <header class="header">
          <div class="overlap-group"> 
            <div class="tm-kim">
              <div class="overlap-group-2">
                <i class="fa fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Tìm kiếm bài học" />
                
              </div>
              
            </div>
            
          </div>
        </header>

          <a href="" ><img class="logo" src="logo_web.png" /></a>
          <i class="fa fa-bars icon-menubar "></i>
          <div class="container" id="container">
            <div class="icon-container">
                <i class="fas fa-user-circle user-icon"></i>
            </div>
            <div class="button-container">
                <button class="option-button thongtin">Hồ sơ tài khoản</button>
                <button class="option-button doimk">Thay Đổi Mật Khẩu</button>
                <button class="option-button" onclick="document.getElementById('dialog-feedback').showModal();">Gửi Phản Hồi</button>
                <button class="option-button thongbao" id="notificationButton">Thông Báo</button>
            </div>
            <div class="close-button">
                <i class="fas fa-times"></i>
            </div>
          </div>
          
   

<dialog id="dialog-feedback">
  <form method="post" class="form-feedback" action="HS.php">
  <input type="hidden" name="HS" value="1">
  <input type="hidden" name="btn-hs" value="feedback">
      <div class="header-dialog">
          <h1>Phản Hồi</h1>
      </div>
      <label for="feedback">Nhập phản hồi của bạn:</label>
      <textarea id="feedback" name="feedback" placeholder="Viết phản hồi của bạn ở đây..." required></textarea>
      <button type="submit" class="send-feedback-btn" value="feedback" name="btn-hs">Gửi</button>
      <button type="button" class="cancel-feedback-btn" onclick="document.getElementById('dialog-feedback').close();">Hủy</button>
  </form>
</dialog>

<dialog id="dialog_thongtin">
  <h2>Thông Tin Hồ Sơ Học Sinh</h2>
  <form class="form-dang-ky" method="post" action="HS.php">
    <input type="hidden" name="HS" value="1">
    
    <label for="name">Họ và Tên:</label>
    <input type="text" id="name" name="name" placeholder="Nhập họ và tên"
      value="<?php echo htmlspecialchars($student['name'] ?? ''); ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder=""
      value="<?php echo htmlspecialchars($email); ?>" readonly>

    <label for="id-st">Mã Sinh Viên:</label>
    <input type="text" id="id-st" name="id_st" placeholder="Nhập mã sinh viên"
      value="<?php echo htmlspecialchars($student['id_st'] ?? ''); ?>" readonly>

    <label for="birth_d">Ngày Sinh:</label>
    <input type="date" id="birth_d" name="birth_d" placeholder="Nhập ngày sinh"
      value="<?php echo htmlspecialchars($student['birth_d'] ?? ''); ?>" required>

    <label for="sex">Giới Tính:</label>
    <select id="sex" name="sex">
      <option value="nam" <?php echo (isset($student['sex']) && $student['sex'] == 'nam') ? 'selected' : ''; ?>>Nam</option>
      <option value="nu" <?php echo (isset($student['sex']) && $student['sex'] == 'nu') ? 'selected' : ''; ?>>Nữ</option>
      <option value="khac" <?php echo (isset($student['sex']) && $student['sex'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
    </select>

    <menu>
      <button type="submit" name='btn-hs' value="cap-nhat">Cập Nhật</button>
      <button type="button" onclick="document.getElementById('dialog_thongtin').close()">Hủy Bỏ</button>
    </menu>
  </form>
</dialog>


          <!-- đổi mk -->
          <dialog id="dialog-form-huy">
          <form method="post" class="form-dang-ky" action="HS.php">
            <input type="hidden" name="HS" value="1">
            <input type="hidden" name="btn-hs" value="doimk">
            <div class="header-dialog">
              <h1>Đổi Mật Khẩu</h1>
            </div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder=""
              value="<?php echo htmlspecialchars($email); ?>" readonly>
            <input type="password" name="old_pass" placeholder="Mật khẩu hiện tại" required />
            <input type="password" name="new_pass" placeholder="Mật khẩu mới" required />
            <input type="password" name="check_pass" placeholder="Nhập lại mật khẩu mới" required />
            <button type="button" class="confirm-btn">Đổi Mật Khẩu</button>
          </form>
        </dialog>

        <!-- Dialog xác nhận -->
        <dialog id="dialog-confirm">
          <h2>Xác nhận</h2>
          <p>Bạn có chắc chắn muốn đổi mật khẩu?</p>
          <menu>
            <button class="btn_huy" type="button" onclick="document.getElementById('dialog-confirm').close();">Hủy</button>
            <button class="btn_xacnhan" type="button">Xác nhận</button>
          </menu>
        </dialog>

<!-- Dialog để hiển thị thông tin -->
<dialog id="dialog-image-info">
  <form method="dialog" class="form-image-info">
    <div class="header-dialog">
      <h1>Giảng Viên</h1>
      
    </div>
    <div class="image-info-content">
      <p><strong>Họ và tên:</strong>demo </p>
      <p id="image-info-description">giới thiệu về giảng viên...</p>
    </div>
    <button type="button" class="close-dialog-btn" onclick="document.getElementById('dialog-image-info').close();">Đóng</button>
  </form>
</dialog>

            
        <div class="overlap-2">
          <i class="fa-solid fa-home home-icon" onclick="scrollToTop()"></i>
          <div class="text-wrapper-3"><a href="#baigiang" >Khóa Học</a></div>
          <div class="text-wrapper-4"><a href="#tailieu" >Giảng Viên</a></div>
          <div class="text-wrapper-5"><a href="../SubPage/TL.php">Thảo Luận</a></div>
      </div>

      <div id="baigiang" class="overlap-4">
      <div class="bi-ging-online">

    <div class="text-wrapper-8"><i class="fa-solid fa-book "></i>Khóa Học</div>

    <div class="slider-wrapper">
        <div class="images">
            <div class="bai_giang"><a href="../SubPage/KhoaHoc.php?id=20240410"><img src="image1.jpg" alt="" width="100%" height="100%"></a></div>
            <div class="bai_giang"><a href="../SubPage/KhoaHoc.php?id=20240411"><img src="image2.jpg" alt="" width="100%" height="100%"></a></div>
            <div class="bai_giang"><a href="../SubPage/KhoaHoc.php?id=20240412"><img src="image3.jpg" alt="" width="100%" height="100%"></a></div>
            <div class="bai_giang"><a href="../SubPage/KhoaHoc.php?id=20240413"><img src="image4.jpg" alt="" width="100%" height="100%"></a></div>
            <div class="bai_giang"><a href="../SubPage/KhoaHoc.php?id=20240414"><img src="image5.jpg" alt="" width="100%" height="100%"></a></div>
            <div class="bai_giang"><a href="../SubPage/KhoaHoc.php?id=20240415"><img src="image6.jpg" alt="" width="100%" height="100%"></a></div>
        </div>
    </div>
    <i class="fa-solid fa-angle-left polygon"></i>
    <i class="fa-solid fa-angle-right polygon-2"></i>
</div>

</div>

<div id="tailieu" class="overlap-6">
    <div class="ti-liu">
        <div class="text-wrapper-10">
            <i class="fa-solid fa-file-alt"></i>
            Giảng Viên
        </div>
        <div class="slider-wrapper-2">
            <div class="images-2">
                <?php foreach ($teacher as $index => $teacherItem): ?>
                    <div class="tai_lieu">
                        <img src="image<?php echo ($index + 1); ?>.jpg" 
                            alt="" width="100%" height="100%" 
                            data-teacher-name="<?php echo htmlspecialchars($teacherItem['name']); ?>"
                            data-teacher-id="<?php echo htmlspecialchars($teacherItem['id_tc']); ?>"
                            data-teacher-intro="<?php echo htmlspecialchars($teacherItem['intro']); ?>"
                            onclick="openTeacherDialog(this)">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <i class="fa-solid fa-angle-left polygon-3"></i>
        <i class="fa-solid fa-angle-right polygon-4"></i>
    </div>
</div>
<dialog id="dialog-teacher" class="dialog-teacher">
    <div class="teacher-info">
        <h2>Thông Tin Giảng Viên</h2>
        <form class="form-thong-tin-giang-vien" method="post" action="HS.php">
            <input type="hidden" name="HS" value="1">
            <input type="hidden" id="teacher_id" name="teacher_id" readonly>

            <label for="teacher-name">Tên Giảng Viên:</label>
            <input type="text" id="teacher-name" name="teacher_name" readonly>
            
            <label for="teacher-intro">Giới Thiệu:</label>
            <input type="text" id="teacher-intro" name="teacher_intro" readonly>
            
            <label for="question">Nhập Câu Hỏi Của Bạn:</label>
            <textarea id="question" name="question" rows="4" placeholder="Nhập câu hỏi của bạn tại đây..." required></textarea>
            
            <menu>
            <button type="submit" name='btn-hs' value="gui" class="btn-submit">Gửi câu hỏi</button>
            <button type="button" onclick="document.getElementById('dialog-teacher').close()" class="btn-close">Đóng</button>

            </menu>
        </form>
    </div>
</dialog>


  <div class="container1">
    <div class="box1">
      <div class="text1">Hoàn trả 100% tiền nếu khóa học không chất lượng.</div>
      <div class="image1">
        <img src="uytin.jpg" alt="Image 1">
      </div>
    </div>
    <div class="box1">
      <div class="text1">Nhanh chóng, tiện lợi, click là học.</div>
      <div class="image1">
        <img src="tienloi.jpg" alt="Image 2">
      </div>
    </div>
    <div class="box1">
      <div class="text1">Tài liệu được tải lên thường xuyên.</div>
      <div class="image1">
        <img src="up.jpg" alt="Image 3">
      </div>
    </div>
  </div>

      <footer class="footer">
          <div class="footer_trai">
            <img class="logo-2" src="logo_web.png" />
          </div>
          <div class="footer_phai">
            <div class="footer_phai_tren">
              <p class="p">
                Fastlearn là một nền tảng học tập trực tuyến, chuyên cung cấp các khóa học và tài liệu học tập trong nhiều
                lĩnh vực khác nhau, từ công nghệ thông tin, kinh doanh, tiếp thị, đến các kỹ năng mềm và phát triển cá
                nhân. Nền tảng này thường được thiết kế để giúp người học tiếp cận kiến thức một cách nhanh chóng và hiệu
                quả, với các khóa học ngắn gọn, tập trung vào thực hành và ứng dụng thực tế.
              </p>
            </div>
            <div class="footer_phai_duoi">
              <div class="gmail">
                <i class="fa-solid fa-envelope"></i>
                <div class="text-wrapper-6">Fastlearn@gmail.com</div>
            </div>
            <div class="facebook">
                <i class="fa-brands fa-facebook"></i>
                <div class="text-wrapper-7">www.facebook.com/FastLearn</div>
            </div>
            </div>
          </div>
      </footer> 


      <script>
      document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("notificationButton").addEventListener("click", function() {
        showNotifications();
    });
});
      </script>
      <script>
        const confirmDialog1 = document.getElementById('dialog-confirm');
          const confirmButton = document.querySelector('.confirm-btn');
          const dialogForm = document.getElementById('dialog-form-huy');

          // Mở dialog xác nhận khi nhấn nút "Đổi Mật Khẩu"
          if (confirmButton) {
            confirmButton.addEventListener('click', () => {
              confirmDialog1.showModal();
            });
          }

          // Đóng dialog xác nhận khi nhấn nút "Hủy"
          document.querySelector('.btn_huy').addEventListener('click', function () {
            confirmDialog.close();
          });

          // Khi nhấn "Xác nhận", submit form
          document.querySelector('.btn_xacnhan').addEventListener('click', function () {
            dialogForm.querySelector('form').submit();  // Submit form đổi mật khẩu
          });
      </script>
      <script src="HS.js"></script>
      
  </body>
</html>
