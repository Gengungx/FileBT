<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý yêu cầu xóa
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    $delete_query = "DELETE FROM `user` WHERE `id` = ?";
    
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id_to_delete);
    
    if ($stmt->execute()) {
        echo "Bản ghi đã được xóa thành công.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
    $stmt->close();
}

// Truy vấn để lấy tất cả người dùng
$sql = "SELECT * FROM `user`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý người dùng</title>
</head>
<body>
    <h1>Danh sách người dùng</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Hành động</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Không có bản ghi nào.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
