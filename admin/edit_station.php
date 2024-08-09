<?php
include("check_session.php");
include("include/db_connection.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $station_id = $_GET['id'];
    
    $query = "SELECT * FROM radio_stations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $station_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $station = $result->fetch_assoc();
    
    if (!$station) {
        echo "Station not found.";
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $station_name = $_POST['station_name'];
        $frequency = $_POST['frequency'];
        $location = $_POST['location'];
        
        $query = "UPDATE radio_stations SET station_name = ?, frequency = ?, location = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $station_name, $frequency, $location, $station_id);
        
        if ($stmt->execute()) {
            header("Location: lists.php?message=Station updated successfully");
            exit;
        } else {
            echo "Failed to update station.";
        }
    }
} else {
    echo "Invalid station ID.";
    exit;
}
?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Radio Station</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Radio Station</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Station</h5>
                        <form method="POST">
                            <div class="form-group">
                                <label for="station_name">Station Name</label>
                                <input type="text" class="form-control" id="station_name" name="station_name" value="<?php echo htmlspecialchars($station['station_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="frequency">Frequency</label>
                                <input type="text" class="form-control" id="frequency" name="frequency" value="<?php echo htmlspecialchars($station['frequency']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($station['location']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="lists.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include("include/footer.php"); ?>
