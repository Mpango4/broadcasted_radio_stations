<?php 
include("check_session.php");
include("header.php");
include("sidebar.php");

// Fetch the logged-in owner's details, including the radio station name
include("db_connection.php");
$owner_id = $_SESSION['id'];
$query = "SELECT * FROM radio_stations WHERE user_id = '$id'";
$result = $conn->query($query);
$station = $result->fetch_assoc();
$station_name = $station['station_name'];
?>

<main id="main" class="main">
<div class="col-lg-6">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Add Session</h5>

    <!-- Vertical Form -->
    <form class="row g-3" method="post" action="add_session.php">
      <div class="col-12">
        <label for="inputName4" class="form-label">Session Name</label>
        <input type="text" name="session_name" class="form-control" id="inputName4" required>
      </div>
      <div class="col-12">
        <label for="inputDay" class="form-label">Session Day</label>
        <select name="session_day" class="form-control" id="inputDay" required>
          <option value="" disabled selected>Select a day</option>
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          <option value="Saturday">Saturday</option>
          <option value="Sunday">Sunday</option>
        </select>
      </div>
      <div class="col-12">
        <label for="inputStartTime" class="form-label">Start Time</label>
        <input type="time" name="start_time" class="form-control" id="inputStartTime" required>
      </div>
      <div class="col-12">
        <label for="inputEndTime" class="form-label">End Time</label>
        <input type="time" name="end_time" class="form-control" id="inputEndTime" required>
      </div>
      <input type="hidden" name="station_name" value="<?php echo $station_name; ?>">

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form><!-- Vertical Form -->

  </div>
</div>
</main>
<?php include("footer.php"); ?>
