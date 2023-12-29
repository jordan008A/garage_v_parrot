// Initialize variables to store the primary image file and an array for secondary images.
let primaryImageFile = null;
let secondaryImageFiles = [];

// Set up the environment after the DOM content is loaded.
document.addEventListener('DOMContentLoaded', function () {
  // Configure drop zones for single (primary) and multiple (secondary) image uploads.
  setupDropZone('dropZoneSingle', 'primaryImageCarInput', true);
  setupDropZone('dropZoneMultiple', 'imagesCarInput', false);

  // Function to set up a drop zone for image uploads.
  function setupDropZone(dropZoneId, inputId, isPrimary) {
    let dropZone = document.getElementById(dropZoneId);
    // Adding event listeners for drag and drop and click actions.
    dropZone.addEventListener('dragover', dragOverHandler);
    dropZone.addEventListener('dragleave', dragLeaveHandler);
    dropZone.addEventListener('drop', e => dropHandler(e, inputId, isPrimary));
    dropZone.addEventListener('click', () => clickHandler(inputId, isPrimary));
  }

  // Handles the drag over event and adds hover styling.
  function dragOverHandler(e) {
    e.preventDefault();
    e.currentTarget.classList.add('hover');
  }

  // Handles the drag leave event and removes hover styling.
  function dragLeaveHandler(e) {
    e.currentTarget.classList.remove('hover');
  }

  // Handles dropping of files and removes hover styling.
  function dropHandler(e, inputId, isPrimary) {
    e.preventDefault();
    e.currentTarget.classList.remove('hover');
    let files = e.dataTransfer.files;
    handleFiles(files, inputId, isPrimary);
  }

  // Handles click event and triggers file input for selection.
  function clickHandler(inputId, isPrimary) {
    let input = document.getElementById(inputId);
    input.click();
    input.onchange = () => {
      if (isPrimary) {
        primaryImageFile = input.files[0];
        createImagePreview(primaryImageFile, 'imageCarPreview');
      } else {
        Array.from(input.files).forEach(file => {
          if (secondaryImageFiles.length < 3) {
            secondaryImageFiles.push(file);
            createImagePreview(file, 'imagesCarPreview');
          }
        });
        updateSecondaryInputFiles();
      }
    };
  }

  // Updates the file list for secondary images.
  function updateSecondaryInputFiles() {
    let dataTransfer = new DataTransfer();
    secondaryImageFiles.forEach(file => dataTransfer.items.add(file));
    document.getElementById('imagesCarInput').files = dataTransfer.files;
  }

  // Processes dropped or selected files and updates the UI.
  function handleFiles(files, inputId, isPrimary) {
    let containerId = isPrimary ? 'imageCarPreview' : 'imagesCarPreview';
    if (isPrimary) {
      primaryImageFile = files[0];
      document.getElementById(containerId).innerHTML = '';
      createImagePreview(primaryImageFile, containerId);
    } else {
      Array.from(files).forEach(file => {
        if (secondaryImageFiles.length < 3) {
          secondaryImageFiles.push(file);
          createImagePreview(file, containerId);
        }
      });
      updateSecondaryInputFiles();
    }
  }

  // Creates a preview of the image.
  function createImagePreview(file, containerId) {
    let reader = new FileReader();
    reader.onload = function (e) {
      let imgContainer = document.createElement('div');
      imgContainer.classList.add('img-container');
      let img = document.createElement('img');
      img.src = e.target.result;
      img.classList.add('img-preview');
      let deleteBtn = createDeleteButton(file, containerId === 'imageCarPreview');
      imgContainer.appendChild(img);
      imgContainer.appendChild(deleteBtn);
      document.getElementById(containerId).appendChild(imgContainer);
    };
    reader.readAsDataURL(file);
  }

  // Creates a delete button for an image preview.
  function createDeleteButton(file, isPrimary) {
    let btn = document.createElement('button');
    btn.innerHTML = '❌';
    btn.classList.add('cross-btn');
    btn.onclick = function () {
      if (isPrimary) {
        primaryImageFile = null;
      } else {
        secondaryImageFiles = secondaryImageFiles.filter(f => f !== file);
        updateSecondaryInputFiles();
      }
      this.parentElement.remove();
    };
    return btn;
  }
});

// Handle changes to the primary image input.
document.getElementById('primaryImageCarInput').onchange = function() {
  handleFiles(this.files, 'primaryImageCarInput', true);
};