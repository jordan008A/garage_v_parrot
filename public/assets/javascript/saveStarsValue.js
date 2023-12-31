// Select all forms with the class 'reviews-form'
const forms = document.querySelectorAll('.reviews-form');

// Add a submit event listener to each form
forms.forEach(form => {
  form.addEventListener('submit', function(event) {
    // Get the rating value from the form
    let ratingValue = document.getElementById('ratingValue').value;
    // Check if the rating value is not set or is zero
    if (!ratingValue || ratingValue === '0') {
      // Show an alert if no rating is provided and prevent form submission
      alert('Veuillez attribuer une note.');
      event.preventDefault(); // Prevent the form from being submitted
    }
  });
});

// Save the value of the rating and manage the .active class on stars
const stars = document.querySelectorAll('.rating .star');
const ratingValue = document.getElementById('ratingValue');

// Add click event listeners to each star
stars.forEach(star => {
  star.addEventListener('click', function () {
    // Get the rating value from the star's data attribute
    const rating = this.getAttribute('data-rating');
    // Set the rating value in the hidden input
    ratingValue.value = rating;

    // Update the .active class on each star based on the selected rating
    stars.forEach(s => {
      const sRating = s.getAttribute('data-rating');
      s.classList.remove('active');
      if (sRating <= rating) {
        s.classList.add('active');
      }
    });
  });
});