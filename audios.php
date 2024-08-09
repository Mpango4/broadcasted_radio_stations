<?php include("check_session.php"); ?>
<?php include("include/header.php"); ?>
<?php include("include/sidebar.php"); ?>
<!-- <style>
.submit-comment {
    background-color: #007bff; /* Primary color */
    color: #fff; /* Text color */
    padding: 8px 16px; /* Padding */
    border: none; /* No border */
    border-radius: 20px; /* Rounded corners */
    cursor: pointer;
}

.submit-comment:hover {
    background-color: #0056b3; /* Darker color on hover */
}

.comment-button {
    background-color: white; /* Primary color */
    color: green; /* Text color */
    padding: 8px 16px; /* Padding */
    border: none; /* No border */
    border-radius: 20px; /* Rounded corners */
    cursor: pointer;
}

.comment-button:hover {
    background-color: #0056b3;
    color: #fff; /* Darker color on hover */
}

.comment-form-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.comment-form {
    background: white;
    padding: 20px;
    border-radius: 10px;
}

.comment-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style> -->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Audios Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../users.php">Home</a></li>
                <li class="breadcrumb-item active">Audio list</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h1>Recorded Sessions</h1>
                <div id="audio-files-container">
                    <!-- Audio files will be displayed here -->
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Function to fetch and display audio files
    function fetchAudioFiles() {
        $.ajax({
            url: 'fetch_audio_files.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const audioFiles = response.data;
                    let htmlContent = '';
                    
                    audioFiles.forEach(file => {
                        htmlContent += `
                        <div class="audio-file">
                            <p><strong>Station Name:</strong> ${file.station_name}</p>
                            <p><strong>Session Name:</strong> ${file.session_name}</p>
                            <audio controls>
                                <source src="radio/${file.audio_file_path}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <button class="comment-button" data-session="${file.session_name}" data-station="${file.station_name}"><i class="bx bxs-message-detail"></i></button>
                            <div class="comment-form-overlay" style="display: none;">
                                <div class="comment-form">
                                    <input type="text" class="comment-input" placeholder="Enter your comment">
                                    <button class="submit-comment"><i class="bx bxl-telegram"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        `;
                    });

                    $('#audio-files-container').html(htmlContent);

                    // Event binding for comment buttons and submit comment buttons
                    bindCommentEventListeners();
                } else {
                    $('#audio-files-container').html('<p>No audio files found.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Function to bind event listeners for comments
    function bindCommentEventListeners() {
        // Add event listener for comment buttons
        $('.comment-button').click(function() {
            const commentFormOverlay = $(this).siblings('.comment-form-overlay');
            commentFormOverlay.toggle(); // Toggle comment form visibility
            if (commentFormOverlay.is(':visible')) {
                commentFormOverlay.find('.comment-input').focus(); // Focus on the comment input field
            }
        });

        // Add event listener for submit comment buttons
        $('.submit-comment').click(function() {
            const commentInput = $(this).siblings('.comment-input');
            const comment = commentInput.val().trim();
            const sessionName = $(this).closest('.audio-file').find('.comment-button').data('session');
            const stationName = $(this).closest('.audio-file').find('.comment-button').data('station');

            if (comment === "") {
                alert("Comment cannot be empty.");
                return;
            }

            $.ajax({
                url: 'submit_comment.php',
                method: 'POST',
                data: {
                    session_name: sessionName,
                    station_name: stationName,
                    comment: comment
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Comment submitted successfully.");
                        commentInput.val(''); // Clear the input field
                        commentInput.closest('.comment-form-overlay').hide(); // Hide the comment form
                    } else {
                        alert("Failed to submit comment.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred.");
                }
            });
        });
    }

    // Fetch audio files on page load
    fetchAudioFiles();
});
</script>
