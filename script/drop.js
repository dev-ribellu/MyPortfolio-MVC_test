document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const imageUpload = document.getElementById('image-upload');
    const preview = document.getElementById('preview');

    console.log("drop.js chargé");

    if(dropZone && imageUpload && preview) {
        dropZone.addEventListener('click', () => {
            imageUpload.click();
        });
        imageUpload.addEventListener('change', () => {
            if (imageUpload.files.length) {
                updatePreview(imageUpload.files[0], preview);
            }
        });
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            console.log("Fichier déposé :", e.dataTransfer.files);
            if (e.dataTransfer.files.length) {
                imageUpload.files = e.dataTransfer.files;
                updatePreview(e.dataTransfer.files[0], preview);
            }
        });
    }

    function updatePreview(file, previewElement) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewElement.src = e.target.result;
            previewElement.style.display = 'block';
            console.log("Image mise à jour pour prévisualisation.");
        };
        reader.readAsDataURL(file);
    }
});