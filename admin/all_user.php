<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);
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

                    <!-- Recent Users -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <!-- Add New User Button -->
                                <div class="mb-3">
                                    <a href="add_user.php" class="btn btn-primary">Add New User</a>
                                </div>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) { ?>
                                            <tr>
                                                <th scope="row" class="user-id"><?php echo $user['id']; ?></th>
                                                <td><?php echo $user['username']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['role']; ?></td>
                                                <td><button class="btn btn-success btn-edit" data-id="<?php echo $user['id']; ?>"><i class="bi bi-pencil-square"></i> Edit</button></td>
                                                <td><button class="btn btn-danger btn-delete" data-id="<?php echo $user['id']; ?>"><i class="bi bi-trash"></i> Delete</button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Recent Users -->

                </div>
            </div><!-- End Left side columns -->
        </div>
        <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit user form -->
                        <form id="editUserForm">
                            <input type="hidden" id="editUserId" name="editUserId">
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" id="editUsername" name="editUsername">
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="editEmail">
                            </div>
                            <div class="mb-3">
                                <label for="editRole" class="form-label">Role</label>
                                <select class="form-select" id="editRole" name="editRole">
                                    <option value="admin">Admin</option>
                                    <option value="owner">Owner</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include("include/footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Functionality for edit button
        $('.btn-edit').click(function() {
            // Get the user ID from the data-id attribute
            var userId = $(this).data('id');

            // Perform AJAX request to fetch user data
            $.ajax({
                url: 'fetch_user.php',
                method: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    // Populate edit form with user data
                    $('#editUserId').val(response.id);
                    $('#editUsername').val(response.username);
                    $('#editEmail').val(response.email);
                    $('#editRole').val(response.role);

                    // Show the edit form
                    $('#editUserModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Handle form submission for editing user
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            // Perform AJAX request to update user data
            $.ajax({
                url: 'update_user.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Reload the page after successful update
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Functionality for delete button
        $('.btn-delete').click(function() {
            // Get the user ID from the data-id attribute
            var userId = $(this).data('id');

            // Confirm deletion
            var confirmDelete = confirm('Are you sure you want to delete this user?');

            if (confirmDelete) {
                // Perform AJAX request to delete user
                $.ajax({
                    url: 'delete_user.php',
                    method: 'POST',
                    data: { user_id: userId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Reload the page after successful deletion
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
