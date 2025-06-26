<?php
session_start(); // Bắt đầu session

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['role'])) {
    header("Location: login.php"); // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btl_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$role = $_SESSION['role'];
$email = $_SESSION['email']; // Lấy email người dùng từ session

// Khởi tạo biến id_tc và id_st
$id_tc = null;
$id_st = null;

// Lấy id_tc nếu người dùng là giáo viên
if ($role == 'teacher') {
    $stmt = $conn->prepare("SELECT id_tc, name FROM teachers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id_tc, $teacherName);
    $stmt->fetch();
    $stmt->close();
}

// Lấy id_st nếu người dùng là học sinh
if ($role == 'student') {
    $stmt = $conn->prepare("SELECT id_st, name FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id_st, $studentName);
    $stmt->fetch();
    $stmt->close();
}

// Truy vấn dựa trên vai trò của người dùng
if ($role == 'admin') {
    // Admin có thể xem tất cả các thảo luận và tên học sinh, giáo viên
    $sql = "SELECT feedback.id_fb, feedback.id_st, feedback.feedback, students.name AS studentName
        FROM feedback
        LEFT JOIN students ON feedback.id_st = students.id_st";
} elseif ($role == 'teacher') {
    // Teacher chỉ thấy các câu hỏi dành cho mình và tên học sinh
    $sql = "SELECT discuss.*, students.name AS studentName , teachers.name AS teacherName FROM discuss
            JOIN students ON discuss.id_st = students.id_st
            LEFT JOIN teachers ON discuss.id_tc = teachers.id_tc 
            WHERE discuss.id_tc = ?";
} elseif ($role == 'student') {
    // Student chỉ thấy các câu hỏi của mình và tên giáo viên
    $sql = "SELECT discuss.*,students.name AS studentName , teachers.name AS teacherName FROM discuss
            JOIN teachers ON discuss.id_tc = teachers.id_tc
            LEFT JOIN students ON discuss.id_st = students.id_st 
            WHERE discuss.id_st = ?";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);

// Nếu là teacher hoặc student, truyền tham số vào truy vấn
if ($role == 'teacher') {
    $stmt->bind_param("i", $id_tc);
} elseif ($role == 'student') {
    $stmt->bind_param("i", $id_st);
}

$stmt->execute();
$result = $stmt->get_result();

// Đóng kết nối
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="TL.css">
    <script src="https://kit.fontawesome.com/c73158e4d5.js" crossorigin="anonymous"></script>
    <title>FastLearn</title>
    <script src="TL.js"></script>
</head>

<body>
    <header class="dau-trang">
        <div class="khung-dau-trang">
            <div class="logo">
                <a href=""><img src="logo_web.png" alt="Logo"></a>
            </div>
        </div>
    </header>
    <main>
        <section class="thao-luan">
            <h2 id="tl">Thảo Luận</h2>
            <div class="khung-thao-luan" id="discussion-container">
                <!-- Hiển thị các thảo luận từ PHP -->
                <?php
                if ($result->num_rows > 0) {
                    // Lặp qua từng hàng dữ liệu và hiển thị lên giao diện
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='discussion-item'>";

                        // Nếu người dùng là admin, hiển thị feedback
                        if ($role == 'admin') {
                            echo "<div class='feedback-section'>";
                            echo "<h3 class='student-name'>Học sinh: " . $row["studentName"] . "</h3>";
                            echo "<p class='feedback'><strong>Feedback:</strong> " . $row["feedback"] . "</p>"; // Hiển thị feedback
                            echo "</div>";
                        } else {
                            // Nếu không phải admin, hiển thị câu hỏi và câu trả lời (giáo viên hoặc học sinh)
                            echo "<div class='question-section'>";
                            echo "<h3 class='student-name'>Học sinh: " . $row["studentName"] . "</h3>";
                            echo "<p class='question'><strong>Câu hỏi:</strong> " . $row["question"] . "</p>";
                            echo "</div>";

                            // Nếu có câu trả lời, hiển thị câu trả lời từ giáo viên
                            if (!empty($row["answer"])) {
                                echo "<div class='answer-section'>";
                                echo "<p class='teacher-name'><strong>Giáo viên: " . $row["teacherName"] . "</strong></p>";
                                echo "<p class='answer'>" . $row["answer"] . "</p>";
                                echo "</div>";
                            } else {
                                // Nếu chưa có câu trả lời, hiển thị ô nhập cho giáo viên
                                if ($role == 'teacher') {
                                    echo "<div class='answer-section'>";
                                    echo "<form method='POST' action='submit_answer.php'>";
                                    echo "<textarea name='answer' placeholder='Nhập câu trả lời...' class='answer-input' required></textarea>";
                                    echo "<input type='hidden' name='question_id' value='" . $row["id_discuss"] . "'>";
                                    echo "<button type='submit' class='submit-btn'>Gửi</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            }
                        }

                        echo "</div>"; // Kết thúc phần câu hỏi hoặc feedback
                    }
                } else {
                    echo "<p>Không có thảo luận nào.</p>";
                }
                ?>
            </div>
            <div class="pagination">
                <button id="prev" disabled>Trước</button>
                <span id="page-info"></span>
                <button id="next">Tiếp</button>
            </div>
        </section>
        <section class="thong-bao">
            <div class="noi-dung-thong-bao">
                <?php if ($role == 'teacher'): ?> <!-- Kiểm tra nếu vai trò là giáo viên -->
                    <button class="nut-dang-thong-bao">Trả lời câu hỏi</button>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <br>
    <footer class="chan-trang">
        <div class="cot-chan-trang">
            <img class="logo-chan-trang" src="logo_web.png" alt="Logo" />
        </div>
        <div class="cot-chan-trang thong-tin-chan-trang">
            <p class="mo-ta">
                FastLearn là một nền tảng học tập trực tuyến...
            </p>
            <div class="lien-he">
                <div class="email">fastlearn@gmail.com</div>
                <div class="facebook-text">www.facebook.com/FastLearn</div>
            </div>
        </div>
    </footer>
</body>

</html>