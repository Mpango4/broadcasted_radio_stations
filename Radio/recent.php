
    
<!-- <h3>${//file.session_name}</h3> -->
<div class="card">
    <div class="card-body pb-0">
       
        <div class="news" id="audio-list">
            <!-- Audio items will be appended here by JavaScript -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch the audio files
        $.ajax({
            url: 'fetch_audio_files.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var audioFiles = response.data;
                    var audioList = $('#audio-list');

                    audioFiles.forEach(function(file) {
                        var audioItem = `
                            <div class="post-item clearfix">
                                <div class="session">
                                    
                                    <p>Radio Station: ${file.station_name}</p>
                                    <audio controls>
                                        <source src="${file.audio_file_path}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                        `;
                        audioList.append(audioItem);
                    });
                } else {
                    $('#audio-list').append('<p>No audio files found.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching audio files:', xhr.responseText);
            }
        });
    });
</script>
