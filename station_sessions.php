<?php
//include("check_session.php");
include("db_connection.php");

// Get the station name from the URL
$station_name = isset($_GET['station_name']) ? $_GET['station_name'] : '';

if ($station_name) {
    // Query to fetch sessions for the specified station name
    $query = $conn->prepare("
        SELECT sessions.id, sessions.session_name, sessions.session_day, sessions.start_time, sessions.end_time 
        FROM sessions 
        JOIN audio_files ON sessions.id = audio_files.session_id 
        WHERE audio_files.station_name = ?
    ");
    $query->bind_param("s", $station_name);
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        $sessions = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $sessions = [];
    }

    $query->close();
} else {
    $sessions = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions for <?php echo htmlspecialchars($station_name); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .table thead th {
            background-color: #343a40;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        html, body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
}

.container-flex {
    flex: 1;
}

footer {
    position: relative;
    width: 100%;
    bottom: 0;
    background-color: #343a40;
    color: white;
    text-align: center;
    padding: 1rem 0;
}

    </style>
</head>
<body>
    <header class="bg-dark text-white text-center py-3 mb-4">
        <div class="container">
            <h1>Sessions for <?php echo htmlspecialchars($station_name); ?></h1>
        </div>
    </header>

    <div class="container-flex">
        <section class="sessions">
            <div class="container">
                <?php if (!empty($sessions)): ?>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Session Name</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Audio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sessions as $index => $session): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($session['session_name']); ?></td>
                                    <td><?php echo htmlspecialchars($session['session_day']); ?></td>
                                    <td><?php echo htmlspecialchars($session['start_time']); ?></td>
                                    <td><?php echo htmlspecialchars($session['end_time']); ?></td>
                                    <td><a href="Radio/audios.php" class="text-primary"><i class="fas fa-music"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No sessions found for this station.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Your Radio Station. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
