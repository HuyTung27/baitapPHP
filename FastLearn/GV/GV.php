<?php
session_start(); // Bắt đầu session
require '../libs/gv_control.php';
$email = $_SESSION['email'];
$teacher = get_teacher_by_email($email);
$course = get_courses_by_teacher($email);
if (!empty($_POST['GV'])) {
  $buttonValue = $_POST['btn-gv'];
  if ($buttonValue == 'cap-nhat') {
    $data['tc_name']        = isset($_POST['name']) ? $_POST['name'] : '';
    $data['tc_mail']        = isset($_POST['email']) ? $_POST['email'] : '';
    $data['tc_degree']         = isset($_POST['degree']) ? $_POST['degree'] : '';
    $data['tc_major']    = isset($_POST['major']) ? $_POST['major'] : '';
    $data['tc_exp']         = isset($_POST['exp']) ? $_POST['exp'] : '';

    // Validate thong tin
    $errors = array();
    if (empty($data['tc_name'])) {
      $errors['tc_name'] = 'Chưa nhập tên giảng viên';
    }

    // Neu ko co loi thi insert
    if (!$errors) {
      update_teacher_info($data['tc_mail'], $data['tc_name'], $data['tc_degree'], $data['tc_major'], $data['tc_exp']);
      $_SESSION['message'] = 'Cập nhật thông tin thành công!';
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    }
  } else if ($buttonValue == 'doimk') {
    $email = $_POST['email'];
    $oldPass = $_POST['old_pass'];
    $newPass = $_POST['new_pass'];
    $checkPass = $_POST['check_pass'];  // Lấy giá trị mật khẩu xác nhận

    // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp nhau không
    if ($newPass !== $checkPass) {
      echo "<script>alert('Mật khẩu xác nhận không khớp với mật khẩu mới!');</script>";
    } else {
      // Gọi hàm changepass để xử lý đổi mật khẩu
      $result = change_pass($email, $oldPass, $newPass);

      // Kiểm tra kết quả trả về từ hàm change_pass
      if ($result['success']) {
        $_SESSION['message'] = 'Đổi mật khẩu thành công';
      } else {
        $_SESSION['message'] = 'Đổi mật khẩu không thành công';
      }
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    }
  } else if ($buttonValue == 'introduction') {
    $data['introduction'] = isset($_POST['introduction']) ? $_POST['introduction'] : '';
    update_intro($email, $data['introduction']);
    $_SESSION['message'] = 'Cập nhật thông tin giới thiệu thành công';
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }else if($buttonValue =='cap-nhat-url'){
    $id_doc=isset($_POST['id_doc']) ? $_POST['id_doc'] : '';
    $url=isset($_POST['document_link']) ? $_POST['document_link'] : '';
    update_url($id_doc,$url);
    $_SESSION['message'] = 'Đổi tài liệu khóa học thành công !';
    header("Location: " . $_SERVER['PHP_SELF'] . '#tailieu');
    exit();
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
  <link rel="stylesheet" href="GV.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="giao-din-my-tnh-ng">
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

        <a href="#"><img class="logo" src="logo_web.png" /></a>
        <i class="fa fa-bars icon-menubar "></i>
        <div class="container" id="container">
          <div class="icon-container">
            <i class="fas fa-user-circle user-icon"></i>
          </div>
          <div class="button-container">
            <button class="option-button thongtin">Hồ sơ tài khoản</button>
            <button class="option-button doimk">Thay Đổi Mật Khẩu</button>
            <button class="option-button intro">Giới thiệu</button>
          </div>
          <div class="close-button">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <!-- Dialog chứa thông tin giáo viên -->
        <dialog id="dialog_thongtin">
          <h2>Thông Tin Hồ Sơ Người Dùng</h2>
          <form class="form-dang-ky" method="post" action="GV.php">
            <input type="hidden" name="GV" value="1">
            <label for="ho-ten">Họ và Tên:</label>
            <input type="text" id="name" name="name" placeholder="Nhập họ và tên"
              value="<?php echo htmlspecialchars($teacher['name'] ?? ''); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder=""
              value="<?php echo htmlspecialchars($email); ?>" readonly>

            <label for="degree">Trình Độ:</label>
            <select id="degree" name="degree">
              <option value="Thạc sĩ" <?php echo (isset($teacher['degree']) && $teacher['degree'] == 'Thạc sĩ') ? 'selected' : ''; ?>>Thạc sĩ</option>
              <option value="Tiến sĩ" <?php echo (isset($teacher['degree']) && $teacher['degree'] == 'Tiến sĩ') ? 'selected' : ''; ?>>Tiến sĩ</option>
            </select>

            <label for="major">Chuyên môn:</label>
            <input type="text" id="major" name="major" placeholder="Nhập chuyên môn của bạn"
              value="<?php echo htmlspecialchars($teacher['major'] ?? ''); ?>" required>

            <label for="exp">Năm kinh nghiệm:</label>
            <input type="number" id="exp" name="exp" placeholder="Nhập số năm kinh nghiệm của bạn"
              value="<?php echo htmlspecialchars($teacher['exp_years'] ?? ''); ?>" required>

            <menu>
              <button type="submit" name='btn-gv' value="cap-nhat">Cập Nhật</button>
              <button type="button" onclick="document.getElementById('dialog_thongtin').close()">Hủy Bỏ</button>
            </menu>
          </form>
        </dialog>

        <!-- Đổi mật khẩu -->
        <dialog id="dialog-form-huy">
          <form method="post" class="form-dang-ky" action="GV.php">
            <input type="hidden" name="GV" value="1">
            <input type="hidden" name="btn-gv" value="doimk">
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
            <button class="btn_huy" type="button">Hủy</button>
            <button class="btn_xacnhan" type="button">Xác nhận</button>
          </menu>
        </dialog>

        <dialog id="dialog-intro">
          <form method="post" class="form-dang-ky" action="GV.php">
            <input type="hidden" name="GV" value="1">
            <div class="header-dialog">
              <h1>Giới thiệu</h1>
            </div>
            <textarea id="teacher-intro" name="introduction" placeholder="Nhập phần giới thiệu của bạn" required><?php echo htmlspecialchars($teacher['intro'] ?? ''); ?></textarea>
            <button type="submit" name='btn-gv' value="introduction">Đăng</button>
          </form>
        </dialog>

        <div class="overlap-2">
          <i class="fa-solid fa-home home-icon" onclick="scrollToTop()"></i>
          <div class="text-wrapper-3"><a href="#baigiang">Khóa Học</a></div>
          <div class="text-wrapper-4"><a href="#tailieu">Tài Liệu Giảng Dạy</a></div>
          <div class="text-wrapper-5"><a href="../SubPage/TL.php">Thảo Luận</a></div>
        </div>
        <div id="baigiang" class="overlap-4">
          <div class="bi-ging-online">
            <i class="fa-solid fa-book frame-2"></i>
            <div class="text-wrapper-8">Khoá Học</div>
            <div class="slider-wrapper">
              <div class="images">
                <?php foreach ($course as $index => $courseItem): ?>
                  <div class="bai_giang">
                    <img src="image<?php echo ($index + 1); ?>.jpg"
                      alt="" width="100%" height="100%"
                      data-course-name="<?php echo htmlspecialchars($courseItem['cou_name']); ?>"
                      data-course-duration="<?php echo htmlspecialchars($courseItem['cou_time']); ?>"
                      data-student-count="<?php echo htmlspecialchars($courseItem['student_count']); ?>"
                      onclick="openCourseDialog(this)">
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <i class="fa-solid fa-angle-left polygon"></i>
            <i class="fa-solid fa-angle-right polygon-2"></i>
          </div>

        </div>
        <!-- hover -->
        <!-- Dialog hiển thị thông tin khóa học -->
        <dialog id="dialog-khoahoc">
          <div class="course-info">
            <h2>Thông Tin Khóa Học</h2>
            <form class="form-thong-tin-khoa-hoc" method="post" action="GV.php">
              <input type="hidden" id="course_id" name="course_id">
              <label for="course-name">Tên Khóa Học:</label>
              <input type="text" id="course-name" name="course_name" readonly>

              <label for="course-duration">Thời Lượng Học (giờ):</label>
              <input type="number" id="course-duration" name="course_duration" readonly>

              <label for="student-count">Số Lượng Học Viên:</label>
              <input type="number" id="student-count" name="student_count" readonly>

              <menu>
                <button type="button" onclick="document.getElementById('dialog-khoahoc').close()">Đóng</button>
              </menu>
            </form>
          </div>
        </dialog>
        <!--  -->
        <div id="tailieu" class="overlap-6">
          <div class="ti-liu">
            <div class="text-wrapper-10">Tài Liệu Giảng Dạy</div>
            <div class="slider-wrapper-2">
              <div class="images-2">
                <!-- Vòng lặp ngoài: Duyệt qua từng khóa học -->
                <?php foreach ($course as $courseIndex => $courseItem): ?>
                  <?php
                  // Lấy id_cou của khóa học hiện tại
                  $id_cou = $courseItem['id_cou'];

                  // Gọi hàm get_documents_by_course_id để lấy tài liệu của khóa học
                  $documents = get_documents_by_course_id($id_cou);

                  // Tính chỉ số giữa để chia đôi
                  $midIndex = ceil(count($documents) / 2);
                  ?>

                  <!-- Vòng lặp trong: Duyệt qua các tài liệu của khóa học cho images-2 -->
                  <?php for ($i = 0; $i <$midIndex; $i++): ?>
                    <?php if (isset($documents[$i])): ?>
                      <div class="tai_lieu">
                        <img src="image<?php echo ($i + 1); ?>.jpg"
                          alt="Hình ảnh tài liệu của khóa học <?php echo htmlspecialchars($courseItem['cou_name']); ?>"
                          width="100%" height="100%"
                          data-id-doc="<?php echo htmlspecialchars($documents[$i]['id_doc']); ?>"
                          data-course-name1="<?php echo htmlspecialchars($courseItem['cou_name']); ?>"
                          data-learning-path="<?php echo htmlspecialchars($documents[$i]['doc_name']); ?>"
                          data-document-link="<?php echo htmlspecialchars($documents[$i]['doc_url']); ?>"
                          onclick="openMaterialDialog(this)">
                      </div>
                    <?php endif; ?>
                  <?php endfor; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <i class="fa-solid fa-angle-left polygon-3"></i>
            <i class="fa-solid fa-angle-right polygon-4"></i>

            <!-- slider-wrapper-3 -->
            <div class="slider-wrapper-3">
              <div class="images-3">
                <!-- Vòng lặp cho images-3 -->
                <?php foreach ($course as $courseIndex => $courseItem): ?>
                  <?php
                  $id_cou = $courseItem['id_cou'];
                  $documents = get_documents_by_course_id($id_cou);
                  $midIndex = ceil(count($documents) / 2);
                  ?>

                  <!-- Vòng lặp trong: Duyệt qua các tài liệu của khóa học cho images-3 -->
                  <?php for ($i = $midIndex; $i <count($documents); $i++): ?>
                    <?php if (isset($documents[$i])): ?>
                      <div class="tai_lieu1">
                        <img src="image<?php echo ($i + 1); ?>.jpg"
                          alt="Hình ảnh tài liệu của khóa học <?php echo htmlspecialchars($courseItem['cou_name']); ?>"
                          width="100%" height="100%"
                          data-id-doc="<?php echo htmlspecialchars($documents[$i]['id_doc']); ?>"
                          data-course-name1="<?php echo htmlspecialchars($courseItem['cou_name']); ?>"
                          data-learning-path="<?php echo htmlspecialchars($documents[$i]['doc_name']); ?>"
                          data-document-link="<?php echo htmlspecialchars($documents[$i]['doc_url']); ?>"
                          onclick="openMaterialDialog(this)">
                      </div>
                    <?php endif; ?>
                  <?php endfor; ?>
                <?php endforeach; ?>
              </div>
            </div>

            <i class="fa-solid fa-angle-left polygon-5"></i>
            <i class="fa-solid fa-angle-right polygon-6"></i>
          </div>
        </div>



        <i class="fa-solid fa-file-alt frame-6"></i>
      </div>
      <!--  -->
      <!-- Dialog hiển thị thông tin tài liệu -->
      <dialog id="dialog-tailieu">
        <div class="course-material-info">
          <h2>Thông Tin Tài Liệu</h2>
          <form class="form-thong-tin-tailieu" method="post" action="GV.php">
            <input type="hidden" name="GV" value="1">

            <label for="course-name" style="display: none;">Mã tài liệu:</label>
            <input type="text" id="id_doc" name="id_doc" style="display: none;" placeholder="Nhập tên khóa học" readonly>

            <label for="course-name">Tên Khóa Học:</label>
            <input type="text" id="course-name1" name="course_name" placeholder="Nhập tên khóa học" readonly>

            <label for="learning-path">Tên tài liệu:</label>
            <input type="textarea" id="learning-path" name="learning_path" placeholder="Nhập lộ trình học" readonly>

            <label for="document-link">Link Tài Liệu:</label>
            <input type="url" id="document-link" name="document_link" placeholder="Nhập link tài liệu" required>

            <menu>
              <button type="submit" name='btn-gv' value="cap-nhat-url">Cập Nhật</button>
              <button type="button" onclick="document.getElementById('dialog-tailieu').close()">Hủy Bỏ</button>
            </menu>
          </form>
        </div>
      </dialog>

      <!--  -->
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

      <script src="GV.js"></script>

      <script>
        function openCourseDialog(element) {
          // Lấy thông tin từ các thuộc tính dữ liệu của hình ảnh
          const courseName = element.getAttribute('data-course-name');
          const courseDuration = element.getAttribute('data-course-duration');
          const studentCount = element.getAttribute('data-student-count');

          // Cập nhật các trường thông tin trong dialog
          document.getElementById('course_id').value = ''; // Có thể thêm ID nếu cần
          document.getElementById('course-name').value = courseName;
          document.getElementById('course-duration').value = courseDuration;
          document.getElementById('student-count').value = studentCount;

          // Hiển thị dialog
          document.getElementById('dialog-khoahoc').showModal();
        }

        function openMaterialDialog(element) {
          // Lấy dữ liệu từ thuộc tính data của ảnh
          var iddocument = element.getAttribute('data-id-doc');
          var courseName = element.getAttribute('data-course-name1');
          var learningPath = element.getAttribute('data-learning-path');
          var documentLink = element.getAttribute('data-document-link');

          // Gán dữ liệu vào các trường trong form của dialog
          document.getElementById('id_doc').value = iddocument;
          document.getElementById('course-name1').value = courseName;
          document.getElementById('learning-path').value = learningPath;
          document.getElementById('document-link').value = documentLink;

          // Hiển thị dialog
          document.getElementById('dialog-tailieu').showModal();
        }
      </script>
</body>

</html>