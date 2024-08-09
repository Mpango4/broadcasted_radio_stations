<?php
// Include database connection

include("include/db_connection.php");

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


//$owner_id = $_SESSION['username']; // Assuming the session variable contains the user ID
//$station_name = getStationName($id);

function getTotalSessions($conn) {
    $query = "SELECT COUNT(*) as total FROM users ";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

function getTotalAudios($conn) {
    $query = "SELECT COUNT(*) as total FROM users where role ='owner'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}


function getTotalradios($conn) {
    $query = "SELECT COUNT(*) as total FROM radio_stations";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}


$totalusers = getTotalSessions($conn);
$totalradios = getTotalradios($conn);
$totalOwners = getTotalAudios($conn);
$normal= $totalusers - $totalOwners;

?>
