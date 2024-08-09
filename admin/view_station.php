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
} else {
    echo "Invalid station ID.";
    exit;
}
?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Radio Station</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">View Radio Station</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($station['station_name']); ?></h5>
                        <p><strong>Frequency:</strong> <?php echo htmlspecialchars($station['frequency']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($station['location']); ?></p>
                        <a href="lists.php" class="btn btn-primary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include("include/footer.php"); ?>
