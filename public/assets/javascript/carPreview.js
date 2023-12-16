document.getElementById('imageCarInput').addEventListener('change', function() {
  const preview = document.getElementById('imageCarPreview');
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

document.getElementById('imagesCarInput').addEventListener('change', function() {
  const preview = document.querySelector('.images-preview');
  const files = this.files;
  const imageCount = Math.min(files.length, 3);

  if (preview.querySelectorAll('.image-container').length + imageCount > 3) {
    this.value = '';
    return;
  }

  for (let i = 0; i < imageCount; i++) {
    const file = files[i];
    const reader = new FileReader();

    reader.onload = function(event) {
      const img = document.createElement('img');
      img.src = event.target.result;
      img.alt = 'Image prévisualisée';
      img.classList.add('preview-images');
      img.classList.add('dynamic-height');

      const crossBtn = document.createElement('span');
      crossBtn.classList.add('cross-btn');
      crossBtn.textContent = '❌';

      const container = document.createElement('div');
      container.classList.add('image-container');
      container.appendChild(img);
      container.appendChild(crossBtn);
      preview.appendChild(container);

      crossBtn.addEventListener('click', function() {
        container.remove();
        document.getElementById('imageCarInput').disabled = false;
      });

      if (preview.querySelectorAll('.image-container').length === 3) {
        document.getElementById('imageCarInput').disabled = true;
      }
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  }
});
