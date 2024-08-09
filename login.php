

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="register.css">
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
        session_start();
  
        //session_start();
      
        // Initialize variables to hold form data and error messages
        $username = $password = "";
        $usernameErr = $passwordErr = $loginErr = "";

        // Database connection
        $conn = new mysqli("localhost", "root", "", "radio_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            // Validate username
            if (empty($username)) {
                $usernameErr = "Username is required.";
            }

            // Validate password
            if (empty($password)) {
                $passwordErr = "Password is required.";
            }

            // If no errors, check login credentials
            if (empty($usernameErr) && empty($passwordErr)) {
                $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id, $username, $hashedPassword, $role);

                if ($stmt->num_rows == 1) {
                    $stmt->fetch();
                    if (password_verify($password, $hashedPassword)) {
                        // Password is correct, start a new session
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["role"] = $role;

                        // Redirect based on role
                        if ($role == 'admin') {
                            header("Location: admin/admin.php");
                        } elseif ($role == 'owner') {
                            header("Location: Radio/dashboard.php");
                        } else {
                            header("Location: users.php");
                        }
                        exit();
                    } else {
                        $loginErr = "Invalid username or password.";
                    }
                } else {
                    $loginErr = "Invalid username or password.";
                }
                $stmt->close();
            }

            $conn->close();
        }
        ?>
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h1>User Login</h1>
            <span class="error"><?php echo $loginErr; ?></span><br><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <span class="error"><?php echo $usernameErr; ?></span><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo $passwordErr; ?></span><br><br>
            
            <button type="submit">Login</button>
           
            <p>Not yet a member? <a href="register.php">Register here</a></p>
        </form>
    </main>
</body>
</html>
