<?php include("check_session.php");?>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php");?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../users.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Go</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="audios.php">view</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Recorded sessions</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-music"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?=$totalAudios?></h6>
                                       
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Go</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="radio_stations.php">view</a></li>
                                   
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Availabbe stations</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-radio"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?=$total_stations?></h6>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-12">
                <!-- News & Updates Traffic -->
                <div class="card">
                    <?php include("recent.php")?>
                </div><!-- End News & Updates -->
            </div><!-- End Right side columns -->

            <!-- Session Table -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Session</h5>

                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Session Name</th>
                                    <th scope="col">Session Day</th>
                                    <th scope="col">Station Name</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Database connection
                                $conn = new mysqli("localhost", "root", "", "radio_db");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch session data
                                $sql = "SELECT id, session_name, session_day, station_name, start_time, end_time FROM sessions";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<th scope='row'><a href='#'>" . htmlspecialchars($row['id']) . "</a></th>";
                                        echo "<td><a href='#' class='text-primary'>" . htmlspecialchars($row['session_name']) . "</a></td>";
                                        echo "<td>" . htmlspecialchars($row['session_day']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['station_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                                        echo "<td><a href='view_audios.php?id=" . htmlspecialchars($row['id']) . "' class='badge bg-info'><i class='bi bi-eye'></i></a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No sessions found.</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Session Table -->

        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include("footer.php")?>
