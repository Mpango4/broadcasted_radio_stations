<?php
include("check_session.php");
include("db_connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM sessions WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        header("Location: session_list.php?status=deleted");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
