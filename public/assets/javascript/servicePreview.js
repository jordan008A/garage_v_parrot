document.getElementById('imageInput').addEventListener('change', function() {
  const preview = document.getElementById('imagePreview');
  const file = this.files[0];
  const reader = new FileReader();

  reader.onload = function(event) {
    preview.innerHTML = '<img src="' + event.target.result + '" alt="Image prévisualisée">';
    preview.style.display = 'block';
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.innerHTML = '';
    preview.style.display = 'none';
  }
});
