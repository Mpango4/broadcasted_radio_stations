<?php
include("check_session.php");
include("db_connection.php");

header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Failed to submit comment'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if session username is set
    if (!isset($_SESSION['username'])) {
        $response['message'] = 'User is not logged in.';
        echo json_encode($response);
        exit;
    }

    $username = $_SESSION['username']; // Assume username is stored in session
    $session_name = trim($_POST['session_name']);
    $station_name = trim($_POST['station_name']);
    $comment = trim($_POST['comment']);

    if (!empty($comment) && !empty($session_name) && !empty($station_name)) {
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO comments (username, session_name, station_name, comment) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            $response['message'] = 'Database prepare statement failed: ' . $conn->error;
            echo json_encode($response);
            exit;
        }

        // Bind parameters
        $stmt->bind_param("ssss", $username, $session_name, $station_name, $comment);

        // Execute the statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Comment submitted successfully';
        } else {
            $response['message'] = 'Database execute statement failed: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'All fields are required.';
    }
}

echo json_encode($response);
$conn->close();
?>
