<?php
include 'model.php';
include 'imageHandler.php';

$className = !empty($value['class_id']) ? $className : 'Chưa có lớp';

$model = new Model();
$thongbao = "";
$errors = array();

// Xóa người dùng nếu yêu cầu
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];

    try {
        $db = new PDO('mysql:host=localhost;dbname=register', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: admin.php"); // Đảm bảo trang admin.php được cập nhật
            exit;
        } else {
            echo "Lỗi: Không thể xóa bản ghi.";
        }
    } catch (PDOException $e) {
        echo 'Lỗi: ' . $e->getMessage();
    }
}

// Cập nhật thông tin người dùng nếu yêu cầu
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $date = $_POST['datebirth'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $class_id = (int)$_POST['class_id'] ?? 0;
    $newImageName = '';

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
        ];

        if (!empty($newImageName)) {
            $data['image'] = $newImageName;
        }

        $model->update('user', $data, 'id=' . $id);
        $thongbao = "<div class='thongbao'>Cập nhật thành công</div>";
    }
}

// Lấy danh sách người dùng
$result = $model->select('user', '*', 'id>0');

// Lấy danh sách lớp học
$classes = $model->select('class', '*');

// Nếu đang chỉnh sửa người dùng, lấy thông tin của người dùng đó
if (isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $result = $model->select('user', '*', 'id="' . $editId . '"');
    $_POST['form'] = $result[0];
}

// Gán giá trị cho các trường trong form
$username = $_POST['form']['username'] ?? '';
$fullname = $_POST['form']['fullname'] ?? '';
$email = $_POST['form']['email'] ?? '';
$date = $_POST['form']['datebirth'] ?? '';
$phone = $_POST['form']['phone'] ?? '';
$address = $_POST['form']['address'] ?? '';
$image = $_POST['form']['image'] ?? '';
$class_id = $_POST['form']['class_id'] ?? '';

if (!empty($value['class_id'])) {
    $classResult = $model->select('class', 'name', 'id=' . $value['class_id']);
    $className = $classResult ? $classResult[0]['name'] : 'Chưa có lớp';
}

try {
    $db = new PDO('mysql:host=localhost;dbname=register', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT u.*, c.name AS class_name
            FROM user u
            LEFT JOIN class c ON u.class_id = c.id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Fetch data for class 1, class 2, and class 3
try {
    $db = new PDO('mysql:host=localhost;dbname=register', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data for class 1
    $sql1 = "SELECT u.*, c.name AS class_name
             FROM user u
             LEFT JOIN class c ON u.class_id = c.id
             WHERE u.class_id = 1 AND u.username != 'admin'";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    $class1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Fetch data for class 2
    $sql2 = "SELECT u.*, c.name AS class_name
             FROM user u
             LEFT JOIN class c ON u.class_id = c.id
             WHERE u.class_id = 2 AND u.username != 'admin'";
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();
    $class2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Fetch data for class 3
    $sql3 = "SELECT u.*, c.name AS class_name
             FROM user u
             LEFT JOIN class c ON u.class_id = c.id
             WHERE u.class_id = 3 AND u.username != 'admin'";
    $stmt3 = $db->prepare($sql3);
    $stmt3->execute();
    $class3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
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
    <title>Danh sách người dùng</title>
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
                <div class="card-head text-center" style="font-size: 30px">Quản lý người dùng</div>
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
                        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

                        <div class="form-group row">
                            <label for="user_name" class="col-lg-3 col-form-label text-md-right">Tên tài khoản</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" id="username" placeholder="Tên tài khoản">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="full_name" class="col-md-3 col-form-label text-md-right">Tên đầy đủ</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" id="fullname" placeholder="Họ và tên">
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
                                        <option value="<?php echo $class['id']; ?>" <?php echo ($class_id == $class['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($class['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary" name="update">Cập nhật</button>
                            <a href="admin.php" class="btn btn-secondary">Hủy bỏ</a>
                            <a href="add_student.php" class="btn btn-success">Thêm Sinh Viên</a>
                        </div>
                    </form>
                </div>
            </div>
            <br>
        </div>
    </div>

    <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên tài khoản</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Ngày sinh</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $key => $value): ?>
            <?php if ($value['username'] !== 'admin'): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo htmlspecialchars($value['username']); ?></td>
                    <td><?php echo htmlspecialchars($value['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($value['email']); ?></td>
                    <td><?php echo htmlspecialchars($value['datebirth']); ?></td>
                    <td><?php echo htmlspecialchars($value['phone']); ?></td>
                    <td><?php echo htmlspecialchars($value['address']); ?></td>
                    <td><?php echo empty($value['image']) ? 'Chưa có ảnh' : '<img src="image/' . htmlspecialchars($value['image']) . '" width="50" title="">'; ?></td>
                    <td>
                    <a href="admin.php?id=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="admin.php?delete_id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');">Xóa</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

</main>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="font-weight: bold">Các lớp</a>
    </div>
</nav>

<main class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                        <!-- Form fields here (same as before) -->
                        <!-- ... -->
                    </form>
                </div>
            </div>
            <br>

            <!-- Bảng Lớp Học 1 -->
            <div class="card">
                <div class="card-header">
                    Lớp học 1
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên tài khoản</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Ngày sinh</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($class1 as $key => $value): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($value['username']); ?></td>
                                <td><?php echo htmlspecialchars($value['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($value['email']); ?></td>
                                <td><?php echo htmlspecialchars($value['datebirth']); ?></td>
                                <td><?php echo htmlspecialchars($value['phone']); ?></td>
                                <td><?php echo htmlspecialchars($value['address']); ?></td>
                                <td><?php echo empty($value['image']) ? 'Chưa có ảnh' : '<img src="image/' . htmlspecialchars($value['image']) . '" width="50" title="">'; ?></td>
                                <td>
                                    <a href="index.php?id=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="index.php?delete_id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <br>

            <!-- Bảng Lớp Học 2 -->
            <div class="card">
                <div class="card-header">
                    Lớp học 2
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên tài khoản</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Ngày sinh</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($class2 as $key => $value): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($value['username']); ?></td>
                                <td><?php echo htmlspecialchars($value['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($value['email']); ?></td>
                                <td><?php echo htmlspecialchars($value['datebirth']); ?></td>
                                <td><?php echo htmlspecialchars($value['phone']); ?></td>
                                <td><?php echo htmlspecialchars($value['address']); ?></td>
                                <td><?php echo empty($value['image']) ? 'Chưa có ảnh' : '<img src="image/' . htmlspecialchars($value['image']) . '" width="50" title="">'; ?></td>
                                <td>
                                    <a href="index.php?id=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="index.php?delete_id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <br>

            <!-- Bảng Lớp Học 3 -->
            <div class="card">
                <div class="card-header">
                    Lớp học 3
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên tài khoản</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Ngày sinh</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($class3 as $key => $value): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($value['username']); ?></td>
                                <td><?php echo htmlspecialchars($value['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($value['email']); ?></td>
                                <td><?php echo htmlspecialchars($value['datebirth']); ?></td>
                                <td><?php echo htmlspecialchars($value['phone']); ?></td>
                                <td><?php echo htmlspecialchars($value['address']); ?></td>
                                <td><?php echo empty($value['image']) ? 'Chưa có ảnh' : '<img src="image/' . htmlspecialchars($value['image']) . '" width="50" title="">'; ?></td>
                                <td>
                                    <a href="index.php?id=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="index.php?delete_id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

</body>
</html>

