// Function to update the height of images dynamically
function updateImageHeight() {
  // Select all images with the class 'dynamic-height'
  const images = document.querySelectorAll('.dynamic-height');
  
  // Loop through each image to set its height
  images.forEach(image => {
    // Check if the image has finished loading
    if (image.complete) {
      // Set the height of the image to 70% of its width
      image.style.height = (image.offsetWidth * 0.7) + 'px';
    } else {
      // If the image has not loaded yet, set the height after it loads
      image.onload = () => {
        image.style.height = (image.offsetWidth * 0.7) + 'px';
      };
    }
  });
}

// Attach event listeners to the window for load and resize events
window.addEventListener('load', () => {
  // Update image heights when the page is fully loaded
  updateImageHeight();
});
window.addEventListener('resize', () => {
  // Update image heights when the window is resized
  updateImageHeight();
});