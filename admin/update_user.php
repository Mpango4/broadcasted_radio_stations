<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editUserId'])) {
    $userId = $_POST['editUserId'];
    $username = $_POST['editUsername'];
    $email = $_POST['editEmail'];
    $role = $_POST['editRole'];

    // Prepare and execute SQL statement to update user data
    $query = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $email, $role, $userId);

    if ($stmt->execute()) {
        // Return success message or response if needed
        echo "User updated successfully.";
    } else {
        // Return error message or response if needed
        echo "Error updating user.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
