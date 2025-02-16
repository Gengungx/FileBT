<?php
include 'model.php';
include 'imageHandler.php';

$model = new Model();
$thongbao = "";
$errors = array();

// Khởi tạo các biến để tránh cảnh báo
$username = $fullname = $email = $date = $phone = $address = '';
$class_id = 0;
$password = '';  // Thêm biến mật khẩu

// Xử lý form thêm sinh viên
if (isset($_POST['add'])) {
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $date = $_POST['datebirth'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $class_id = (int)$_POST['class_id'] ?? 0;
    $password = $_POST['password'] ?? '';  // Nhận mật khẩu từ form
    $newImageName = '';

    // Kiểm tra các trường không được để trống
    if (empty($username)) {
        $errors[] = "Tên tài khoản không được để trống.";
    }
    if (empty($fullname)) {
        $errors[] = "Tên đầy đủ không được để trống.";
    }
    if (empty($email)) {
        $errors[] = "Email không được để trống.";
    }
    if (empty($date)) {
        $errors[] = "Ngày sinh không được để trống.";
    }
    if (empty($phone)) {
        $errors[] = "Số điện thoại không được để trống.";
    }
    if (empty($address)) {
        $errors[] = "Địa chỉ không được để trống.";
    }
    if (empty($password)) {  // Kiểm tra mật khẩu không để trống
        $errors[] = "Mật khẩu không được để trống.";
    }
    if ($class_id <= 0) {
        $errors[] = "Lớp không được để trống.";
    }

    // Xử lý hình ảnh
    handleImageUpload($errors, $newImageName);

    if (empty($errors)) {
        $data = [
            "username" => $username,
            "fullname" => addslashes($fullname),
            "email" => $email,
            "datebirth" => $date,
            "phone" => $phone,
            "address" => $address,
            "class_id" => $class_id,
            "password" => md5($password)  // Mã hóa mật khẩu bằng md5
        ];

        if (!empty($newImageName)) {
            $data['image'] = $newImageName;
        }

        $model->insert('user', $data);
        $thongbao = "<div class='thongbao'>Thêm sinh viên thành công</div>";

        // Đặt lại các trường trong form sau khi thêm thành công
        $username = $fullname = $email = $date = $phone = $address = '';
        $class_id = 0;
        $password = '';
    }
}

// Lấy danh sách lớp học
$classes = $model->select('class', '*');
?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="icon" href="Favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <title>Thêm Sinh Viên</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="font-weight: bold">Quản trị</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-primary text-white" href="logout.php">Đăng xuất</a>
            </li>
        </ul>
    </div>
</nav>

<main class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-head text-center" style="font-size: 30px">Thêm Sinh Viên</div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php echo $thongbao;?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="user_name" class="col-lg-3 col-form-label text-md-right">Tên tài khoản</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Tên tài khoản" value="<?php echo htmlspecialchars($username); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="full_name" class="col-md-3 col-form-label text-md-right">Tên đầy đủ</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Họ và tên" value="<?php echo htmlspecialchars($fullname); ?>">
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="email" class="col-lg-3 col-form-label text-md-right">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" id="email" placeholder="name@gmail.com" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="datebirth" class="col-md-3 col-form-label text-md-right">Ngày sinh</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="datebirth" id="datebirth" value="<?php echo htmlspecialchars($date); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-3 col-form-label text-md-right">Số điện thoại</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Số điện thoại" value="<?php echo htmlspecialchars($phone); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-3 col-form-label text-md-right">Địa chỉ</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="address" id="address" placeholder="Địa chỉ" value="<?php echo htmlspecialchars($address); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
        <label for="password" class="col-md-3 col-form-label text-md-right">Mật khẩu</label>
        <div class="col-md-9">
            <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu">
        </div>
    </div>

                        <form method="post" enctype="multipart/form-data">
    <!-- Các trường khác -->
    <div class="form-group row">
        <label for="image" class="col-md-3 col-form-label text-md-right">Hình ảnh</label>
        <div class="col-md-9">
            <input type="file" class="form-control" name="image" id="image">
        </div>
    </div>

                        <div class="form-group row">
                            <label for="class_id" class="col-md-3 col-form-label text-md-right">Lớp</label>
                            <div class="col-md-9">
                                <select class="form-control" name="class_id" id="class_id">
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class['id']; ?>" <?php if ($class_id == $class['id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($class['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary" name="add">Thêm</button>
                            <a href="admin.php" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
            <br>
        </div>
    </div>
</main>

</body>
</html>
