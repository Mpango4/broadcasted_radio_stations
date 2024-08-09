<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Station</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Header container to align items in a row */
        header {
            background-color: #f8f9fa; /* Background color for header */
            padding: 10px 0; /* Padding for header */
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1140px;
            margin: 0 auto;
        }

        .logo h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .navbar-nav {
            margin-left: auto; /* Float the nav links to the right */
        }

        .navbar-nav .nav-item {
            margin-left: 15px; /* Space out the links */
        }

        .navbar-nav .nav-link {
            color: #333; /* Default color for links */
        }

        .navbar-nav .nav-link:hover {
            color: #007bff; /* Color for link hover effect */
        }

        .navbar-toggler {
            border: none; /* Remove the default border */
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Radio Station</h1>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav" id="navList">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Radios
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                include("db_connection.php");
                                $query = "SELECT DISTINCT station_name FROM radio_stations";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<a class="dropdown-item" href="station_sessions.php?station_name=' . urlencode($row['station_name']) . '">' . htmlspecialchars($row['station_name']) . '</a>';
                                    }
                                }
                                $conn->close();
                                ?>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="containerhh">
            <h2>Welcome to Your Favorite Radio Station</h2>
            <p>Listen to the best sessions anytime, anywhere.</p>
            <a href="register.php" class="btn btn-primary">Join Now</a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-12 feature">
                    <i class="fas fa-music"></i>
                    <h3>Great Music</h3>
                    <p>Enjoy a variety of music genres from top artists.</p>
                </div>
                <div class="col-md-12 feature">
                    <i class="fas fa-broadcast-tower"></i>
                    <h3>Live Broadcasts</h3>
                    <p>Catch live broadcasts from our top radio hosts.</p>
                </div>
                <div class="col-md-12 feature">
                    <i class="fas fa-headphones-alt"></i>
                    <h3>On Demand</h3>
                    <p>Access recorded sessions anytime you want.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container text-center">
            <p class="text-white">&copy; 2024 Your Radio Station. All Rights Reserved.</p>
            <p class="text-white">Follow us on:
                <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
