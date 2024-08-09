<?php
include('check_session.php');
include('include/db_connection.php');

$user_id = $_SESSION['id'];
$username = $_POST['username'];
$email = $_POST['email'];

$query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $username, $email, $user_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
