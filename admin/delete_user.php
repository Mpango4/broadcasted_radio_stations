<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Prepare and execute SQL statement to delete user
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Return success message as JSON response
        echo json_encode(array("success" => true, "message" => "User deleted successfully."));
    } else {
        // Return error message as JSON response
        echo json_encode(array("success" => false, "message" => "Error deleting user."));
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
