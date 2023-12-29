// Add an event listener to the image input element for the 'change' event
document.getElementById('imageInput').addEventListener('change', function() {
  // Get the preview container element
  const preview = document.getElementById('imagePreview');
  // Retrieve the first file from the file input
  const file = this.files[0];
  // Create a new FileReader instance
  const reader = new FileReader();

  // Define the onload event handler for the FileReader
  reader.onload = function(event) {
    // Set the inner HTML of the preview container to display the selected image
    preview.innerHTML = '<img src="' + event.target.result + '" alt="Image prévisualisée">';
    // Make the preview container visible
    preview.style.display = 'block';
  };

  // Read the selected file as a data URL if a file is selected
  if (file) {
    reader.readAsDataURL(file);
  } else {
    // Clear the preview container and hide it if no file is selected
    preview.innerHTML = '';
    preview.style.display = 'none';
  }
});