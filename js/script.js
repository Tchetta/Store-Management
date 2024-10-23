// Move the toggleSubMenu function outside of the DOMContentLoaded event listener
function toggleSubMenu(subMenuId) {
    const subMenu = document.getElementById(subMenuId);

    // Toggle the display of the submenu
    if (subMenu.style.display === 'none' || subMenu.style.display === '') {
        subMenu.style.display = 'block'; // Show the submenu if it's currently hidden
    } else {
        subMenu.style.display = 'none'; // Hide the submenu if it's currently visible
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('toggleBtn');
    const sidebar = document.querySelector('.sidebar');
    const contentContainer = document.getElementById('dashboard_content_container');
    const userImage = document.getElementById('userImage');
    const userName = document.getElementById('userName');
    let isCollapsed = false;

    sidebarToggle.addEventListener('click', (event) => {
        event.preventDefault();

        // Collapse or expand the sidebar
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

    // Add event listeners for submenu toggles
    const submenuToggles = document.querySelectorAll('.submenu-toggle'); // Assume you add 'submenu-toggle' class to parent items

    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            const subMenuId = toggle.getAttribute('data-submenu'); // Get submenu ID from a data attribute
            toggleSubMenu(subMenuId);
        });
    });
});

// Message box
function closeMessage(element) {
    const messageBox = element.parentElement;
    messageBox.style.opacity = '0'; // Fade out
    setTimeout(() => messageBox.style.display = 'none', 300); // Hide after fading out
}
