<?php include("check_session.php");?>
  <?php include("header.php"); ?>
  <?php include("sidebar.php");?>
  <main id="main" class="main">
  <div class="col-lg-12">
  <div class="card">
  <div class="card-body">
    
<?php
include("db_connection.php");

// Fetch all comments from the database
$query = "SELECT * FROM comments where station_name = '$station_name'";
$result = $conn->query($query);

// Check if there are any comments
if ($result->num_rows > 0) {
    // Loop through each comment and display them
    while ($row = $result->fetch_assoc()) {
        $comment = $row['comment'];
        $username = $row['username'];
        $sessionName = $row['session_name'];
        $commentTime = $row['created_at'];

        // Display the comment within the session
        echo '
            <div class="sessio">
                <p><strong>Username:</strong> '.$username.'</p>
                <p><strong>Session Name:</strong> '.$sessionName.'</p>
                <p><strong>Comment:</strong> '.$comment.'</p>
                <p><strong>Last Comment Time:</strong> '.$commentTime.'</p>
            </div>
        ';
    }
} else {
    // If there are no comments, display a message
    echo '<div class="sessio">No comments found.</div>';
}

// Close the database connection
//$conn->close();
?>
</div>
</div>
</div>
</main>
<?php include("footer.php")?>
