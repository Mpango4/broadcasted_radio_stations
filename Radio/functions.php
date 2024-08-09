<?php
// Include database connection

include("db_connection.php");

// Function to fetch station name based on logged-in owner
function getStationName($id) {
    global $conn; // Access the global database connection object

    // Prepare and execute SQL query to fetch station name
    $stmt = $conn->prepare("SELECT station_name FROM radio_stations WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['station_name']; // Return the station name
    } else {
        return "Station Not Found"; // Return a default message if station is not found
    }
}

// Example usage:
// Assuming $owner_id contains the ID of the logged-in owner
$owner_id = $_SESSION['username']; // Assuming the session variable contains the user ID
$station_name = getStationName($id);

function getTotalSessions($conn, $id) {
    $query = "SELECT COUNT(*) as total FROM sessions WHERE user_id='$id'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

function getTotalAudios($conn, $id) {
    $query = "SELECT COUNT(*) as total FROM audio_files WHERE user_id='$id'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

function countComments() {
    // Include your database connection code here
    include("db_connection.php");
    //$station_name = getStationName($id);
    // Query to count the total number of comments
    $query = "SELECT COUNT(*) as total_comments FROM comments";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalComments = $row['total_comments'];
        return $totalComments;
    } else {
        return 0;
    }

    // Close the database connection
    
}

// Example usage:
$totalComments = countComments();

$totalSessions = getTotalSessions($conn, $id);
$totalAudios = getTotalAudios($conn, $id);

?>
