document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('projectModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalLabels = document.getElementById('modalLabels');
    const modalFiles = document.getElementById('modalFiles');
    const modalImage = document.getElementById('modalImage');
    const fileIcon = document.getElementById('fileIcon');
    const closeModal = document.querySelector('.modal .close');

    const openModal = (card) => {
        modalTitle.textContent = card.getAttribute('data-title');
        modalDescription.textContent = card.getAttribute('data-description');
        modalLabels.textContent = card.getAttribute('data-technologies');

        const fileUrl = card.getAttribute('data-files');
        if(fileUrl) {
            // Déterminez l'extension du fichier
            const extension = fileUrl.split('.').pop().toLowerCase();
            let iconPath = "";
            // Choix de l'icône en fonction de l'extension
            switch(extension){
                case "doc":
                case "docx":
                    iconPath = "images/picto/docx.svg";
                    break;
                case "pdf":
                    iconPath = "images/picto/pdf.svg";
                    break;
                case "zip":
                    iconPath = "images/picto/zip.svg";
                    break;
                case "jpg":
                case "jpeg":
                case "png":
                case "gif":
                case "svg":
                case "webp":
                case "ai":
                case "psd":
                    iconPath = "images/picto/picture.svg";
                    break;
                default:
                    iconPath = "images/picto/cloud.svg";
                    break;
            }
            fileIcon.src = iconPath;
            fileIcon.style.display = 'inline-block';
            modalFiles.href = fileUrl;
            modalFiles.style.display = 'inline-block';
        } else {
            fileIcon.style.display = 'none';
            modalFiles.style.display = 'none';
        }

        const imageUrl = card.getAttribute('data-image');
        if(imageUrl) {
            modalImage.src = imageUrl;
            modalImage.style.display = 'block';
        } else {
            modalImage.style.display = 'none';
        }
        modal.style.display = 'block';
    };

    document.querySelectorAll('.project-card').forEach(card => {
        card.addEventListener('click', () => {
            openModal(card);
        });
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if(event.target === modal) {
            modal.style.display = 'none';
        }
    });
});