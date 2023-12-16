// Update height according to width
function updateDivHeight() {
  const customCarDivs = document.querySelectorAll('.carousel-item');

  customCarDivs.forEach(function(div) {
    const isActive = div.classList.contains('height-70');

    if (isActive) {
      const customCarDiv = div.querySelector('.custom-car-carousel');
      const width = customCarDiv.offsetWidth;
      const height = width * 0.7;

      customCarDiv.style.height = height + 'px';
    }
  });
}

// Increase the height when changing slides
const myCarousel = document.getElementById('carouselExampleControls');
myCarousel.addEventListener('slid.bs.carousel', function() {
  updateDivHeight();
});

// Update the height on initial load and upon window resizing
window.addEventListener('load', function() {
  updateDivHeight();
});

window.addEventListener('resize', function() {
  updateDivHeight();
});