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

document.addEventListener('DOMContentLoaded', function () {
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

// Maximum character limit for the comment textarea
  const commentTextArea = document.getElementById('area');
  const lengthValue = document.getElementById('lengthValue');
  
  commentTextArea.addEventListener('input', function() {
    const textLength = this.value.length;
    lengthValue.textContent = textLength + ' / 175 caractères';
    
    if (textLength > 175) {
      this.value = this.value.substring(0, 175);
      lengthValue.textContent = '175 / 175 caractères';
    }
  });
});




