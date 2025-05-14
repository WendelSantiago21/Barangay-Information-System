<?php
// Include the database configuration file
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $other = trim($_POST['other']);

    // Collect selected purposes from checkboxes
    $purposes = isset($_POST['purpose']) ? $_POST['purpose'] : [];

    // Add "other" purpose if filled in
    if (!empty($other)) {
        $purposes[] = $other;
    }

    // Combine all purposes into a single string
    $purposeStr = implode(", ", $purposes);

    // Prepare the SQL statement
    $stmt = mysqli_prepare($link, "INSERT INTO tblcertificate (name, age, address, status, purpose) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssss", $name, $age, $address, $status, $purposeStr);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Your request has been successfully submitted!'); window.location.href='certificate_request.php';</script>";
        } else {
            echo "ERROR: Could not execute query: " . mysqli_stmt_error($stmt);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not prepare query: " . mysqli_error($link);
    }

    // Close the database connection
    mysqli_close($link);
}
?>

