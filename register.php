<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* register.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        form {
            width: 350px; /* Increased width */
            margin: 0 auto;
            border: none;
            padding: 20px;
            border-radius: 15px; /* Increased border radius */
            background-color: #f0f0f0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Increased box shadow */
            position: relative; /* Make the form position relative for absolute positioning of the back button */
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left; /* Left-align labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 40px);
            padding: 12px; /* Increased padding */
            margin-bottom: 20px; /* Increased margin */
            border: none;
            border-radius: 8px; /* Increased border radius */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 16px; /* Increased font size */
        }

        button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 12px 24px; /* Increased padding */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px; /* Increased font size */
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        p {
            color: #666;
            margin-top: 20px;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

    </style>
</head>
<body>
    <main>
        <?php
        // Initialize variables to hold form data and error messages
        $username = $email = $password = $confirmPassword = "";
        $usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

        // Database connection
        $conn = new mysqli("localhost", "root", "", "radio_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $confirmPassword = trim($_POST["confirmPassword"]);
            $role = "user"; // Default role

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
        <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Back button -->
            <a href="home.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>

            
            <h1>User Registration</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <span class="error"><?php echo $usernameErr; ?></span><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <span class="error"><?php echo $emailErr; ?></span><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo $passwordErr; ?></span><br><br>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <span class="error"><?php echo $confirmPasswordErr; ?></span><br><br>

            <button type="submit">Register</button>
            <p>Already have a membership? <a href="login.php">Login here</a></p>
        </form>
    </main>
</body>
</html>