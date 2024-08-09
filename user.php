<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* dashboard.css */
/* Global Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    color: #333;
    background-color: #f2f2f2;
}

.container {
    width: 90%;
    margin: 0 auto;
    max-width: 1200px;
}

/* Header Styles */
header {
    background-color: #333;
    color: #fff;
    padding: 10px 0;
    overflow: hidden;
    position: fixed;
    width: 100%;
    z-index: 1000;
}

.logo h1 {
    margin: 0;
    font-size: 1.5em;
}

nav {
    display: flex;
    align-items: center;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin: 0 10px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s;
}

nav ul li a:hover {
    color: #f0f0f0;
}

#navToggle {
    display: none;
    background: none;
    border: none;
    color: #fff;
    font-size: 1.5em;
    cursor: pointer;
}

/* Sidebar Styles */
.sidebar {
    background-color: #333;
    color: #fff;
    width: 250px;
    height: 100%;
    position: fixed;
    left: 0;
    top: 60px;
    overflow-y: auto;
    padding-top: 20px;
    z-index: 100;
    transition: width 0.3s;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    padding: 10px 20px;
    transition: background-color 0.3s;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: block;
}

.sidebar ul li a:hover {
    background-color: #555;
}

/* Main Content Styles */
main {
    margin-left: 250px;
    padding: 80px 20px 20px;
    transition: margin-left 0.3s;
}

.dashboard {
    text-align: center;
}

.dashboard h2 {
    margin-top: 0;
}

.session {
    margin-bottom: 30px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: left;
}

.session h3 {
    margin-top: 0;
}

.session audio {
    width: 100%;
    margin-top: 10px;
}

.options {
    margin-top: 10px;
}

.options a {
    color: #333;
    background-color: #f0f0f0;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.options a:hover {
    background-color: #e0e0e0;
}

/* Footer Styles */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
    width: 100%;
    position: fixed;
    bottom: 0;
}

footer p {
    margin: 0;
}

    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Radio Station</h1>
                </div>
                <div class="col text-right">
                    <nav>
                        <ul id="navList">
                            <li><a href="home.php">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="sessions.php">Sessions</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                        <button id="navToggle"><i class="fas fa-bars"></i></button>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <h2>User Dashboard</h2>
                    <ul>
                        <li><a href="#">Profile</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <main>
                    <section class="dashboard">
                        <h2>Welcome, User!</h2>
                        <div class="session">
                            <h3>Session 1</h3>
                            <p>Radio Station: Station Name 1</p>
                            <audio controls>
                                <source src="session1.mp3" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div class="options">
                                <a href="#" class="download"><i class="fas fa-download"></i> Download</a>
                                <a href="#" class="comment"><i class="fas fa-comment"></i> Comment</a>
                            </div>
                        </div>
                        <!-- Add more sessions as needed -->
                    </section>
                </main>
            </div>
        </div>
    </div>

    <footer class="fixed-bottom">
        <div class="container">
            <p>&copy; 2024 Radio Station</p>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
