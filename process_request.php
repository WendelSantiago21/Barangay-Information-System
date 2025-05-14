<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "barangay_db";

// Connect to database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON request body
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$age = $data['age'];
$address = $data['address'];
$status = $data['status'];

// Insert into database
$sql = "INSERT INTO certificate_requests (name, age, address, status, seen) VALUES ('$name', '$age', '$address', '$status', 0)";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

$conn->close();
?>
