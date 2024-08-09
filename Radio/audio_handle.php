<?php
include("check_session.php");
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the logged-in owner's ID
    $user_id = $_SESSION['id'];
    $session_id = $_POST['session_id'];
    $station_name = $_POST['station_name'];

    // Handle the audio file upload
    if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] == UPLOAD_ERR_OK) {
        $audio_file = $_FILES['audio_file'];
        $upload_dir = 'uploads/';
        $audio_file_path = $upload_dir . basename($audio_file['name']);

        // Check if the file is a valid audio file
        $allowed_types = ['audio/mpeg', 'audio/wav', 'audio/ogg'];
        if (!in_array($audio_file['type'], $allowed_types)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid audio file type.']);
            exit;
        }

        // Check if the file already exists in the database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM audio_files WHERE audio_file_path = ?");
        $stmt->bind_param("s", $audio_file_path);
        $stmt->execute();
        $stmt->bind_result($file_count);
        $stmt->fetch();
        $stmt->close();

        if ($file_count > 0) {
            echo json_encode(['status' => 'error', 'message' => 'File already exists in the database.']);
            exit;
        }

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($audio_file['tmp_name'], $audio_file_path)) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO audio_files (user_id, session_id, station_name, audio_file_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $user_id, $session_id, $station_name, $audio_file_path);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move the uploaded file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading file.']);
    }
}
$conn->close();
?>
