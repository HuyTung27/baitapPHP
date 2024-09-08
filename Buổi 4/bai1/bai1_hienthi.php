<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kết Quả</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email_address']);
        $invoidID = trim($_POST['invoice_id']);
        $payFor = isset($_POST['payment_options']) ? $_POST['payment_options'] : [];
        $additionalInfo = trim($_POST['ad_inf']);

        $errors = [];

        // Kiểm tra tải lên tệp
        if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
            $fileName = $_FILES['fileUpload']['name'];
            $fileSize = $_FILES['fileUpload']['size'];
            $fileType = $_FILES['fileUpload']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Các loại tệp được phép tải lên
            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

           
            $maxFileSize = 2 * 1024 * 1024; 

            if (in_array($fileExtension, $allowedfileExtensions)) {
                if ($fileSize > $maxFileSize) {
                    $errors[] = "Tệp quá lớn. Dung lượng tối đa là 2MB.";
                } else {
                    // Thư mục để tải tệp lên
                    $uploadFileDir = '../uploads/'; // Đảm bảo đường dẫn này đúng theo cấu trúc thư mục của bạn
                    $dest_path = $uploadFileDir . $fileName;

                    // Kiểm tra xem thư mục có tồn tại không
                    if (!is_dir($uploadFileDir)) {
                        $errors[] = "Thư mục 'uploads' không tồn tại.";
                    } else {
                        // Di chuyển tệp đến thư mục
                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $fileUploadMessage = "Tệp đã được tải lên thành công.";
                        } else {
                            $errors[] = "Có lỗi xảy ra khi di chuyển tệp đã tải lên. Kiểm tra quyền truy cập thư mục.";
                        }
                    }
                }
            } else {
                $errors[] = "Tải lên thất bại. Các loại tệp được phép: " . implode(", ", $allowedfileExtensions);
            }
        } else {
            $errors[] = "Không có tệp nào được tải lên hoặc có lỗi xảy ra khi tải lên.";
        }

        // Xác thực dữ liệu từ các trường form khác
        if (empty($firstName)) {
            $errors[] = "Không được để trống First Name.";
        }

        if (empty($lastName)) {
            $errors[] = "Không được để trống Last Name.";
        }

        if (empty($email)) {
            $errors[] = "Không được để trống Email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không đúng định dạng.";
        }

        if (empty($invoidID)) {
            $errors[] = "Không được để trống Invoice ID.";
        } elseif (!is_numeric($invoidID)) {
            $errors[] = "Invoice ID phải là số.";
        }

        if (empty($payFor)) {
            $errors[] = "Vui lòng chọn ít nhất một tùy chọn cho Pay For.";
        }

        // Hiển thị lỗi nếu có
        if (!empty($errors)) {
            echo "<div class='errors'><h2>Có lỗi xảy ra</h2><ul>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul></div>";
            echo "<button onclick='window.history.back()'>Quay lại</button>";
        } else {
            // Hiển thị kết quả nếu không có lỗi
            echo "<div class='result'><h2>Kết quả Form nhập</h2>";
            echo "<p><strong>First Name:</strong> " . htmlspecialchars($firstName) . "</p>";
            echo "<p><strong>Last Name:</strong> " . htmlspecialchars($lastName) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
            echo "<p><strong>Invoice ID:</strong> " . htmlspecialchars($invoidID) . "</p>";
            echo "<p><strong>Pay For:</strong> " . htmlspecialchars(implode(', ', $payFor)) . "</p>";
            echo "<p><strong>Additional Information:</strong> " . htmlspecialchars($additionalInfo) . "</p>";

            if (isset($fileUploadMessage)) {
                echo "<p>" . htmlspecialchars($fileUploadMessage) . "</p>";
                echo "<p><strong>Tệp đã tải lên:</strong></p>";
                echo "<img src='" . htmlspecialchars($dest_path) . "' alt='Uploaded Image' style='max-width: 300px;'>";
            }
            echo "</div>";
        }
    }
    ?>
</body>

</html>
