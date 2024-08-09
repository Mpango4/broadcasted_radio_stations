<?php
include("check_session.php");
include("db_connection.php");

$station_name = isset($_GET['station_name']) ? $_GET['station_name'] : '';

if (empty($station_name)) {
    echo "Invalid station name.";
    exit;
}

// Fetch station details
$query = $conn->prepare("SELECT * FROM radio_stations WHERE station_name = ?");
$query->bind_param("s", $station_name);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $station = $result->fetch_assoc();
} else {
    echo "Station not found.";
    exit;
}

$query->close();

// Fetch sessions for the station
$query = $conn->prepare("SELECT * FROM sessions WHERE station_name = ?");
$query->bind_param("s", $station_name);
$query->execute();
$sessions_result = $query->get_result();

$sessions = [];
if ($sessions_result->num_rows > 0) {
    $sessions = $sessions_result->fetch_all(MYSQLI_ASSOC);
}

$query->close();
$conn->close();
?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo htmlspecialchars($station['station_name']); ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="radio_stations.php">Radio Stations</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($station['station_name']); ?></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Station Details</h5>

                        <p><strong>Station Name:</strong> <?php echo htmlspecialchars($station['station_name']); ?></p>
                        <p><strong>Frequency:</strong> <?php echo htmlspecialchars($station['frequency']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($station['location']); ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sessions</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Session Name</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($sessions) > 0) {
                                    $index = 1;
                                    foreach ($sessions as $session) {
                                        echo "<tr>";
                                        echo "<th scope='row'>" . $index++ . "</th>";
                                        echo "<td>" . htmlspecialchars($session['session_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($session['session_day']) . "</td>";
                                        echo "<td>" . htmlspecialchars($session['start_time']) . "</td>";
                                        echo "<td>" . htmlspecialchars($session['end_time']) . "</td>";
                                        echo "<td><a href='view_audios.php?id=" . htmlspecialchars($session['id']) . "' class='btn btn-primary'><i class='bi bi-music-note-list'></i> View</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo " no available sessions";
                                    //echo "<tr><td colspan='6'>No sessions found for this station.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php include("footer.php"); ?>

</body>
</html>
