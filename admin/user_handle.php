
        <?php
        // Initialize variables to hold form data and error messages
        $username = $email = $password = $confirmPassword = "";
        $usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

        // Database connection
       include("include/db_connection.php");
        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $confirmPassword = trim($_POST["confirmPassword"]);
            $role =trim($_POST["role"]); // Default role

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
                    echo "<p>Registration successful. <a href='login.php'>Login here</a></p>";
                } else {
                    echo "<p>Error: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }

            $conn->close();
        }
        ?>
        
