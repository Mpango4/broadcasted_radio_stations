<?php
include("check_session.php");
include("db_connection.php");

$today = date('Y-m-d');

// Fetch audio files along with the associated session names
$query = "
    SELECT audio_files.*, sessions.session_name
    FROM audio_files 
    JOIN sessions ON audio_files.session_id = sessions.id
    
";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

//$stmt->bind_param('s', $today);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

if ($result->num_rows > 0) {
    $audio_files = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $audio_files]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No audio files found.']);
}

$stmt->close();
$conn->close();
?>
