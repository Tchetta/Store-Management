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
            userImage.style.width = '30px';
            userImage.style.height = '30px';
            userName.style.display = 'none'; // Hide user name
            document.querySelectorAll('.menuText').forEach(text => text.style.display = 'none'); // Hide menu texts
        } else {
            sidebar.style.width = '20%';
            contentContainer.style.width = '80%';
            userImage.style.width = '70px';
            userImage.style.height = '70px';
            userName.style.display = 'inline-block'; // Show user name
            document.querySelectorAll('.menuText').forEach(text => text.style.display = 'inline-block'); // Show menu texts
        }

        isCollapsed = !isCollapsed;
    });
    // Assuming you have a way to identify the current page
const currentPage = window.location.pathname.split("/").pop(); // Get the current page filename
const menuItems = document.querySelectorAll('.sidebar-menu-item');

menuItems.forEach(item => {
    if (item.getAttribute('href') === currentPage) {
        item.classList.add('active'); // Add 'active' class to the current menu item
    }
});


    // Dropdown functionality for inventory and other menu items
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
            event.preventDefault();
            const dropdownMenu = this.nextElementSibling;

            // Check if the menu is visible
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
                dropdownMenu.style.display = 'none'; // Collapse the menu
            } else {
                dropdownMenu.classList.add('show');
                dropdownMenu.style.display = 'block'; // Expand the menu
            }
        });
    });
});
