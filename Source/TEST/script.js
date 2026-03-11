document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const navbarToggler = document.querySelector('.navbar-toggler');
    const sidebarMenu = document.getElementById('sidebarMenu');
    
    if (navbarToggler && sidebarMenu) {
        navbarToggler.addEventListener('click', function() {
            sidebarMenu.classList.toggle('show');
        });
    }

    // Simulate search functionality
    const searchForm = document.getElementById('archiveSearchBtn');
    if (searchForm) {
        searchForm.addEventListener('click', function() {
            const searchTerm = document.getElementById('archiveSearch').value.toLowerCase();
            if (searchTerm.trim() === '') {
                alert('Please enter a search term');
                return;
            }
            console.log('Searching for:', searchTerm);
            alert('In a real application, this would search for: ' + searchTerm);
        });
    }

    // Simulate document actions
    document.querySelectorAll('.btn-outline-primary, .document-card').forEach(item => {
        item.addEventListener('click', function(event) {
            // Prevent the parent card click from triggering on button click
            if (event.target.tagName === 'BUTTON' || event.target.closest('button')) {
                const action = event.target.textContent.trim();
                if (action === 'View' || action === 'Process' || action === 'Review' || action === 'Respond' || action === 'Track') {
                    alert('This would open the document details in a real application.');
                } else if (action === 'Retrieve') {
                    alert('This would retrieve the archived document.');
                }
            } else {
                // Handle the card click itself
                alert('This would open the document details in a real application.');
            }
        });
    });

    // Simulate user management actions
    document.querySelectorAll('.btn-outline-danger').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.textContent.trim() === 'Deactivate') {
                if (confirm('Are you sure you want to deactivate this user?')) {
                    alert('User would be deactivated in a real application.');
                }
            }
        });
    });
});