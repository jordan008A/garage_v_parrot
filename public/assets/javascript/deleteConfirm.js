// Listen for the DOMContentLoaded event to ensure the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Select all elements with the class 'btn-delete'
    const deleteButtons = document.querySelectorAll('.delete');
  
    // Iterate over each button and attach a click event listener
    deleteButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        // Display a confirmation dialog when the button is clicked
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
          // If the user does not confirm, prevent the default action (e.g., form submission)
          event.preventDefault();
        }
      });
    });
  });