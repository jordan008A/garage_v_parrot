// IIFE for map
(function () {
  let setting = {
    "query": "1 Allée Gabriel Biénès, Toulouse, France",
    "width": 300,
    "height": 200,
    "satellite": false,
    "zoom": 18,
    "placeId": "ChIJDVsvDIW7rhIR2zL7KlVw--4",
    "cid": "0xeefb70552afb32db",
    "coords": [43.5821047, 1.4358032],
    "lang": "fr",
    "queryString": "1 Allée Gabriel Biénès, Toulouse, France",
    "centerCoord": [43.5821047, 1.4358032],
    "id": "map-9cd199b9cc5410cd3b1ad21cab2e54d3",
    "embed_id": "1040941"
  };
  let d = document;
  let s = d.createElement('script');
  s.src = 'https://1map.com/js/script-for-user.js?embed_id=1040941';
  s.async = true;
  s.onload = function (e) {
    window.OneMap.initMap(setting)
  };
  let to = d.getElementsByTagName('script')[0];
  to.parentNode.insertBefore(s, to);
})();

// Save the value of the rating and managing the .active class
document.addEventListener('DOMContentLoaded', function () {
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
});

// Maximum character limit for the comment textarea on form review
  const commentTextAreaReview = document.getElementById('areaReview');
  const lengthValueReview = document.getElementById('lengthValueReview');
  
  commentTextAreaReview.addEventListener('input', function() {
    const textLengthReview = this.value.length;
    lengthValueReview.textContent = textLengthReview + ' / 175 caractères';
    
    if (textLengthReview > 175) {
      this.value = this.value.substring(0, 175);
      lengthValueReview.textContent = '175 / 175 caractères';
    }
  });

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
document.addEventListener('DOMContentLoaded', function() {
  const myCarousel = document.getElementById('carouselExampleControls');
  myCarousel.addEventListener('slid.bs.carousel', function() {
    updateDivHeight();
  });
});

// Update the height on initial load and upon window resizing
window.addEventListener('load', function() {
  updateDivHeight();
});

window.addEventListener('resize', function() {
  updateDivHeight();
});



// Maximum character limit for the comment textarea on form contact
document.addEventListener('DOMContentLoaded', function () {
    const commentTextAreaContact = document.getElementById('areaContact');
    const lengthValueContact = document.getElementById('lengthValueContact');
    
    commentTextAreaContact.addEventListener('input', function() {
      const textLengthContact = this.value.length;
      lengthValueContact.textContent = textLengthContact + ' / 255 caractères';
      
      if (textLengthContact > 255) {
        this.value = this.value.substring(0, 255);
        lengthValueContact.textContent = '255 / 255 caractères';
      }
    });
});

// Script pour basculer l'affichage des filtres
const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
const filters = document.getElementById('filters');

toggleFiltersBtn.addEventListener('click', function() {
  if (filters.style.display === 'none' || filters.style.display === '') {
    filters.style.display = 'flex';
  } else {
    filters.style.display = 'none';
  }
});
