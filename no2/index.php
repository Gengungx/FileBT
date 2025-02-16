<?php
include 'model.php';
include 'imageHandler.php';
$model = new Model();
$thongbao ="";
$newImageName = '';

if (isset($_POST['register'])) {
    $kt = $_POST['kiem_tra'];
    $username = $_POST['form']['username'] ?? '';
    $fullname = $_POST['form']['fullname'] ?? '';
    $email = $_POST['form']['email'] ?? '';
    $date = $_POST['form']['datebirth'] ?? '';
    $phone = $_POST['form']['phone'] ?? '';
    $address = $_POST['form']['address'] ?? '';
    $password = $_POST['form']['password'] ?? '';
    $confirmPassword = $_POST['form']['confirm_password'] ?? '';
    $errors = array(); // Array to store error messages

    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username không được bỏ trống';
    } elseif (strlen($username) < 5) {
        $errors['username'] = 'Username phải chứa ít nhất 5 kí tự';
    }

    if (empty($fullname)) {
        $errors['fullname'] = 'Họ và tên không được bỏ trống';
    } elseif (strlen($fullname) < 3) {
        $errors['fullname'] = 'Họ và tên phải chứa ít nhất 3 kí tự';
    }

    if (empty($email)) {
        $errors['email'] = 'Email không được bỏ trống';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    } elseif (strpos($email, '@gmail.com') === false) {
        $errors['email'] = 'Email phải là địa chỉ @gmail';
    }

    if (empty($date)) {
        $errors['datebirth'] = 'Ngày sinh không được bỏ trống';
    }

    if (empty($phone)) {
        $errors['phone'] = 'Số điện thoại không được bỏ trống';
    } elseif (!preg_match('/^0[0-9]{9}$/', $phone)) {
        $errors['phone'] = 'Số điện thoại phải là 10 số và bắt đầu bằng số 0';
    }

    if (empty($address)) {
        $errors['address'] = 'Địa chỉ không được bỏ trống';
    }

    if (empty($password)) {
        $errors['password'] = 'Mật khẩu không được bỏ trống';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Mật khẩu phải chứa ít nhất 6 ký tự';
    } elseif ($password !== $confirmPassword) {
        $errors['password'] = 'Mật khẩu và xác nhận mật khẩu không khớp';
    }

    if (empty($errors)) {
        if (isset($username) && empty($kt)) {
            $item = $model->select('user', 'count(*)', 'username="' . $username . '" ');
            if (!empty($item) && is_array($item) && $item[0]['count(*)'] > 0) {
                $errors['username'] = 'Username đã tồn tại';
                $saveOrUpdateAllowed = false; 
            } else {
                $saveOrUpdateAllowed = true; 
            }
        } else {
            $saveOrUpdateAllowed = true; 
        }
    
        if ($saveOrUpdateAllowed) {
    $data = array(
        "username" => $username,
        "fullname" => addslashes($fullname),
        "email" => $email,
        "datebirth" => $date,
        "phone" => $phone,
        "address" => $address,
        "password" => md5($password)
    );

     handleImageUpload($errors, $newImageName);

     if (!empty($newImageName)) {
         $data['image'] = $newImageName;
     }

     if (empty($kt)) { // Insert
         $model->insert('user', $data);
     } else { // Update
         if (isset($_GET['id'])) {
             $existingUserId = (int)$_GET['id'];
             if (!empty($newImageName)) {
                 removeImage($model, $existingUserId);
                 updateImage($errors, $model, $newImageName, $existingUserId);
             } else {
                 $model->update('user', $data, 'id="' . $existingUserId . '"');
             }
         }
     }

    $thongbao = "<div class='thongbao'>Lưu thành công</div>";
}
}
}

// Fetch user data if editing
if (isset($_GET['id'])) {
$result = $model->select('user', '*', 'id="' . $_GET['id'] . '" ');
$_POST['form'] = $result[0];
} else {
$result = $model->select('user', '*', 'id>0');
}

