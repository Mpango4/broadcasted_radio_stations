<?php
include("check_session.php");
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the logged-in owner's ID
    $user_id = $_SESSION['id'];

    // Retrieve other form data
    $session_name = $_POST['session_name'];
    $session_day = $_POST['session_day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $station_name = $_POST['station_name'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO sessions ( session_name, session_day, start_time, end_time, station_name,user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $session_name, $session_day, $start_time, $end_time, $station_name, $user_id);


    if ($stmt->execute()) {
        // Redirect to a confirmation page or back to the sessions list
        header("Location: session_list.php?status=success");
        exit(); // Add exit to prevent further execution
    } else {
        // Handle the error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
