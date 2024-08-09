<?php
// Include session check and database connection
include("check_session.php");
include("include/db_connection.php");

// Initialize variables to hold form data and error messages
$username = $email = $password = $confirmPassword = "";
$usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirmPassword"]);
    $role = trim($_POST["role"]); // Default role

    // Validate username
    if (empty($username)) {
        $usernameErr = "Username is required.";
    }

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $emailErr = "Email already exists.";
        }
        $stmt->close();
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required.";
    } elseif (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters long.";
    }

    // Validate confirm password
    if (empty($confirmPassword)) {
        $confirmPasswordErr = "Please confirm your password.";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match.";
    }

    // If no errors, insert into database
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $passwordHash, $role);

        if ($stmt->execute()) {
           header("location:all_user.php");
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>USERS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">users</li>
                <li class="breadcrumb-item active">Add user</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ADD NEW</h5>

                <!-- Floating Labels Form -->
                <form class="row g-3" action="add_user.php" method="POST">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="username" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                            <label for="username">User name</label>
                            <span class="error"><?php echo $usernameErr; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" placeholder="abc@gmail.com" name="email">
                            <label for="email">Email</label>
                            <span class="error"><?php echo $emailErr; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <label for="password">Password</label>
                            <span class="error"><?php echo $passwordErr; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword">
                            <label for="confirmPassword">Confirm Password</label>
                            <span class="error"><?php echo $confirmPasswordErr; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="role" name="role">
                                <option value="admin">Admin</option>
                                <option value="owner">Owner
                                </option>
                                <option value="user">User</option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Floating Labels Form -->
            </div>
        </div>
    </section>
</main><!-- End #main -->

<!-- Include Footer -->
<?php include("include/footer.php"); ?>
