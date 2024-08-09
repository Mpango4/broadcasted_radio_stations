<?php
// Include necessary files and initialize session if needed
include('check_session.php');
include('db_connection.php'); // Adjust this to your database connection script

if (isset($_POST['file_id']) && is_numeric($_POST['file_id'])) {
    $file_id = intval($_POST['file_id']); // Convert to integer for safety
    
    // Log the received file_id for debugging
    error_log("Received file_id: " . $file_id);
    
    // Fetch the file path from the database before deleting the record
    $query = "SELECT file_path FROM audio_files WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $file_id);
        $stmt->execute();
        $stmt->bind_result($file_path);
        $stmt->fetch();
        $stmt->close();
        
        if ($file_path) { // Check if file_path is valid
            // Prepare and execute SQL DELETE statement
            $query = "DELETE FROM audio_files WHERE id = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('i', $file_id);
                if ($stmt->execute()) {
                    // Check if any rows were affected
                    if ($stmt->affected_rows > 0) {
                        // Delete the file from the filesystem
                        if (file_exists($file_path)) {
                            if (unlink($file_path)) {
                                echo json_encode(['status' => 'success']);
                            } else {
                                echo json_encode(['status' => 'error', 'message' => 'Failed to delete the file from the filesystem']);
                            }
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'File does not exist']);
                        }
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
            // Invalid file_path, no such file_id
            echo json_encode(['status' => 'error', 'message' => 'No file path found for the given file_id']);
        }
    } else {
        // Failed to prepare the select statement
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement']);
    }
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

// Close database connection
$conn->close();
?>
