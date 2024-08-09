<?php
include("check_session.php");
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $session_name = $_POST['session_name'];
    $session_day = $_POST['session_day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $station_name = $_POST['station_name'];

    $stmt = $conn->prepare("UPDATE sessions SET session_name = ?, session_day = ?, start_time = ?, end_time = ?, station_name = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $session_name, $session_day, $start_time, $end_time, $station_name, $id);

    if ($stmt->execute()) {
        header("Location: session_list.php?status=success");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
