<?php
session_start();
// Gọi tới biến toàn cục $conn
global $conn;
// Nếu chưa kết nối thì thực hiện kết nối
if (!$conn) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=btl_web", "root", "");
        // Thiết lập chế độ báo lỗi PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Thiết lập charset
        $conn->exec("set names utf8");
    } catch (PDOException $e) {
        die("Can't connect to database: " . $e->getMessage());
    }
}

function getCourseAndDocumentInfo($courseId)
{
    global $conn;

    // Câu lệnh truy vấn để lấy thông tin khóa học
    $query_course = "SELECT * FROM course WHERE id_cou = :courseId";
    $stmt_course = $conn->prepare($query_course);
    $stmt_course->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    $stmt_course->execute();
    $course = $stmt_course->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("Khóa học không tồn tại.");
    }

    $query_docs = "SELECT * FROM document WHERE id_cou = :courseId";
    $stmt_docs = $conn->prepare($query_docs);
    $stmt_docs->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    $stmt_docs->execute();
    $documents = $stmt_docs->fetchAll(PDO::FETCH_ASSOC);

    return ['course' => $course, 'documents' => $documents];
}

function getTeacher_by_id($id_tc)
{
    global $conn;

    $query_teacher = "SELECT * FROM teachers WHERE id_tc = :id_tc";
    $stmt_teacher = $conn->prepare($query_teacher);
    $stmt_teacher->bindParam(':id_tc', $id_tc, PDO::PARAM_INT);
    $stmt_teacher->execute();
    return $stmt_teacher->fetch(PDO::FETCH_ASSOC);
}

function checkIfStudentRegistered($id_st, $id_cou)
{
    global $conn;

    $query_check = "SELECT * FROM re_course WHERE id_st = :id_st AND id_cou = :id_cou";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bindParam(':id_st', $id_st, PDO::PARAM_INT);
    $stmt_check->bindParam(':id_cou', $id_cou, PDO::PARAM_INT);
    $stmt_check->execute();

    return $stmt_check->rowCount() > 0;
}

function registerCourse($id_st, $id_cou)
{
    global $conn;

    $query_register = "INSERT INTO re_course (id_st, id_cou) VALUES (:id_st, :id_cou)";
    $stmt_register = $conn->prepare($query_register);
    $stmt_register->bindParam(':id_st', $id_st, PDO::PARAM_INT);
    $stmt_register->bindParam(':id_cou', $id_cou, PDO::PARAM_INT);
    $stmt_register->execute();
}

