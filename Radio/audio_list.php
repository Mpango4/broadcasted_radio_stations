<?php include("check_session.php"); ?>
<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>
<main id="main" class="main">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h1>Uploaded Audio Files</h1>
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
                                <div class="audio-file" data-file-id="${file.id}">
                                    <p><strong>Session Name:</strong> ${file.session_name}</p>
                                    <audio controls>
                                        <source src="${file.audio_file_path}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <form method="POST" action="delete_audio.php" onsubmit="return confirm('Are you sure you want to delete this audio file?');">
                                        <input type="hidden" name="file_id" value="${file.id}">
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                    </form>
                                </div>
                                <hr>
                            `;
                        });

                        $('#audio-files-container').html(htmlContent);
                    } else {
                        $('#audio-files-container').html('<p>No audio files found.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Fetch audio files on page load
        fetchAudioFiles();
    });
</script>
</body>
</html>
