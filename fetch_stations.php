<?php
include("db_connection.php");

// Query to fetch station names
$query = "SELECT station_name FROM radio_stations"; // Adjust the table and column names as necessary
$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all station names
    $stations = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $stations = [];
}

$conn->close();
?>

<!-- Generate dropdown items -->
<div class="dropdown-menu">
    <?php foreach ($stations as $station): ?>
        <a class="dropdown-item" href="station_sessions.php?station_name=<?php echo urlencode($station['station_name']); ?>"><?php echo htmlspecialchars($station['station_name']); ?></a>
    <?php endforeach; ?>
</div>
