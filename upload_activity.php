<?php
require_once 'config.php'; // includes $link

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $date = $_POST['date'];

    // Check if file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imgName = $_FILES['image']['name'];
        $imgTmp = $_FILES['image']['tmp_name'];

        // Generate a unique filename to avoid overwriting
        $newImgName = uniqid() . "-" . basename($imgName);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $newImgName;

        // Ensure upload directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move file to uploads/
        if (move_uploaded_file($imgTmp, $targetFile)) {
            $query = "INSERT INTO tblactivity (title, date, image) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, "sss", $title, $date, $newImgName);

            if (mysqli_stmt_execute($stmt)) {
                echo "Activity successfully added.";
            } else {
                echo "Database error: " . mysqli_error($link);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No image uploaded or upload error.";
    }

    mysqli_close($link);
} else {
    echo "Invalid request.";
}
?>
