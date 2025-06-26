<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FastLearn</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="DN_DK.css">
        <script src="DN_DK.js" defer></script>
        <script>
            // Hàm kiểm tra thông tin form đăng ký
            function validateRegisterForm() {
                const uname = document.getElementById('uname').value.trim();
                const email = document.getElementById('mail').value.trim();
                const password = document.getElementById('pass').value.trim();

                if (uname === "" || email === "" || password === "") {
                    alert("Vui lòng điền đầy đủ thông tin đăng ký.");
                    return false; // Ngăn form gửi đi
                }

                // Có thể thêm kiểm tra định dạng email và độ mạnh mật khẩu nếu cần
                return true; // Cho phép gửi form
            }

            // Hàm kiểm tra thông tin form đăng nhập1234
            function validateLoginForm() {
                const email = document.getElementById('lmail').value.trim();
                const password = document.getElementById('lpass').value.trim();

                if (email === "" || password === "") {
                    alert("Vui lòng điền đầy đủ thông tin đăng nhập.");
                    return false; // Ngăn form gửi đi
                }

                return true; // Cho phép gửi form
            }
        </script>
    </head>
    <body>
        <h2>Đăng Ký - Đăng Nhập</h2>
            <div class="container" id="container">
                <div class="form-container sign-up-container">
                    <form action="register.php" method="POST" onsubmit="return validateRegisterForm()">
                        <h1>Tạo Tài Khoản</h1>
                        <div class="social-container">
                            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <span>hoặc sử dụng email</span>
                        <input type="text" id="uname" name="uname" placeholder="Tên người dùng" />
                        <input type="email" id="mail" name="mail" placeholder="Email" />
                        <input type="password" id="pass" name="pass" placeholder="Mật khẩu" />
                        <button>Đăng Ký</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form action="login.php" method="POST" onsubmit="return validateLoginForm()" >
                        <h1>Đăng Nhập</h1>
                        <div class="social-container">
                            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <span>hoặc sử dụng tài khoản của bạn</span>
                        <input type="email" id="lmail" name="lmail" placeholder="Email" />
                        <input type="password" id="lpass" name="lpass" placeholder="Mật khẩu" />
                        <a href="#">Quên mật khẩu?</a>
                        <button>Đăng Nhập</button>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Chào Mừng Trở Lại!</h1>
                            <p>Để duy trì kết nối, vui lòng đăng nhập bằng tài khoản của bạn.</p>
                            <button class="ghost" id="signIn">Đăng Nhập</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Xin Chào!</h1>
                            <p>Vui lòng điền thông tin của bạn và cùng bắt đầu hành trình với chúng tôi.</p>
                            <button class="ghost" id="signUp">Đăng Ký</button>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>