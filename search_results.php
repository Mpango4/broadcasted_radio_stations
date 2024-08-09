<?php
// Check if the search query is provided in the URL
if(isset($_GET['query'])) {
    // Retrieve the search query from the URL
    $searchQuery = $_GET['query'];

    // Include the file with your database connection
    include("db_connection.php");

    // Perform the search query on your database
    // Adjust the table name and column names according to your database structure
    $query = "SELECT * FROM your_table WHERE station_name LIKE '%$searchQuery%' OR session_name LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($query);

    // Check if there are any results
    if ($result) {
        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Display search results
            while ($row = $result->fetch_assoc()) {
                // Display each search result, adjust this based on your requirements
                echo "<p>Station: " . $row['station_name'] . ", Session: " . $row['session_name'] . "</p>";
            }
        } else {
            // No search results found
            echo "No results found for your search query: $searchQuery";
        }
    } else {
        // Error executing the query
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If no search query is provided in the URL
    echo "Please provide a search query.";
}
?>
