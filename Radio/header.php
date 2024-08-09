
<?php include("functions.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Radio broadcast</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

 
  <style>
    .sessio {
    background-color: #f9f9f9;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    width: 400px; /* Reduced width */
    float: right; /* Float to the right */
    margin-right: 10px;
    position: relative;
}

#sessionss {
    clear: both;
    float: right; /* Float the entire section to the right */
    margin-left: 20px;
    background-color: beige;
    border-radius: 10px;
    width: 500px;
    max-height: 400px; /* Set maximum height */
    overflow-y: auto; /* Add vertical scrollbar if needed */
}
/* CSS */
.comment-section {
    max-height: 200px; /* Set maximum height */
    overflow-y: auto; /* Add vertical scrollbar if needed */
}

  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block"><?=$station_name?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

       
        <li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-danger badge-number"><?php
        $name = "new";
        echo $name;
        //$totalComments?></span>
    </a><!-- End Messages Icon -->

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
        <li class="dropdown-header">
            You have <?//$totalComments ?> new Comments
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <?php
        //include("functions.php");

        // Fetch a limited number of comments from the database
        $query = "SELECT * FROM comments where station_name = '$station_name' LIMIT 3"; // Change the limit as needed
        $result = $conn->query($query);

        // Check if there are any comments
        if ($result->num_rows > 0) {
            // Loop through each comment and display them
            while ($row = $result->fetch_assoc()) {
                $usernames = $row['username'];
                $session = $row['session_name'];
                $comment = $row['comment'];
                $time = $row['created_at'];

                // Display the comment
                echo '
                <li class="message-item">
                    <a href="#">
                        <img src="assets/img/okay.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4><strong>name:</strong>'.$usernames.'</h4>
                            <p><strong>session:</strong>'.$session.'</p>
                            <p><strong>comment:</strong>'.$comment.'</p>
                            <p><strong>time:</strong>'.$time.'</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
            ';
            
            }
        } else {
            // If there are no comments, display a message
            echo '<li class="message-item">No comments found.</li>';
        }

        // Close the database connection
        //$conn->close();
        ?>

        <li class="dropdown-footer">
            <a href="comments.php">Show all messages</a>
        </li>
    </ul><!-- End Messages Dropdown Items -->
</li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/okay.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=$username?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?=$username?></h6>
              <span><?=$role?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

           
            <li>
              <hr class="dropdown-divider">
            </li>

           

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->