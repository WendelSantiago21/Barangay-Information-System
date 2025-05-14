<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM tblindigency WHERE id = $id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        echo json_encode(['error' => 'Data not found']);
    }
}
?>
