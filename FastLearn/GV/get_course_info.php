<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Khóa Học</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .images {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .bai_giang {
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: calc(33.333% - 20px);
            cursor: pointer;
            transition: transform 0.3s;
        }

        .bai_giang img {
            width: 100%;
            height: auto;
        }

        .bai_giang:hover {
            transform: scale(1.05);
        }

        #course-name-display {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        @media (max-width: 768px) {
            .bai_giang {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .bai_giang {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<h1>Danh Sách Khóa Học</h1>

<div class="images">
    <?php 
    // Ví dụ dữ liệu khóa học
    $courses = [
        ['cou_name' => 'Khóa Học PHP Cơ Bản'],
        ['cou_name' => 'Khóa Học JavaScript Nâng Cao'],
        ['cou_name' => 'Khóa Học Lập Trình Web'],
        ['cou_name' => 'Khóa Học Python Cho Người Mới Bắt Đầu'],
        ['cou_name' => 'Khóa Học ReactJS'],
        ['cou_name' => 'Khóa Học Machine Learning']
    ];
    
    foreach ($courses as $index => $courseItem): ?>
        <div class="bai_giang" onclick="openCourseDialog(this)">
            <img src="image<?php echo ($index + 1); ?>.jpg" alt="" width="100%" height="100%"
                 data-course-name="<?php echo htmlspecialchars($courseItem['cou_name']); ?>">
        </div>
    <?php endforeach; ?>
</div>

<div id="course-name-display"></div>

<script>
function openCourseDialog(imgElement) {
    const courseName = imgElement.getAttribute('data-course-name');
    document.getElementById('course-name-display').innerText = courseName;
}
</script>

</body>
</html>
