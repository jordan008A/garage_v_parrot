// Update height according to width
function updateImageHeight() {
  const images = document.querySelectorAll('.dynamic-height');
  
  images.forEach(function(image) {
      image.style.height = (image.offsetWidth * 0.7) + 'px';
  });
}

// Update the height on initial load and upon window resizing
window.addEventListener('load', updateImageHeight);
window.addEventListener('resize', updateImageHeight);