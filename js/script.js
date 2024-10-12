document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('toggleBtn');
    const sidebar = document.querySelector('.sidebar');
    const contentContainer = document.getElementById('dashboard_content_container');
    const userImage = document.getElementById('userImage');
    const userName = document.getElementById('userName');
    let isCollapsed = false;

    sidebarToggle.addEventListener('click', (event) => {
        event.preventDefault();

        if (!isCollapsed) {
            sidebar.style.width = '10%';
            contentContainer.style.width = '90%';
            userImage.style.display = 'none'; // Hide user image
            userName.style.display = 'none'; // Hide user name
            document.querySelectorAll('.menuText').forEach(text => text.style.display = 'none');
        } else {
            sidebar.style.width = '20%';
            contentContainer.style.width = '80%';
            userImage.style.display = 'block'; // Show user image
            userName.style.display = 'block'; // Show user name
            document.querySelectorAll('.menuText').forEach(text => text.style.display = 'inline-block');
        }

        isCollapsed = !isCollapsed;
    });

    // Dropdown functionality
    const dropdownToggles = document.querySelectorAll('.menu-link');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
            event.preventDefault();
            const submenu = this.nextElementSibling;

            // Toggle submenu
            if (submenu.style.display === 'block') {
                submenu.style.display = 'none';
            } else {
                submenu.style.display = 'block';
            }
        });
    });
});
