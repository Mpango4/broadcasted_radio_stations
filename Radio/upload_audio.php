<?php
include("check_session.php");
include("header.php");
include("sidebar.php");
include("db_connection.php");

// Fetch sessions from the database
$query = "SELECT id, session_name FROM sessions WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$sessions = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch the station name based on the logged-in user
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>AUDIOS</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">audio</li>
        <li class="breadcrumb-item active">audio list</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Audios</h5>
          <!-- Vertical Form -->
          <form class="row g-3" id="uploadForm" method="post" enctype="multipart/form-data">
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Your Audio</label>
              <input type="file" class="form-control" id="inputNanme4" name="audio_file" accept="audio/*">
            </div>
            <div class="col-12">
              <label for="session_id" class="form-label">Session Name</label>
              <select class="form-control" id="session_id" name="session_id">
                <?php foreach ($sessions as $session) { ?>
                  <option value="<?php echo $session['id']; ?>"><?php echo $session['session_name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-12">
              <label for="station_name" class="form-label">Station Name</label>
              <input type="text" class="form-control" id="station_name" name="station_name" value="<?php echo $station_name; ?>" readonly>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form><!-- Vertical Form -->
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<?php include("footer.php"); ?>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var formData = new FormData(this);

    fetch('audio_handle.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Audio file uploaded successfully!');
            // Optionally, redirect or refresh the page
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while uploading the audio file.');
    });
});
</script>
