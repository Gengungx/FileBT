<?php
if (!empty($_FILES['form']['name']['image'])) {
        if ($_FILES["form"]["error"]["image"] === 4) {
            $errors['image'] = 'Ảnh không tồn tại';
        } else {
            $fileName = $_FILES["form"]["name"]["image"];
            $fileSize = $_FILES["form"]["size"]["image"];
            $tmpName = $_FILES["form"]["tmp_name"]["image"];

            $validImageExtention = ['jpg', 'jpeg', 'png'];
            $imageExtention = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($imageExtention, $validImageExtention)) {
                $errors['image'] = 'Điều kiện ảnh không hợp lệ';
            } elseif ($fileSize > 5000000) {
                $errors['image'] = 'Dung lượng ảnh quá lớn';
            } else {
                $newImageName = uniqid() . '.' . $imageExtention;
                move_uploaded_file($tmpName, 'image/' . $newImageName);
            }
        }
    }
    if (empty($errors))
        if (!empty($kt)) {
            $existingUser = $model->select('user', '*', 'id="' . $_GET['id'] . '"')[0];
            if (!$newImageName) {
                $newImageName = $existingUser['image'];
            } else {
                if (file_exists('image/' . $existingUser['image'])) {
                    unlink('image/' . $existingUser['image']);
                }
            }
        }
        ?>

<?php
// If no errors, proceed with the database operations
    if (empty($errors)) {
        if (isset($username) && empty($kt)) {
            $item = $model->select('user', 'count(*)', 'username="' . $username . '" ');
            if (!empty($item) && is_array($item) && $item[0]['count(*)'] > 0) {
                $errors['username'] = 'Username đã tồn tại';
                return 0;
            }
        }
            $data = array(
                "username" => $username,
                "fullname" => addslashes($fullname),
                "email" => $email,
                "datebirth" => $date,
                "phone" => $phone,
                "address" => $address,
                "image" => $newImageName,
                "password" => md5(($password))
            );
            if (empty($kt)) {
                //check valid uploadimage
                //update
                $model->insert('user', $data);
            } else {
                $model->update('user', $data, 'id="' . $_GET['id'] . '"');
            }
            $thongbao = "<div class='thongbao'>Lưu thành công</div>";
        }
if (isset($_GET['id'])) {
    $result = $model->select('user', '*', 'id="' . $_GET['id'] . '" ');
    $_POST['form'] = $result[0];
} else {
    $result = $model->select('user', '*', 'id>0');
}

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