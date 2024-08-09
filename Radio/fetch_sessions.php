<?php
include("check_session.php");
include("db_connection.php");

// Fetch all session details from the database
$query = "
    SELECT id, session_name, session_day, start_time, end_time 
    FROM sessions  where user_id ='$id'
    ORDER BY session_name ASC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $sessions = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $sessions]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No sessions found.']);
}

$conn->close();
?>
