<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
/* Global Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    color: #333;
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
}

#navToggle {
    display: none;
    background: none;
    border: none;
    color: #fff;
    font-size: 1.5em;
    cursor: pointer;
}

/* Main Content Styles */
main {
    padding: 20px 0;
}

.about-section {
    text-align: center;
}

.about-section h2 {
    font-size: 2em;
    margin-bottom: 20px;
}

.about-section p {
    font-size: 1.1em;
    line-height: 1.6;
    margin-bottom: 20px;
}

/* Footer Styles */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}

footer p {
    margin: 0;
}

/* Media Queries */
@media (max-width: 768px) {
    .container {
        padding: 0 20px;
    }

    nav ul {
        display: none;
        flex-direction: column;
        width: 100%;
    }

    nav ul li {
        margin: 10px 0;
    }

    #navToggle {
        display: block;
    }
}

@media (max-width: 480px) {
    .logo h1 {
        font-size: 1.2em;
    }

    .about-section h2 {
        font-size: 1.8em;
    }

    .about-section p {
        font-size: 1em;
    }
}

    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>Radio Station</h1>
            </div>
            <nav>
                <ul id="navList">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="sessions.php">Sessions</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
                <button id="navToggle"><i class="fas fa-bars"></i></button>
            </nav>
        </div>
    </header>

    <main>
        <section class="about-section">
            <div class="container">
                <h2>About Us</h2>
                <p>The "Broadcasted Radio Sessions" is an efficient platform for managing and archiving radio broadcasts. It offers user-friendly interfaces for different roles and includes an integrated audio player. The repository ensures 24/7 accessibility, allowing users to access and manage content anytime, anywhere, regardless of their location or time zone.</p>
                <p> This constant availability makes it a valuable tool for radio stations to maintain and utilize their broadcast history efficiently.</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Your Radio Station. All Rights Reserved.</p>
            <p>Follow us on:
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle').addEventListener('click', function() {
            var navList = document.getElementById('navList');
            if (navList.style.display === 'block') {
                navList.style.display = 'none';
            } else {
                navList.style.display = 'block';
            }
        });
    </script>
</body>
</html>