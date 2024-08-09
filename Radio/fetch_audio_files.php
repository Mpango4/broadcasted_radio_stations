<?php
include("check_session.php");
include("db_connection.php");

// Assuming $user_id is the logged-in user's ID
$user_id = $_SESSION['id'];

// Fetch all audio files along with the session name and id for the logged-in user
$query = "SELECT a.id, s.session_name, a.audio_file_path
          FROM audio_files a
          JOIN sessions s ON a.session_id = s.id
          WHERE a.user_id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $audio_files = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $audio_files]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No audio files found.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement']);
}

$conn->close();
?>
