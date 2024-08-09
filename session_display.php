<?php
include("check_session.php");
include("db_connection.php");

// Fetch all session details from the database
$query = "
    SELECT id, session_name, session_day, start_time, end_time 
    FROM sessions 
    ORDER BY session_name ASC";

$result = $conn->query($query);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$sessions = [];
if ($result->num_rows > 0) {
    $sessions = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sessions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<main id="main" class="main">
    <div class="col-12">
        <div class="card recent-sales overflow-auto">
            <div class="card-body">
                <h5 class="card-title">Sessions</h5>
                <table class="table table-borderless datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Session Name</th>
                            <th scope="col">Day</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sessions)): ?>
                            <?php foreach ($sessions as $index => $session): ?>
                                <tr>
                                    <th scope="row"><?php echo $index + 1; ?></th>
                                    <td><?php echo htmlspecialchars($session['session_name']); ?></td>
                                    <td><?php echo htmlspecialchars($session['session_day']); ?></td>
                                    <td><?php echo htmlspecialchars($session['start_time']); ?></td>
                                    <td><?php echo htmlspecialchars($session['end_time']); ?></td>
                                    <td>
                                        <a href="view_audios.php?session_id=<?php echo $session['id']; ?>" class="badge bg-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No sessions found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- End Recent radio -->
</main>
<?php include("footer.php"); ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
