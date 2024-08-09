<?php 
include("check_session.php");
include("header.php");
include("sidebar.php"); 
include("db_connection.php");

// Fetch sessions from the database
// Fetch sessions belonging to the logged-in owner's radio station
$query = "SELECT * FROM sessions where user_id = '$id'";
$result = $conn->query($query);
$sessions = $result->fetch_all(MYSQLI_ASSOC);

?>

<main id="main" class="main">
<div class="col-lg-12">

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Sessions</h5>

    <!-- Add New Session Button -->
    <div class="mb-3">
      <button class="btn btn-primary" onclick="openAddSessionForm()">Add New Session</button>
    </div>

    <!-- Search Form -->
    <div class="mb-3">
      <input type="text" id="searchInput" class="form-control" placeholder="Search sessions..." onkeyup="searchTable()">
    </div>

    <!-- Table with stripped rows -->
    <table class="table table-striped" id="sessionsTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Session Name</th>
          <th scope="col">Session Day</th>
          <th scope="col">Start Time</th>
          <th scope="col">End Time</th>
          <th scope="col">Station Name</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sessions as $session) { ?>
          <tr>
            <th scope="row"><?php echo $session['id']; ?></th>
            <td><?php echo $session['session_name']; ?></td>
            <td><?php echo $session['session_day']; ?></td>
            <td><?php echo $session['start_time']; ?></td>
            <td><?php echo $session['end_time']; ?></td>
            <td><?php echo $session['station_name']; ?></td>
            <td>
              <button class="btn btn-success" onclick="openEditForm(<?php echo $session['id']; ?>)">Edit</button>
              <button class="btn btn-danger" onclick="deleteSession(<?php echo $session['id']; ?>)">Delete</button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <!-- End Table with stripped rows -->

  </div>
</div>
</main>

<!-- Edit Form Overlay -->
<div id="editFormOverlay" class="overlay">
  <div class="overlay-content">
    <span class="closebtn" onclick="closeEditForm()" title="Close Overlay">×</span>
    <form id="editForm" method="post" action="">
      <input type="hidden" name="id" id="editSessionId">
      <div class="mb-3">
        <label for="editSessionName" class="form-label">Session Name</label>
        <input type="text" name="session_name" class="form-control" id="editSessionName" required>
      </div>
      <div class="mb-3">
        <label for="editSessionDay" class="form-label">Session Day</label>
        <select name="session_day" class="form-control" id="editSessionDay" required>
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          <option value="Saturday">Saturday</option>
          <option value="Sunday">Sunday</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="editStartTime" class="form-label">Start Time</label>
        <input type="time" name="start_time" class="form-control" id="editStartTime" required>
      </div>
      <div class="mb-3">
        <label for="editEndTime" class="form-label">End Time</label>
        <input type="time" name="end_time" class="form-control" id="editEndTime" required>
      </div>
      <div class="mb-3">
        <label for="editStationName" class="form-label">Station Name</label>
        <input type="text" name="station_name" class="form-control" id="editStationName" value="<?=$station_name?>" readonly>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>

<?php include("footer.php"); ?>

<style>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
  display: none;
  justify-content: center;
  align-items: center;
}

.overlay-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  width: 50%;
  max-width: 500px;
}

.closebtn {
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  color: #fff;
  cursor: pointer;
}
</style>

<script>
// Function to open the add session form
function openAddSessionForm() {
  document.getElementById("editForm").action = "add_session.php";
  document.getElementById("editForm").reset();
  document.getElementById("editFormOverlay").style.display = "flex";
}

// Function to open the edit form
function openEditForm(id) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_session.php?id=' + id, true);
  xhr.onload = function() {
    if (this.status == 200) {
      var session = JSON.parse(this.responseText);
      document.getElementById("editForm").action = "update_session.php";
      document.getElementById("editSessionId").value = session.id;
      document.getElementById("editSessionName").value = session.session_name;
      document.getElementById("editSessionDay").value = session.session_day;
      document.getElementById("editStartTime").value = session.start_time;
      document.getElementById("editEndTime").value = session.end_time;
      document.getElementById("editStationName").value = session.station_name;
      document.getElementById("editFormOverlay").style.display = "flex";
    }
  };
  xhr.send();
}

// Function to close the edit form
function closeEditForm() {
  document.getElementById("editFormOverlay").style.display = "none";
}

// Function to delete a session
function deleteSession(id) {
  if (confirm("Are you sure you want to delete this session?")) {
    window.location.href = 'delete_session.php?id=' + id;
  }
}

// Function to search the table
function searchTable() {
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("sessionsTable");
  tr = table.getElementsByTagName("tr");

  for (i = 1; i < tr.length; i++) {
    tr[i].style.display = "none";
    td = tr[i].getElementsByTagName("td");
    for (j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        }
      }
    }
  }
}
</script>
