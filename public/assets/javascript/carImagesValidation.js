document.getElementById('adminForm').addEventListener('submit', function(event) {
  let primaryImages = document.querySelectorAll('#imageCarPreview .img-container').length;
  let secondaryImages = document.querySelectorAll('#imagesCarPreview .img-container').length;

  let errorMessage = '';
  if (primaryImages !== 1) {
    errorMessage += 'Veuillez sélectionner une seule image principale.\n';
  }

  if (secondaryImages !== 3) {
    errorMessage += 'Veuillez sélectionner exactement trois images secondaires.\n';
  }

  if (errorMessage) {
    event.preventDefault();
    alert(errorMessage);
  }
});
