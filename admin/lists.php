<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

// Fetch radio stations from the database
$query = "SELECT * FROM radio_stations";
$result = $conn->query($query);
$stations = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Radio Stations</h5>
                                <div class="mb-3">
                                    <a href="register_radio.php" class="btn btn-primary"><i class="bi bi-plus"></i> Add New Station</a>
                                </div>
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Station Name</th>
                                            <th scope="col">Frequency</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stations as $station) { ?>
                                            <tr>
                                                <th scope="row"><?php echo $station['id']; ?></th>
                                                <td><?php echo htmlspecialchars($station['station_name']); ?></td>
                                                <td><?php echo htmlspecialchars($station['frequency']); ?></td>
                                                <td><?php echo htmlspecialchars($station['location']); ?></td>
                                                <td>
                                                    <a href="view_station.php?id=<?php echo $station['id']; ?>" class="btn btn-info"><i class="bi bi-eye"></i> View</a>
                                                    <a href="edit_station.php?id=<?php echo $station['id']; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger" onclick="deleteStation(<?php echo $station['id']; ?>)"><i class="bi bi-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include("include/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function deleteStation(stationId) {
        if (confirm("Are you sure you want to delete this station?")) {
            $.ajax({
                url: 'delete_station.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: stationId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Optional: Remove the deleted station from UI
                        alert('Station deleted successfully.');
                        // Optional: Reload or refresh the table
                        location.reload();
                    } else {
                        alert('Failed to delete station. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error occurred while deleting station.');
                }
            });
        }
    }
</script>

<!-- End Footer -->
