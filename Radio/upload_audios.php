<?php
include("check_session.php");
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $session_id = $_POST['session_id'];
    $user_id = $_SESSION['id'];

    if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] == 0) {
        $audio_file = $_FILES['audio_file'];
        $upload_dir = 'uploads/';
        $file_name = basename($audio_file['name']);
        $target_file = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an audio file
        $allowed_types = ['mp3', 'wav', 'ogg'];
        if (in_array($file_type, $allowed_types)) {
            // Move the file to the upload directory
            if (move_uploaded_file($audio_file['tmp_name'], $target_file)) {
                // Insert the file info into the database
                $insertQuery = "INSERT INTO audio_files (user_id, session_id, file_path) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param('iis', $user_id, $session_id, $target_file);
                if ($stmt->execute()) {
                    header("Location: dashboard.php");
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type. Only MP3, WAV, and OGG files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an error uploading the file.";
    }
}
?>
