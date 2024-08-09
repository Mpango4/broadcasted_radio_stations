<?php
include("check_session.php");
include("db_connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM sessions WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $session = $result->fetch_assoc();
        echo json_encode($session);
    } else {
        echo json_encode([]);
    }
}
?>
