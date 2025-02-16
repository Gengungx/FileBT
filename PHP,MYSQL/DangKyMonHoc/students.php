<!DOCTYPE html>
<html>
<head>
    <title>Danh Sách Sinh Viên</title>
</head>
<body>

<h2>Danh Sách Sinh Viên</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tên Sinh Viên</th>
    </tr>
    <?php
    include 'db_connect.php';
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["student_id"] . "</td><td>" . $row["student_name"] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='2'>Không có sinh viên nào</td></tr>";
    }
    ?>
</table>

</body>
</html>
