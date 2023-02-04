require('./bootstrap');
require('trix/dist/trix');

/**
 * SIDEBAR DROPDOWN HOVER
 */
const sidebar = document.querySelector('.sidebar');
const sidebarDropdown = document.querySelector('.sidebar .dropdown');
const dropdownMenu = document.querySelector('.sidebar .dropdown .dropdown-menu');
const sidebarItems = document.querySelectorAll('.left-sidebar .sidebar-item');
const leftSidebarHover = document.querySelector('.sidebar .left-sidebar-hover');

sidebarDropdown.addEventListener('mouseover', function() {
    dropdownMenu.classList.add('show');
});
sidebarDropdown.addEventListener('mouseout', function() {
    dropdownMenu.classList.remove('show');
});
sidebar.addEventListener('mouseleave', function() {
    leftSidebarHover.style.visibility = 'visible';
    leftSidebarHover.style.transform = 'translateX(-100%)';
});
sidebarItems.forEach(sidebarItem => {
    sidebarItem.addEventListener('mouseover', function(){
        leftSidebarHover.style.visibility = 'visible';
        leftSidebarHover.style.transform = 'translateX(0)';
    });
    // mouseout won't work here coz it will close the leftSidebarHover on mouseout of its child element also
    leftSidebarHover.addEventListener('mouseleave', function(){
        leftSidebarHover.style.visibility = 'hidden';
        leftSidebarHover.style.transform = 'translateX(-100%)';
    });
});


