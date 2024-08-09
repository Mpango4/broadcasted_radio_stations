<?php
include("check_session.php");
include("db_connection.php");

// Fetch all audio files along with the session name
$query = "SELECT s.session_name, a.station_name, a.audio_file_path 
          FROM audio_files a 
          JOIN sessions s ON a.session_id = s.id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $audio_files = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $audio_files]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No audio files found.']);
}

$conn->close();
?>
