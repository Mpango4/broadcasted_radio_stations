<?php
include('check_session.php');
include('db_connection.php');

$user_id = $_SESSION['id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$renew_password = $_POST['renew_password'];

// Fetch current password from the database
$query = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

if (password_verify($current_password, $user['password'])) {
    if ($new_password === $renew_password) {
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Debug: Check if the password is hashed correctly
        if (!$new_password_hashed) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to hash new password']);
            exit;
        }

        $update_query = "UPDATE users SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('si', $new_password_hashed, $user_id);
        
        if ($update_stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            // Debug: Output MySQL error
            echo json_encode(['status' => 'error', 'message' => 'Failed to update password', 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'New passwords do not match']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
}
?>
