<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploaded Audio Files</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-body pb-0">
            <h5 class="card-title">Recent Uploaded Sessions</h5>
            <div class="news" id="audio-files-container">
                <!-- Audio items will be appended here by JavaScript -->
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    function fetchAudioFiles() {
        $.ajax({
            url: 'fetch_audio_file.php',
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
                        commentInput.closest('.comment-form-overlay').hide();
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

    fetchAudioFiles();
});

</script>
</body>
</html>
