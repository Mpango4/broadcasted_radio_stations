<?php
include("check_session.php");
include("include/db_connection.php");

$stationNameError = $frequencyError = $stationOwnerError = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $station_name = $_POST['station_name'];
    $frequency = $_POST['frequency'];
    $user_id = $_POST['station_owner']; // Change to user_id
    $location = $_POST['location'];

    // Validate station name
    $query = $conn->prepare("SELECT * FROM radio_stations WHERE station_name = ?");
    $query->bind_param("s", $station_name);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        $stationNameError = "Station name already registered.";
    }

    // Validate frequency format (e.g., "100.0 MHz")
    if (!preg_match("/^\d{2,3}\.\d{1} MHz$/", $frequency)) {
        $frequencyError = "Invalid frequency format. Example: 100.0 MHz";
    }

    // Check if the selected user exists and is an owner
    $query = $conn->prepare("SELECT id FROM users WHERE id = ? AND role = 'owner'");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows == 0) {
        $stationOwnerError = "Invalid station owner.";
    }

    if (empty($stationNameError) && empty($frequencyError) && empty($stationOwnerError)) {
        // Insert the station into the database
        $query = $conn->prepare("INSERT INTO radio_stations (station_name, frequency, user_id, location) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssis", $station_name, $frequency, $user_id, $location);

        if ($query->execute()) {
            $successMessage = "Radio station registered successfully!";
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    }
}

// Fetch users for the station owner dropdown
$query = "SELECT id, username FROM users WHERE role = 'owner'";
$result = $conn->query($query);
$owners = $result->fetch_all(MYSQLI_ASSOC);
?>


<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<main id="main" class="main">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register Station</h5>
                <?php if (!empty($successMessage)) { ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php } ?>
                <!-- Vertical Form -->
                <form class="row g-3" method="POST" action="register_radio.php">
                    <div class="col-12">
                        <label for="station_name" class="form-label">Station Name</label>
                        <input type="text" class="form-control" id="station_name" name="station_name" required>
                        <div class="text-danger"><?php echo $stationNameError; ?></div>
                    </div>
                    <div class="col-12">
                        <label for="frequency" class="form-label">Frequency</label>
                        <input type="text" class="form-control" id="frequency" name="frequency" required>
                        <div class="text-danger"><?php echo $frequencyError; ?></div>
                    </div>
                    <div class="col-12">
                        <label for="station_owner" class="form-label">Station Owner</label>
                        <select class="form-control" id="station_owner" name="station_owner" required>
                            <?php foreach ($owners as $owner) { ?>
                                <option value="<?php echo $owner['id']; ?>"><?php echo $owner['username']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="text-danger"><?php echo $stationOwnerError; ?></div>
                    </div>
                    <div class="col-12">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>
    </div>
</main><!-- End #main -->
<?php include("include/footer.php"); ?>
