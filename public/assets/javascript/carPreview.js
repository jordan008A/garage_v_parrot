let primaryImageFile = null;
let secondaryImageFiles = [];

document.addEventListener('DOMContentLoaded', function () {
    setupDropZone('dropZoneSingle', 'primaryImageCarInput', true);
    setupDropZone('dropZoneMultiple', 'imagesCarInput', false);

    function setupDropZone(dropZoneId, inputId, isPrimary) {
        let dropZone = document.getElementById(dropZoneId);
        dropZone.addEventListener('dragover', dragOverHandler);
        dropZone.addEventListener('dragleave', dragLeaveHandler);
        dropZone.addEventListener('drop', e => dropHandler(e, inputId, isPrimary));
        dropZone.addEventListener('click', () => clickHandler(inputId, isPrimary));
    }

    function dragOverHandler(e) {
        e.preventDefault();
        e.currentTarget.classList.add('hover');
    }

    function dragLeaveHandler(e) {
        e.currentTarget.classList.remove('hover');
    }

    function dropHandler(e, inputId, isPrimary) {
        e.preventDefault();
        e.currentTarget.classList.remove('hover');
        let files = e.dataTransfer.files;
        handleFiles(files, inputId, isPrimary);
    }

    function clickHandler(inputId, isPrimary) {
        let input = document.getElementById(inputId);
        input.click();
        input.onchange = () => {
            if (isPrimary) {
                primaryImageFile = input.files[0];
                createImagePreview(primaryImageFile, 'imageCarPreview');
            } else {
                if (secondaryImageFiles.length < 3) {
                    Array.from(input.files).forEach(file => {
                        if (secondaryImageFiles.length < 3) {
                            secondaryImageFiles.push(file);
                            createImagePreview(file, 'imagesCarPreview');
                        }
                    });
                }
                updateSecondaryInputFiles();
            }
        };
    }

    function updateSecondaryInputFiles() {
        let dataTransfer = new DataTransfer();
        for (let file of secondaryImageFiles) {
            dataTransfer.items.add(file);
        }
        let input = document.getElementById('imagesCarInput');
        input.files = dataTransfer.files;
    }

    function handleFiles(files, inputId, isPrimary) {
        let containerId = isPrimary ? 'imageCarPreview' : 'imagesCarPreview';
        let container = document.getElementById(containerId);

        if (isPrimary) {
            primaryImageFile = files[0];
            container.innerHTML = '';
            createImagePreview(primaryImageFile, containerId);
        } else {
            for (let i = 0; i < files.length; i++) {
                if (secondaryImageFiles.length < 3) {
                    secondaryImageFiles.push(files[i]);
                    createImagePreview(files[i], containerId);
                }
            }
            updateSecondaryInputFiles();
        }
    }

    function createImagePreview(file, containerId, isPrimary) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let imgContainer = document.createElement('div');
            imgContainer.classList.add('img-container');
    
            let img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-preview');
    
            let deleteBtn = createDeleteButton(file, isPrimary); // Passer le fichier et le type
            imgContainer.appendChild(img);
            imgContainer.appendChild(deleteBtn);
    
            document.getElementById(containerId).appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    }
    
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

document.getElementById('primaryImageCarInput').onchange = function() {
    handleFiles(this.files, 'primaryImageCarInput', true);
};