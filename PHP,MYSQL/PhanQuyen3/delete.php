<?php
include 'model.php';
$model = new Model();

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int)$_POST['id'];  // Chuyển đổi ID thành số nguyên để bảo mật

    // Fetch the user's record to get the image filename
    $user = $model->select('user', 'image', 'id = ?', [$id]);
    if ($user) {
        $image = $user[0]['image'];
        
        // Delete the image file if it exists
        if (!empty($image) && file_exists('image/' . $image)) {
            if (!unlink('image/' . $image)) {
                echo 'Error: Unable to delete the image file.';
                exit;
            }
        }
        
        // Delete the user record from the database
        $result = $model->delete('user', 'id = ?', [$id]);
        if ($result) {
            header('Location: admin.php');  // Redirect to admin page after deletion
            exit;
        } else {
            echo 'Error: Unable to delete the user record.';
        }
    } else {
        echo 'Error: User not found.';
    }
} else {
    echo 'Error: Invalid ID.';
}
?>
