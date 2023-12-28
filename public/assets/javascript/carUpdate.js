document.querySelectorAll('.cross-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var imageId = this.getAttribute('data-image-id');
    var deletedImagesInput = document.getElementById('deletedImages');
    var deletedImages = deletedImagesInput.value ? deletedImagesInput.value.split(',') : [];

    deletedImages.push(imageId);
    deletedImagesInput.value = deletedImages.join(',');

    this.parentElement.remove();
  });
});
