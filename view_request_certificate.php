<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($link, "SELECT * FROM tblcertificate WHERE id = $id");
    if ($result && mysqli_num_rows($result) > 0) {
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        echo json_encode(['error' => 'No data found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
