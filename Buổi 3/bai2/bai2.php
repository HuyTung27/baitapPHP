<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kết Quả</title>
    <link rel="stylesheet" href="bai2.css">
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email_address']);
        $invoidID = trim($_POST['invoice_id']);
        $payFor = isset($_POST['payment_options']) ? $_POST['payment_options'] : [];

        $errors = [];

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

        if (!empty($errors)) {
            echo "<div class='errors'><h2>Errors</h2><ul>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul></div>";
            echo "<button onclick='window.history.back()'>Quay lại</button>";
        } else {
            echo "<div class='result'><h2>Kết quả Form nhập</h2>";
            echo "<p><strong>First Name:</strong> " . htmlspecialchars($firstName) . "</p>";
            echo "<p><strong>Last Name:</strong> " . htmlspecialchars($lastName) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
            echo "<p><strong>Invoice ID:</strong> " . htmlspecialchars($invoidID) . "</p>";
            echo "<p><strong>Pay For:</strong> " . htmlspecialchars(implode(', ', $payFor)) . "</p>";
            echo "</div>";
        }
    }
    ?>
</body>

</html>
