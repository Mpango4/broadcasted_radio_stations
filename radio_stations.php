<?php
include("check_session.php");
include("db_connection.php");
//include("functions.php");

// Fetch all radio stations
$query = "SELECT * FROM radio_stations";
$result = $conn->query($query);

?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Radio Stations</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Radio Stations</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Radio Stations</h5>

                        <!-- Search Bar -->
                        <div class="input-group mb-3">
                            <input type="text" id="search" class="form-control" placeholder="Search for stations...">
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped" id="stationsTable">
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
                                <?php
                                if ($result->num_rows > 0) {
                                    $index = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<th scope='row'>" . $index++ . "</th>";
                                        echo "<td>" . htmlspecialchars($row['station_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['frequency']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                        echo "<td><a href='view_station.php?station_name=" . urlencode($row['station_name']) . "' class='btn btn-primary'><i class='bi bi-eye'></i> View</a></td>";

                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No radio stations found.</td></tr>";
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

<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#stationsTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</body>
</html>
