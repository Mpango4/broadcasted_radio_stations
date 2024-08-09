// admin.js
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');

    // Initially hide the sidebar
    sidebar.style.display = 'none';

    // Toggle the sidebar when the toggle button is clicked
    sidebarToggle.addEventListener('click', function() {
        if (sidebar.style.display === 'none') {
            sidebar.style.display = 'block';
        } else {
            sidebar.style.display = 'none';
        }
    });
});
