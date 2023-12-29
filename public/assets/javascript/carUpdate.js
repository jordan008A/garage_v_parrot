// Select all elements with the class 'cross-btn' and add a click event listener to each
document.querySelectorAll('.cross-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    // Retrieve the image ID stored in the 'data-image-id' attribute of the clicked button
    var imageId = this.getAttribute('data-image-id');
    // Get the input element that stores IDs of deleted images
    var deletedImagesInput = document.getElementById('deletedImages');
    // Convert the value of this input into an array or initialize an empty array if no value
    var deletedImages = deletedImagesInput.value ? deletedImagesInput.value.split(',') : [];

    // Add the current image ID to the array of deleted images
    deletedImages.push(imageId);
    // Update the input's value with the new array of deleted image IDs, joined by commas
    deletedImagesInput.value = deletedImages.join(',');

    // Remove the parent element of the clicked button (removes the image from the UI)
    this.parentElement.remove();
  });
});