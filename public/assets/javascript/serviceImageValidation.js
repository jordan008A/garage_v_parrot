document.getElementById('adminForm').addEventListener('submit', function(e) {
  var inputFile = document.getElementById('imageInput');
  if (!inputFile.files.length) {
      e.preventDefault();
      alert("Veuillez sélectionner une image.");
  }
});