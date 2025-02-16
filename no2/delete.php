<?php
include 'model.php';
$model = new Model();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Fetch the user's record to get the image filename
    $user = $model->select('user', '*', 'id="' . $id . '"');
    if ($user) {
        $image = $user[0]['image'];
        
        // Delete the image file if it exists
        if (!empty($image) && file_exists('image/' . $image)) {
            unlink('image/' . $image);
        }
        
        // Delete the user record from the database
        $model->delete('user', 'id="' . $id . '"');
        
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
