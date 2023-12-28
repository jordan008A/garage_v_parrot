function updateImageHeight() {
  const images = document.querySelectorAll('.dynamic-height');
  
  images.forEach(image => {
    if (image.complete) {
      image.style.height = (image.offsetWidth * 0.7) + 'px';
    } else {
      image.onload = () => {
        image.style.height = (image.offsetWidth * 0.7) + 'px';
      };
    }
  });
}

window.addEventListener('load', () => {
  updateImageHeight();
});
window.addEventListener('resize', () => {
  updateImageHeight();
});