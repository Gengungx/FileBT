<?php
// Bắt đầu session
session_start();

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng người dùng đến trang chính
if (isset($_SESSION['username'])) {
    header("Location: main.php");
    exit;
}

include 'model.php';
$model = new Model();

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    $errors = array();
    if (empty($username) || empty($password)) {
        $errors[] = 'Tên đăng nhập và mật khẩu không được để trống.';
    } else {
        // Kiểm tra tên đăng nhập và mật khẩu
        $user = $model->select('user', '*', 'username="' . $username . '" AND password="' . md5($password) . '"');
        if (!empty($user)) {
            // Đăng nhập thành công, lưu tên đăng nhập trong session và chuyển hướng đến trang chính
            $_SESSION['username'] = $user;
            header("Location: main.php");
            exit;
        } else {
            $errors[] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        }
    }
}

?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="icon" href="Favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>PHP/MYSQL</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="font-weight: bold">G</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="font-weight: bold">Đăng ký</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-head mb-3">Đăng Nhập</div>
            <?php
            if (isset($errors) && !empty($errors)) {
                foreach ($errors as $error) {
                    echo '<p>' . $error . '</p>';
                }
            }
            ?>
            <form method="post">
                <div class="form-group row">
                    <label for="username" class="col-md-5 col-form-label text-md-3">Tên tài khoản</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" name="username" id="username" placeholder="">
                </div>
        </div>
                <div class="form-group row">
                    <label for="password" class="col-md-5 col-form-label text-md-3">Mât khẩu</label>
                    <div class="col-md-6">
                    <input type="password" class="form-control" name="password" id="password" placeholder="">
                </div>
        </div>
                <div class="col text-center">
                <button type="submit" name="login" class="btn btn-primary">Đăng nhập</button>
                </div>
            </form>
                    </div>
                </div>
            
</main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>