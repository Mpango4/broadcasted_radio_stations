<?php
include("check_session.php");
include("db_connection.php");

$session_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($session_id == 0) {
    echo "Invalid session ID.";
    exit;
}

// Fetch session details
$query = $conn->prepare("SELECT session_name, session_day, start_time, end_time FROM sessions WHERE id = ?");
$query->bind_param("i", $session_id);
$query->execute();
$query->bind_result($session_name, $day, $start_time, $end_time);
$query->fetch();
$query->close();

// Fetch all audio files for the session
$query = $conn->prepare("
    SELECT audio_files.*, users.username 
    FROM audio_files 
    JOIN users ON audio_files.user_id = users.id 
    WHERE audio_files.session_id = ?
    ORDER BY audio_files.upload_date DESC
");
$query->bind_param("i", $session_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $audio_files = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $audio_files = [];
}

$query->close();
$conn->close();
?>

<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Session Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../users.php">Home</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($session_name); ?></li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h1><?php echo htmlspecialchars($session_name); ?></h1>
                    <p>Day: <?php echo htmlspecialchars($day); ?></p>
                    <p>Start Time: <?php echo htmlspecialchars($start_time); ?></p>
                    <p>End Time: <?php echo htmlspecialchars($end_time); ?></p>
                    <h2>Uploaded Audios</h2>
                    <?php if (count($audio_files) > 0) : ?>
                        <ul>
                            <?php foreach ($audio_files as $file) : ?>
                                <li>
                                    <p>Recorder: <?php echo htmlspecialchars($file['username']); ?></p>
                                    <audio controls>
                                        <source src="radio/<?php echo htmlspecialchars($file['audio_file_path']); ?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>No audios found for this session.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>
