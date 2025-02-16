<?php
include 'model.php';
$model = new Model();
// Bắt đầu session
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
// Lấy tên người dùng từ session (do người dùng đã đăng nhập)
$username = $_SESSION['username'][0];

$user = $model->select('user', 'image', 'username=?', [$username]);

$imagePath = 'image/default.jpg'; // Default image path in case no image is found

// Check if the user exists and has an image path
if ($user && isset($user[0]['image'])) {
    $imagePath = 'image/' . $user[0]['image'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang chính</title>
    <!-- Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">G</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><a href="logout.php" class="btn btn-primary">Đăng xuất</a></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Xin chào, <?php echo $username['fullname']; ?>!</h5>
            
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
