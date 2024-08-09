<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Prepare and execute SQL statement to fetch user data
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Return user data as JSON response
        echo json_encode($user);
    } else {
        // Return error message or response if needed
        echo "User not found.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
