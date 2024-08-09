<?php
include("check_session.php");
include("db_connection.php");

try {
    // Fetch all audio files from the database, including session names, ordered by the upload date in descending order
    $query = "
        SELECT audio_files.*, sessions.session_name 
        FROM audio_files where user_id = '$id'
        JOIN sessions ON audio_files.session_id = sessions.id 
        ORDER BY audio_files.upload_date DESC ";
    
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $audio_files = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(['status' => 'success', 'data' => $audio_files]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No audio files found.']);
        }
    } else {
        throw new Exception("Query failed: " . $conn->error);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
