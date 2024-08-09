<?php
include("check_session.php");
include("include/db_connection.php");

// Fetch total users
$totalUsersQuery = "SELECT COUNT(*) as total FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

// Fetch total owners
$totalOwnersQuery = "SELECT COUNT(*) as total FROM users WHERE role = 'owner'";
$totalOwnersResult = $conn->query($totalOwnersQuery);
$totalOwners = $totalOwnersResult->fetch_assoc()['total'];

// Fetch normal users
$normalUsersQuery = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
$normalUsersResult = $conn->query($normalUsersQuery);
$normalUsers = $normalUsersResult->fetch_assoc()['total'];

// Fetch total radio stations
$totalRadiosQuery = "SELECT COUNT(*) as total FROM radio_stations";
$totalRadiosResult = $conn->query($totalRadiosQuery);
$totalRadios = $totalRadiosResult->fetch_assoc()['total'];

// Fetch recent sessions
$recentSessionsQuery = "SELECT r.id, r.station_name, r.frequency,r.location,  u.username
                        FROM radio_stations r
                        JOIN users u ON r.user_id = u.id
                        LIMIT 5";
$recentSessionsResult = $conn->query($recentSessionsQuery);

include("include/header.php");
include("include/sidebar.php");
?>

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
      <div class="col-lg-8">
        <div class="row">

          <!-- Total Users Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="all_user.php">view</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Total Users </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $totalUsers ?></h6>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Total Users Card -->

          <!-- Total Owners Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Owners</h6>
                  </li>
                  <li><a class="dropdown-item" href="station_owner.php">view</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Total Owners</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $totalOwners ?></h6>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Total Owners Card -->

          <!-- Normal Users Card -->
          <div class="col-xxl-4 col-xl-6">
            <div class="card info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Normal Users</h6>
                  </li>
                  <li><a class="dropdown-item" href="#">view</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Normal Users</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $normalUsers ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Normal Users Card -->

          <!-- Radio Stations Card -->
          <div class="col-xxl-4 col-xl-6">
            <div class="card info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Stations</h6>
                  </li>
                  <li><a class="dropdown-item" href="lists.php">view</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Radio Stations</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bxs-radio"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $totalRadios ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Radio Stations Card -->

          <!-- Recent Sessions -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">Recent Stations</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Station Name</th>
                      <th scope="col">Frequency</th>
                      <th scope="col">Owner</th>
                      <th scope="col">Location</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($recentSessionsResult->num_rows > 0) {
                      $index = 1;
                      while ($row = $recentSessionsResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'><a href='#'>{$index}</a></th>";
                        echo "<td>" . htmlspecialchars($row['station_name']) . "</td>";
                        echo "<td><a href='#' class='text-primary'>" . htmlspecialchars($row['frequency']) . "</a></td>";
                        echo "<td><a href='#' class='text-primary'>" . htmlspecialchars($row['username']) . "</a></td>";
                        echo "<td><a href='#' class='text-primary'>" . htmlspecialchars($row['location']) . "</a></td>";
                        echo "<td><button class='badge bg-success'><i class='bi bi-pencil-square'></i></button></td>";
                        echo "<td><button class='badge bg-danger'><i class='bi bi-trash'></i></button></td>";
                        echo "</tr>";
                        $index++;
                      }
                    } else {
                      echo "<tr><td colspan='7'>No recent sessions found.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div><!-- End Recent Sessions -->

        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">

        <!-- Uploaded Audios -->
        <div class="card">
          <div class="card-body pb-0">
            <h5 class="card-title">Uploaded Audios <span>| Today</span></h5>

            <div class="news">
              <?php
              // Fetch today's uploaded audios
              $today = date('Y-m-d');
              $uploadedAudiosQuery = "SELECT s.session_name, a.station_name, a.audio_file_path 
                                      FROM audio_files a 
                                      JOIN sessions s ON a.session_id = s.id
                                     /* where upload_date ='$today'*/
                                     ";
              $uploadedAudiosResult = $conn->query($uploadedAudiosQuery);

              if ($uploadedAudiosResult->num_rows > 0) {
                while ($audio = $uploadedAudiosResult->fetch_assoc()) {
                  echo '<div class="post-item clearfix">';
                  echo '<div class="session">';
                  echo '<h3>' . htmlspecialchars($audio['session_name']) . '</h3>';
                  echo '<p>Radio Station: ' . htmlspecialchars($audio['station_name']) . '</p>';
                  echo '<audio controls>';
                  echo '<source src="../Radio/' . htmlspecialchars($audio['audio_file_path']) . '" type="audio/mpeg">';
                  echo 'Your browser does not support the audio element.';
                  echo '</audio>';
                  echo '</div>';
                  echo '</div>';
                }
              } else {
                echo '<p>No audios uploaded today.</p>';
              }
              ?>
            </div><!-- End sidebar recent posts-->

          </div>
        </div><!-- End Uploaded Audios -->

      </div><!-- End Right side columns -->

    </div>
  </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include("include/footer.php"); ?>
