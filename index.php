
<?php
include("header.php");
?>

    
<main>
    <section id="sessions">
        <h2>Recent Uploaded Sessions</h2>
        <!-- Example of uploaded audio session -->
       <!-- Example of uploaded audio session -->
<div class="session">
    <h3>Session 4</h3>
    <p>Radio Station: Station Name 2</p>
    <audio controls>
        <source src="session1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <!-- Download and Comment Icons -->
    <div class="icons">
        <a href="#" class="download-icon"><i class="fas fa-download"></i></a>
        <a href="#" class="comment-icon" onclick="toggleCommentForm(this)"><i class="fas fa-comment"></i></a>
    </div>
    <!-- Comment Form (Initially hidden) -->
    <div class="comment-form" style="display: none;">
        <input type="text" placeholder="Add a comment...">
        <button onclick="submitComment(this)">Send</button>
    </div>
</div>


<!-- Example of uploaded audio session -->
<div class="session">
    <h3>Session 1</h3>
    <p>Radio Station: Station Name 1</p>
    <audio controls>
        <source src="session1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <!-- Download and Comment Icons -->
    <div class="icons">
        <a href="#" class="download-icon"><i class="fas fa-download"></i></a>
        <a href="#" class="comment-icon" onclick="toggleCommentForm(this)"><i class="fas fa-comment"></i></a>
    </div>
    <!-- Comment Form (Initially hidden) -->
    <div class="comment-form" style="display: none;">
        <input type="text" placeholder="Add a comment...">
        <button onclick="submitComment(this)">Send</button>
    </div>
</div>


<!-- Example of uploaded audio session -->
<div class="session">
    <h3>Session 1</h3>
    <p>Radio Station: Station Name 1</p>
    <audio controls>
        <source src="session1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <!-- Download and Comment Icons -->
    <div class="icons">
        <a href="#" class="download-icon"><i class="fas fa-download"></i></a>
        <a href="#" class="comment-icon" onclick="toggleCommentForm(this)"><i class="fas fa-comment"></i></a>
    </div>
    <!-- Comment Form (Initially hidden) -->
    <div class="comment-form" style="display: none;">
        <input type="text" placeholder="Add a comment...">
        <button onclick="submitComment(this)">Send</button>
    </div>
</div>


<!-- Example of uploaded audio session -->
<div class="session">
    <h3>Session 1</h3>
    <p>Radio Station: Station Name 1</p>
    <audio controls>
        <source src="session1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <!-- Download and Comment Icons -->
    <div class="icons">
        <a href="#" class="download-icon"><i class="fas fa-download"></i></a>
        <a href="#" class="comment-icon" onclick="toggleCommentForm(this)"><i class="fas fa-comment"></i></a>
    </div>
    <!-- Comment Form (Initially hidden) -->
    <div class="comment-form" style="display: none;">
        <input type="text" placeholder="Add a comment...">
        <button onclick="submitComment(this)">Send</button>
    </div>
</div>


<!-- Example of uploaded audio session -->
<div class="session">
    <h3>Session 1</h3>
    <p>Radio Station: Station Name 1</p>
    <audio controls>
        <source src="session1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <!-- Download and Comment Icons -->
    <div class="icons">
        <a href="#" class="download-icon"><i class="fas fa-download"></i></a>
        <a href="#" class="comment-icon" onclick="toggleCommentForm(this)"><i class="fas fa-comment"></i></a>
    </div>
    <!-- Comment Form (Initially hidden) -->
    <div class="comment-form" style="display: none;">
        <input type="text" placeholder="Add a comment...">
        <button onclick="submitComment(this)">Send</button>
    </div>
</div>

</section>

    
</main>

    
    <footer>
        <p>&copy; 2024 Your Radio Station</p>
    </footer>

    <script>
function searchSessions() {
    var input, filter, sessions, session, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    sessions = document.getElementById('sessions');
    session = sessions.getElementsByClassName('session');

    for (i = 0; i < session.length; i++) {
        txtValue = session[i].textContent || session[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            session[i].style.display = '';
        } else {
            session[i].style.display = 'none';
        }
    }
}


function toggleCommentForm(commentIcon) {
    var commentForm = commentIcon.parentElement.parentElement.querySelector('.comment-form');
    if (commentForm.style.display === 'none') {
        commentForm.style.display = 'block';
    } else {
        commentForm.style.display = 'none';
    }
}

function submitComment(sendButton) {
    var input = sendButton.parentElement.querySelector('input[type="text"]');
    var comment = input.value.trim();
    if (comment !== '') {
        // Code to handle comment submission (e.g., send comment to server)
        console.log('Comment:', comment);
        // Clear input field after submitting comment
        input.value = '';
    }
}

</script>

</body>
</html>
