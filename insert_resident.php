<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname     = mysqli_real_escape_string($link, $_POST['lastname']);
    $age          = (int) $_POST['age'];
    $gender       = mysqli_real_escape_string($link, $_POST['gender']);
    $firstname    = mysqli_real_escape_string($link, $_POST['firstname']);
    $civil_status = mysqli_real_escape_string($link, $_POST['civilstatus']);
    $middlename   = mysqli_real_escape_string($link, $_POST['middlename']);
    $voter_status = mysqli_real_escape_string($link, $_POST['voterstatus']);
    $address      = mysqli_real_escape_string($link, $_POST['address']);
    $birthplace   = mysqli_real_escape_string($link, $_POST['birthplace']);
    $birthday     = $_POST['birthday'];
    $imagePath    = '';  // initialize the image path variable

    if (isset($_FILES['imageInput']) && $_FILES['imageInput']['error'] === 0) {
        $imgName  = $_FILES['imageInput']['name'];
        $imgTmp   = $_FILES['imageInput']['tmp_name'];
        $filetype = mime_content_type($imgTmp);
        $filesize = $_FILES['imageInput']['size'];
        
        if ($filetype !== 'image/jpeg') {
            echo "Only JPEG files allowed.";
            exit;
        }
        
        if ($filesize > 2 * 1024 * 1024) {
            echo "File size exceeds 2MB.";
            exit;
        }
        
        // Generate a unique file name
        $newImgName = uniqid() . "-" . basename($imgName);
        $targetDir  = "uploads/";
        $targetFile = $targetDir . $newImgName;
        
        // Ensure the uploads directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($imgTmp, $targetFile)) {
            $imagePath = $targetFile;  // Save the full relative path to the file
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        echo "No image uploaded";
        exit;
    }

    $sql = "INSERT INTO tblresidents 
    (last_name, age, gender, first_name, civil_status, middle_name, voter_status, address, birthplace, birthday, image_path)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "sisssssssss", $lastname, $age, $gender, $firstname, $civil_status, $middlename, $voter_status, $address, $birthplace, $birthday, $imagePath);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "Insert failed: " . mysqli_stmt_error($stmt);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    echo "Invalid request.";
}
?>
