document.getElementById('publicReviewsForm').addEventListener('submit', function(event) {
  let ratingValue = document.getElementById('ratingValue').value;
  if (!ratingValue || ratingValue === '0') {
      alert('Veuillez attribuer une note.');
      event.preventDefault(); // Empêcher la soumission du formulaire
  }
});
// Save the value of the rating and managing the .active class
const stars = document.querySelectorAll('.rating .star');
const ratingValue = document.getElementById('ratingValue');

stars.forEach(star => {
  star.addEventListener('click', function () {
    const rating = this.getAttribute('data-rating');
    ratingValue.value = rating;

    stars.forEach(s => {
      const sRating = s.getAttribute('data-rating');
      s.classList.remove('active');
      if (sRating <= rating) {
        s.classList.add('active');
      }
    });
  });
});