// Kiểm tra xem tham số id có được truyền qua URL hay không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $courseId = intval($_GET['id']); // Lấy mã khóa học từ URL
    // Giả định email được lưu trong session
    $email = $_SESSION['email'];

    // Truy vấn để lấy id_st dựa trên email
    $query_student = "SELECT id_st FROM students WHERE email = :email";
    $stmt_student = $conn->prepare($query_student);
    $stmt_student->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_student->execute();
    $student = $stmt_student->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem học sinh có tồn tại không
    if ($student) {
        $studentId = $student['id_st'];
    } else {
        die("Học sinh không tồn tại.");
    }

    $courseData = getCourseAndDocumentInfo($courseId);

    if (isset($courseData['course']['id_tc'])) {
        $teacherData = getTeacher_by_id($courseData['course']['id_tc']);
    } else {
        die("Không tìm thấy thông tin giảng viên cho khóa học.");
    }

    // Kiểm tra xem học sinh đã đăng ký chưa
    $isRegistered = checkIfStudentRegistered($studentId, $courseId);

    // Xử lý khi người dùng nhấn đăng ký khóa học
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        registerCourse($studentId, $courseId);
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $courseId);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLearn - <?php echo $courseData['course']['cou_name'] ?></title>
    <link rel="stylesheet" href="KhoaHoc.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                                <div class="text-wrapper">Tìm kiếm bài học</div>
                            </div>
                        </div>
                    </div>
                </header>
                <img class="logo" src="logo_web.png" />
            </div>
            <div class="overlap-2">
                <i class="fa-solid fa-home home-icon" onclick="scrollToTop()"></i>
                <div class="text-wrapper-3"><a href="#baigiang">Bài Giảng Online</a></div>
                <div class="text-wrapper-4"><a href="#tailieu">Tài Liệu Giảng Dạy</a></div>
                <div class="text-wrapper-5"><a href="#thaoluan">Thảo Luận</a></div>
            </div>
            <!-- Nội dung khóa học -->
            <div class="Title-Content">
                <h2>Lớp Học / <?php echo $courseData['course']['cou_name'] ?></h2>
                <p>#<?php echo $courseData['course']['id_cou'] ?></p>
                <p>Thời gian học: <?php echo $courseData['course']['cou_time'] ?></p>
                <div class="course-description">
                    <p><?php echo $courseData['course']['cou_des'] ?></p>
                </div>

                <!-- Course Sections -->
                <div class="course-sections">
                    <h2>Lộ trình học</h2>
                    <?php
                    $step = 1;
                    foreach ($courseData['documents'] as $doc): ?>
                        <div class="section">
                            <h4><?php echo "Bước " . $step . ": " . $doc['doc_name']; ?></h4>
                            <p><?php echo $doc['road']; ?></p>
                        </div>
                        <?php $step++; ?>
                    <?php endforeach; ?>
                </div>
                <!-- Nút đăng ký khóa học -->
                <?php if (!$isRegistered): ?>
                    <form method="post">
                        <button type="submit" name="register" class="register-button">Đăng ký khóa học</button>
                    </form>
                <?php else: ?>
                    <!-- Các tài liệu khóa học -->
                    <h2 id="tailieu">Tài Liệu Khóa Học</h2>
                    <ul>
                        <?php if (!empty($courseData['documents'])): ?>
                            <?php foreach ($courseData['documents'] as $doc): ?>
                                <li><a href="<?php echo htmlspecialchars($doc['doc_url']); ?>" target="_blank"><?php echo htmlspecialchars($doc['doc_name']); ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Không có tài liệu nào cho khóa học này.</li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>

                <!-- Thông tin giảng viên -->
                <div class="GV">
                    <div class="GV-Main">
                        <h2>
                            Thông Tin Giảng Viên
                        </h2>
                        <img alt="Profile picture of the instructor" class="profile-pic" src="https://placehold.co/100x100" />
                        <div class="name">
                            <?php echo $teacherData['name'] ?>
                        </div>
                        <div class="position">
                            Giảng Viên : <?php echo $teacherData['major'] ?>
                        </div>
                        <div class="description">
                            <?php echo $teacherData['intro'] ?>
                        </div>
                    </div>
                </div>

                <!-- Ratings Section -->
                <h2>Đánh Giá</h2>
                <div class="rating">
                    <div class="review">
                        <div class="review-content">
                            <div class="review-name">Nguyễn Quốc Khánh:
                                <div class="review-comment">
                                    "Cảm ơn cô Emily vì sự kiên nhẫn và nhiệt huyết! Mỗi giờ học đều mang lại cho tôi động lực và cảm hứng. Tôi thật sự yêu thích học tiếng Anh cùng cô!"
                                </div>
                            </div>
                        </div>
                        <div class="review-content">
                            <div class="review-name">Nguyễn Văn An:
                                <div class="review-comment">
                                    "Cô Emily là một giảng viên xuất sắc! Phong cách giảng dạy linh hoạt và vui vẻ giúp tôi tự tin hơn khi giao tiếp bằng tiếng Anh. Cô luôn khuyến khích và tạo động lực, khiến mỗi buổi học trở nên thú vị !"
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment">
                        <input type="text" name="" id="comment" placeholder="Enter your comment">
                        <input type="submit" id="comment-button" value="Submit">
                    </div>

                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="footer_trai">
                    <img class="logo-2" src="Logofooter1-removebg-preview.png" />
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
        </div>

</body>

</html>