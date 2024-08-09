<?php
include("check_session.php");
include("include/db_connection.php");

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $station_id = $_POST['id'];

    // Prepare and execute SQL DELETE statement
    $query = "DELETE FROM radio_stations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $station_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete station']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$stmt->close();
$conn->close();
?>
