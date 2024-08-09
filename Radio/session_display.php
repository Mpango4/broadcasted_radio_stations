
  
<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Sessions</h5>
            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Session Name</th>
                        <th scope="col">Day</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">View</th>
                    </tr>
                </thead>
                <tbody id="session-list">
                    <!-- Session items will be appended here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div><!-- End Recent radio -->
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch the session details
        $.ajax({
            url: 'fetch_sessions.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var sessions = response.data;
                    var sessionList = $('#session-list');

                    sessions.forEach(function(session, index) {
                        var sessionItem = `
                            <tr>
                                <th scope="row">${index + 1}</th>
                                <td>${session.session_name}</td>
                                <td>${session.session_day}</td>
                                <td>${session.start_time}</td>
                                <td>${session.end_time}</td>
                                <td>
                                    <a href="view_audios.php?session_id=${session.id}" class="badge bg-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        `;
                        sessionList.append(sessionItem);
                    });
                } else {
                    $('#session-list').append('<tr><td colspan="6">No sessions found.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sessions:', xhr.responseText);
            }
        });
    });
</script>
