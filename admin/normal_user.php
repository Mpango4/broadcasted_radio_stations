<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

// Fetch users with role "user" from the database
$query = "SELECT * FROM users WHERE role = 'user'";
$result = $conn->query($query);
$owners = $result->fetch_all(MYSQLI_ASSOC);
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

                    <!-- Recent Owners -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Owners</h5>
                                <!-- Add New Owner Button -->
                                <div class="mb-3">
                                    <a href="add_owner.php" class="btn btn-primary">Add New Owner</a>
                                </div>
                                <?php if (count($owners) > 0) { ?>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($owners as $owner) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $owner['id']; ?></th>
                                                    <td><?php echo $owner['username']; ?></td>
                                                    <td><?php echo $owner['email']; ?></td>
                                                    <td><button class="badge bg-success"><i class="bi bi-pencil-square"></i></button></td>
                                                    <td><button class="badge bg-danger"><i class="bi bi-trash"></i></button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>No users found.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div><!-- End Recent Owners -->

                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include("include/footer.php"); ?>
