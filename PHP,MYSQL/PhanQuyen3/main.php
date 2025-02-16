<?php
include 'model.php';
$model = new Model();
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Lấy tên người dùng từ session
$username = $_SESSION['username'];

// Truy vấn thông tin người dùng từ cơ sở dữ liệu
$user = $model->select(
    'user',
    'fullname, image, class_id, email, datebirth, phone, address',
    'username=?',
    [$username]
);

// Kiểm tra nếu người dùng có dữ liệu
if ($user) {
    $user = $user[0];  // Giả sử có một mảng với một phần tử duy nhất
    $fullname = htmlspecialchars($user['fullname']);
    $imagePath = !empty($user['image']) ? 'image/' . htmlspecialchars($user['image']) : 'image/default.jpg';
    $classId = htmlspecialchars($user['class_id']);
    $email = htmlspecialchars($user['email']);
    $datebirth = htmlspecialchars($user['datebirth']);
    $phone = htmlspecialchars($user['phone']);
    $address = htmlspecialchars($user['address']);
    
    // Truy vấn để lấy tên lớp học từ bảng `class` nếu cần
    $class = $model->select('class', 'name', 'id=?', [$classId]);
    $className = $class ? htmlspecialchars($class[0]['name']) : 'Chưa có lớp';
} else {
    // Nếu không có dữ liệu người dùng, sử dụng giá trị mặc định
    $fullname = 'Người dùng không tồn tại';
    $imagePath = 'image/default.jpg';
    $className = 'Chưa có lớp';
    $email = 'Chưa có email';
    $datebirth = 'Chưa có ngày sinh';
    $phone = 'Chưa có số điện thoại';
    $address = 'Chưa có địa chỉ';
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thông Tin Người Dùng</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        body {
    font-family: 'Oswald', sans-serif;
    background-color: #f8f9fa;
}

.navbar {
    margin-bottom: 20px;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.card-header {
    border-radius: 10px 10px 0 0;
}

.card-body {
    padding: 20px;
}

.list-group-item {
    border: none;
    padding: 10px;
    font-size: 16px;
}

.list-group-item:nth-child(odd) {
    background-color: #f1f1f1;
}

.img-fluid.rounded-circle {
    border: 2px solid #007bff;
}

        </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">User</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="logout.php">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Thông Tin Người Dùng</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                <img src="<?php echo $imagePath; ?>" alt="Ảnh người dùng" class="img-fluid mb-3" style="max-width: 150px;">
                </div>
                <div class="col-md-9">
                    <h5><?php echo htmlspecialchars($fullname); ?></h5>
                    <p>Email: <?php echo htmlspecialchars($email); ?></p>
                    <p>Ngày sinh: <?php echo htmlspecialchars($datebirth); ?></p>
                    <p>Số điện thoại: <?php echo htmlspecialchars($phone); ?></p>
                    <p>Địa chỉ: <?php echo htmlspecialchars($address); ?></p>
                    <p>Lớp học: <?php echo htmlspecialchars($className); ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>


