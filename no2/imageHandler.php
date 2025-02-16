<?php

function handleImageUpload(&$errors, &$newImageName) {
    if (!empty($_FILES['form']['name']['image'])) {
        if ($_FILES["form"]["error"]["image"] === 4) {
            $errors['image'] = 'Ảnh không tồn tại';
        } else {
            $fileName = $_FILES["form"]["name"]["image"];
            $fileSize = $_FILES["form"]["size"]["image"];
            $tmpName = $_FILES["form"]["tmp_name"]["image"];

            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            if (!in_array($imageExtension, $validImageExtensions)) {
                $errors['image'] = 'Điều kiện ảnh không hợp lệ';
            } elseif ($fileSize > 5000000) {
                $errors['image'] = 'Dung lượng ảnh quá lớn';
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'image/' . $newImageName);
            }
        }
    }
}

function updateImage(&$errors, $model, $newImageName, $existingUserId) {
    // Check if there's a new image to upload
    if (!empty($newImageName) && !empty($existingUserId)) {
        // Update the user's image path in the database
        $data = array(
            "image" => $newImageName
        );
        $model->update('user', $data, 'id="' . (int)$existingUserId . '"');
    }
}

function removeImage($model, $existingUserId) {
    if (!empty($existingUserId)) {
        // Fetch the existing user data from the database
        $existingUser = $model->select('user', '*', 'id="' . (int)$existingUserId . '"');

        if (!empty($existingUser) && isset($existingUser[0]['image']) && !empty($existingUser[0]['image'])) {
            $imagePath = 'image/' . basename($existingUser[0]['image']);
            
            // Check if the file exists and is indeed a file
            if (file_exists($imagePath) && is_file($imagePath)) {
                // Attempt to delete the image file
                if (!unlink($imagePath)) {
                    error_log('Failed to delete image: ' . $imagePath);
                }
            }
        }
    }
}
?>