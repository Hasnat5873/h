<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM biodata WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: read.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}
$conn->close();
?>
