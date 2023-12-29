// Add a submit event listener to the form with the ID 'adminForm'
document.getElementById('adminForm').addEventListener('submit', function(event) {
  // Count the number of primary and secondary images selected
  let primaryImages = document.querySelectorAll('#imageCarPreview .img-container').length;
  let secondaryImages = document.querySelectorAll('#imagesCarPreview .img-container').length;

  // Initialize a string to hold any error messages
  let errorMessage = '';

  // Check if exactly one primary image is selected, if not, add an error message
  if (primaryImages !== 1) {
    errorMessage += 'Veuillez sélectionner une seule image principale.\n';
  }

  // Check if exactly three secondary images are selected, if not, add an error message
  if (secondaryImages !== 3) {
    errorMessage += 'Veuillez sélectionner exactement trois images secondaires.\n';
  }

  // If there are any error messages, prevent the form from submitting and show the errors
  if (errorMessage) {
    event.preventDefault();
    alert(errorMessage);
  }
});