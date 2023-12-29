// Function to update the height of div elements based on their width
function updateDivHeight() {
  // Select all div elements with the class 'carousel-item'
  const customCarDivs = document.querySelectorAll('.carousel-item');

  // Loop through each div and update its height
  customCarDivs.forEach(function(div) {
    // Check if the div has the class 'height-70'
    const isActive = div.classList.contains('height-70');

    if (isActive) {
      // Get the inner div with class 'custom-car-carousel'
      const customCarDiv = div.querySelector('.custom-car-carousel');
      // Calculate the width of the div
      const width = customCarDiv.offsetWidth;
      // Calculate the height as 70% of the width
      const height = width * 0.7;

      // Set the height of the div
      customCarDiv.style.height = height + 'px';
    }
  });
}

// Attach event listener to the carousel for the 'slid' event
const myCarousel = document.getElementById('carouselExampleControls');
myCarousel.addEventListener('slid.bs.carousel', function() {
  // Call the function to update div heights when the carousel slides
  updateDivHeight();
});

// Update the height of divs on initial load and upon window resizing
window.addEventListener('load', function() {
  updateDivHeight();
});

window.addEventListener('resize', function() {
  updateDivHeight();
});