<?php
//include("check_session.php");
include("../db_connection.php");

$today = date('Y-m-d');
echo "Today's date: " . $today . "<br>";

// Print today's date for debugging
echo "Today's date used in query: " . $today . "<br>";

// Fetch audio files along with the associated session names
$query = "
    SELECT audio_files.*, sessions.session_name
    FROM audio_files 
    JOIN sessions ON audio_files.session_id = sessions.id
    WHERE DATE(audio_files.upload_date) = ?
";

// Prepare the statement
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Bind the date parameter
$stmt->bind_param('s', $today);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

// Fetch and output results
if ($result->num_rows > 0) {
    $audio_files = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $audio_files]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No audio files found.']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
