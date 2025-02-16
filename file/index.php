<?php
session_start(); // Bắt đầu session để lấy thông tin từ login.php

// Kiểm tra nếu có thông báo lỗi trong session
if (isset($_SESSION['error_message'])) {
    $message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị để tránh hiện lại
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        html, body {
            height: 100%; /* Đặt chiều cao cho body và html */
            margin: 0; /* Bỏ margin */
        }

        .container-custom {
            min-height: calc(100vh - 60px); /* Chiều cao tối thiểu cho vùng nội dung */
            display: flex;
            flex-direction: column; /* Căn giữa theo chiều dọc */
            justify-content: center; /* Căn giữa nội dung */
        }

        .login-container {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        
        .input-group-append .btn {
            cursor: pointer;
        }

        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Hệ thống đăng ký học lại</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-custom">
        <div class="row">
            <div class="col-md-6 offset-md-3 login-container">
                <h2 class="text-center">Đăng nhập</h2>
                
                <!-- Hiển thị thông báo lỗi nếu có -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger alert-custom" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập:</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <div class="input-group-append">
                                <span class="btn btn-outline-secondary" id="togglePassword">Hiện</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Script để ẩn/hiện mật khẩu -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the text of the button
            this.textContent = this.textContent === 'Hiện' ? 'Ẩn' : 'Hiện';
        });
    </script>

    <!-- Footer -->
   <!-- Footer -->
<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container text-center">
        <span>&copy; 2024 Hệ thống đăng ký học lại. All Rights Reserved.</span>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="privacy.php" class="text-white">Chính sách bảo mật</a></li>
            <li class="list-inline-item"><a href="terms.php" class="text-white">Điều khoản sử dụng</a></li>
            <li class="list-inline-item"><a href="contact.php" class="text-white">Liên hệ</a></li>
        </ul>
    </div>
</footer>
</body>
</html>
