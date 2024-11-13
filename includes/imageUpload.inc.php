<?php
function handleImageUpload_without_url($file, $uploadDir = '../uploads/model_image/', $defaultImg = 'default.png', $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'], $maxFileSize = 2 * 1024 * 1024) {
    // Set a default image in case of failure or no upload
    $defaultImage = $uploadDir . $defaultImg;
    
    // Check if a file is provided and if there was no error during upload
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = basename($file['name']);
        $fileSize = $file['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Validate file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Unsupported file extension.";
            return $defaultImage;
        }
        
        // Validate file size
        if ($fileSize > $maxFileSize) {
            echo "File size exceeds the limit of " . ($maxFileSize / 1024 / 1024) . " MB.";
            return $defaultImage;
        }
        
        // Generate a secure, unique file name and sanitize the path
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $fullPath = rtrim($uploadDir, '/') . '/' . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $fullPath)) {
            return $fullPath; // Return the full path for DB storage
        } else {
            echo "Error moving the uploaded file.";
            return $defaultImage;
        }
    } else {
        // No file uploaded or error in file upload
        return $defaultImage;
    }
}

function handleImageUpload_DownloadImageFromUrl($file, $uploadDir = '../uploads/model_image/', $defaultImg = 'default.png', $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'], $maxFileSize = 2 * 1024 * 1024) {
    // Set a default image path
    $defaultImage = rtrim($uploadDir, '/') . '/' . $defaultImg;

    // Check if the input is a URL
    if (is_string($file) && filter_var($file, FILTER_VALIDATE_URL)) {
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
        
        // Validate file extension
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo "Unsupported file extension from URL.";
            return $defaultImage;
        }
        
        // Generate a unique filename
        $newFileName = md5(time() . basename($file)) . '.' . $fileExtension;
        $fullPath = rtrim($uploadDir, '/') . '/' . $newFileName;

        // Download and save the image from URL
        $imageContent = file_get_contents($file);
        if ($imageContent !== false) {
            file_put_contents($fullPath, $imageContent);
            return $fullPath; // Return the full path for DB storage
        } else {
            echo "Failed to download image from URL.";
            return $defaultImage;
        }
    }

    // Process as a file upload
    elseif (isset($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = basename($file['name']);
        $fileSize = $file['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Unsupported file extension.";
            return $defaultImage;
        }

        // Validate file size
        if ($fileSize > $maxFileSize) {
            echo "File size exceeds the limit of " . ($maxFileSize / 1024 / 1024) . " MB.";
            return $defaultImage;
        }

        // Generate a unique filename and sanitize the path
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $fullPath = rtrim($uploadDir, '/') . '/' . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $fullPath)) {
            return $fullPath; // Return the full path for DB storage
        } else {
            echo "Error moving the uploaded file.";
            return $defaultImage;
        }
    }

    // Return default image path if neither file nor URL is valid
    return $defaultImage;
}

function handleImageUpload($file, $uploadDir = '../uploads/model_image/', $defaultImg = 'default.png', $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'], $maxFileSize = 2 * 1024 * 1024) {
    // Set a default image path
    $defaultImage = rtrim($uploadDir, '/') . '/' . $defaultImg;

    // Check if the input is a URL
    if (is_string($file) && filter_var($file, FILTER_VALIDATE_URL)) {
        // If it's a URL, directly return it as the image path (store the full URL)
        return $file;  // Return the full URL for DB storage
    }

    // Process as a file upload
    elseif (isset($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = basename($file['name']);
        $fileSize = $file['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Unsupported file extension.";
            return $defaultImage;
        }

        // Validate file size
        if ($fileSize > $maxFileSize) {
            echo "File size exceeds the limit of " . ($maxFileSize / 1024 / 1024) . " MB.";
            return $defaultImage;
        }

        // Generate a unique filename and sanitize the path
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $fullPath = rtrim($uploadDir, '/') . '/' . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $fullPath)) {
            return $fullPath; // Return the full path for DB storage
        } else {
            echo "Error moving the uploaded file.";
            return $defaultImage;
        }
    }

    // Return default image path if neither file nor URL is valid
    return $defaultImage;
}