// Assign form field values for display
$username = $_POST['form']['username'] ?? '';
$fullname = $_POST['form']['fullname'] ?? '';
$email = $_POST['form']['email'] ?? '';
$date = $_POST['form']['datebirth'] ?? '';
$phone = $_POST['form']['phone'] ?? '';
$address = $_POST['form']['address'] ?? '';
$image = $_POST['form']['image'] ?? '';
$password = $_POST['form']['password'] ?? '';
$confirmPassword = $_POST['form']['confirm_password'] ?? '';

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['form']['image'])) {
        $file = $_FILES['form']['image'];
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = $file['name'];
            $tmpName = $file['tmp_name'];
            
            // Move uploaded file to desired directory
            $uploadDir = 'image/';
            $destination = $uploadDir . $fileName;
            
            if (move_uploaded_file($tmpName, $destination)) {
                echo 'File uploaded successfully.';
                // Here you can continue with further processing
            } else {
                echo 'Failed to move uploaded file.';
            }
        } else {
            echo 'File upload error: ' . $file['error'];
        }
    } else {
        echo 'No image uploaded.';
    }
}
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
                    <a class="nav-link" href="login.php" style="font-weight: bold">Đăng nhập</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-head text-center" style="font-size: 30px">Đăng ký</div>
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
                    <a><?php echo $thongbao;?></a>
                    <form method="post" enctype="multipart/form-data">

                        <div class="form-group row">
                            <label for="user_name" class="col-lg-3 col-form-label text-md-right">User Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="form[username]" value="<?php echo $username; ?>" id="exampleFormControlInput1" placeholder="Tên tài khoản">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="full_name" class="col-md-3 col-form-label text-md-right">Tên đầy đủ</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="form[fullname]" value="<?php echo  $fullname; ?>" id="exampleFormControlInput1" placeholder="Họ và tên">
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="email" class="col-lg-3 col-form-label text-md-right">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="form[email]" id="email" placeholder="name@gmail.com" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="datebirth" class="col-md-3 col-form-label text-md-right">Ngày sinh</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="form[datebirth]" id="datebirth" value="<?php echo htmlspecialchars($date); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-lg-3 col-form-label text-md-right">Số điện thoại</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="form[phone]" id="phone" placeholder="0123xxxx" value="<?php echo htmlspecialchars($phone); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-3 col-form-label text-md-right">Địa chỉ</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="form[address]" id="address" placeholder="Địa chỉ" value="<?php echo htmlspecialchars($address); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" name="form[password]" id="password" placeholder="********">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm_password">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" name="form[confirm_password]" id="confirm_password" placeholder="********" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Hình ảnh</label>
                            <input type="file" class="form-control-file" name="form[image]" id="image">
                                
                        </div>

                        <input type="hidden" name="kiem_tra" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

                        <div class="col text-center">
                            <button type="submit" name="register" class="btn btn-primary">Đăng ký</button>
                        </div>

                    </form>
            </div>
            </div>
            </div>
            </div>
            <div class="table-responsive mt-2">
            <table class="table table-striped mt-5">
            <thead class="thead-dark">
            <tr>
            <th scope="col">ID</th>
            <th scope="col"></th>
            <th scope="col">Tên tài khoản</th>
            <th scope="col">Họ và tên</th>
            <th scope="col">Ngày sinh</th>
            <th scope="col">Email</th>
            <th scope="col">Số điện thoại</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Chỉnh sửa</th>
            <th scope="col">Xóa</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (is_array($result) || is_object($result)) {
            foreach ($result as $key => $value) {
            ?>
            <tr id="row-<?php echo $value['id']; ?>">
            <th scope="row"><?php echo $key + 1; ?></th>
            <td><?php echo empty($value['image']) ? 'Chưa có ảnh' : '<img src="image/' . $value['image'] . '" width="50" title="">'; ?></td>
            <td><?php echo $value['username']; ?></td>
            <td><?php echo $value['fullname']; ?></td>
            <td><?php echo $value['datebirth']; ?></td>
            <td><?php echo $value['email']; ?></td>
            <td><?php echo $value['phone']; ?></td>
            <td><?php echo $value['address']; ?></td>
            <td>
                <a href="index.php?id=<?php echo $value['id']; ?>" class="btn btn-sm btn-primary">Chỉnh sửa</a>
            </td>
            <td>
                <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $value['id']; ?>">Xóa</button>
            </td>
            </tr>
            <?php
            }
            } else {
            echo "<tr><td colspan='10' class='text-center'>Không có dữ liệu hoặc có lỗi trong truy vấn.</td></tr>";
            }
            ?>
            </tbody>
            </table>
            </div>
            </main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>
