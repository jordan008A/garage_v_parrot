// Script to toggle the display of filters
// Retrieve the button used to toggle filters and the filters container
const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
const filters = document.getElementById('filters');

// Add a click event listener to the toggle button
toggleFiltersBtn.addEventListener('click', function() {
  // Check the current display style of the filters
  if (filters.style.display === 'none' || filters.style.display === '') {
    // If filters are hidden or the display style is not set, show the filters
    filters.style.display = 'flex';
  } else {
    // If filters are currently shown, hide them
    filters.style.display = 'none';
  }
});