<?php
include("check_session.php");
include("header.php");
include("sidebar.php");
include("db_connection.php");

// Fetch the total sessions and total audios for the logged-in user
$user_id = $_SESSION['id'];
$totalSessionsQuery = "SELECT COUNT(*) AS total_sessions FROM sessions WHERE user_id = ?";
$totalSessionsStmt = $conn->prepare($totalSessionsQuery);
$totalSessionsStmt->bind_param('i', $user_id);
$totalSessionsStmt->execute();
$totalSessionsResult = $totalSessionsStmt->get_result();
$totalSessions = $totalSessionsResult->fetch_assoc()['total_sessions'];

$totalAudiosQuery = "SELECT COUNT(*) AS total_audios FROM audio_files WHERE user_id = ?";
$totalAudiosStmt = $conn->prepare($totalAudiosQuery);
$totalAudiosStmt->bind_param('i', $user_id);
$totalAudiosStmt->execute();
$totalAudiosResult = $totalAudiosStmt->get_result();
$totalAudios = $totalAudiosResult->fetch_assoc()['total_audios'];

// Fetch session data
$sessionsQuery = "SELECT * FROM sessions WHERE user_id = ?";
$sessionsStmt = $conn->prepare($sessionsQuery);
$sessionsStmt->bind_param('i', $user_id);
$sessionsStmt->execute();
$sessionsResult = $sessionsStmt->get_result();
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Sessions</h6>
                  </li>
                  <li><a class="dropdown-item" href="session_list.php">View</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Total Sessions</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bxs-radio"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $totalSessions ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="card info-card revenue-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Audios</h6>
                  </li>
                  <li><a class="dropdown-item" href="audios.php">View</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Total Audios</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bxs-music"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $totalAudios ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body pb-0">
            <h5 class="card-title">Recent Recorded Sessions</h5>
            <div class="news">
              <?php include("recent.php"); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="card recent-sales overflow-auto">
          <div class="card-body">
            <h5 class="card-title">Sessions</h5>
            <table class="table table-borderless datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Session Name</th>
                  <th scope="col">Session Day</th>
                  <th scope="col">Station Name</th>
                  <th scope="col">Start Time</th>
                  <th scope="col">End Time</th>
                  <th scope="col">Upload Audio</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($session = $sessionsResult->fetch_assoc()): ?>
                <tr>
                  <th scope="row"><?= $session['id'] ?></th>
                  <td><?= $session['session_name'] ?></td>
                  <td><?= $session['session_day'] ?></td>
                  <td><?= $session['station_name'] ?></td>
                  <td><?= $session['start_time'] ?></td>
                  <td><?= $session['end_time'] ?></td>
                  <td>
                  <button type="submit" class="btn btn-primary btn-sm">
                      <a href="upload_audio.php?name=<?= $session['station_name'] ?>" style="color: white; text-decoration: none;">
                          Upload
                      </a>
                  </button>

                                 </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include("footer.php"); ?>
