<?php
// Include necessary files and initialize session if needed
include('check_session.php');
include('db_connection.php'); // Adjust this to your database connection script

if (isset($_POST['file_id'])) {
    $file_id = intval($_POST['file_id']); // Convert to integer for safety
echo $file_id;
    // Log the received file_id for debugging
    error_log("Received file_id: " . $file_id);

    // Prepare and execute SQL DELETE statement
    $query = "DELETE FROM audio_files WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $file_id);
        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
               header('location:audios.php');
            } else {
                // No rows affected, probably no such file_id
                echo json_encode(['status' => 'error', 'message' => 'No such audio file found']);
            }
        } else {
            // Failed to execute the query
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute the query']);
        }
        // Close statement
        $stmt->close();
    } else {
        // Failed to prepare the statement
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement']);
    }
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

// Close database connection
$conn->close();
?>
