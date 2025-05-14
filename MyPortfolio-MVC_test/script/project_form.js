document.addEventListener('DOMContentLoaded', () => {
  const projectSelect = document.getElementById('existing_project');
  const titreInput = document.getElementById('titre_projet');
  const descInput = document.getElementById('description_projet');
  const imagePreviewContainer = document.getElementById('image-preview-container');
  const projectPreview = document.getElementById('project-preview');
  const techCheckboxes = document.querySelectorAll('#tech-checkboxes input[type="checkbox"]');

  if (projectSelect) {
    projectSelect.addEventListener('change', function(){
      const projectId = this.value;
      if(projectId) {
        fetch('controler/get_project.php?project_id=' + projectId)
          .then(response => response.json())
          .then(data => {
            if (data.error) {
              console.error(data.error);
              return;
            }
            titreInput.value = data.titre || '';
            descInput.value = data.description || '';
            if (data.image_url) {
              projectPreview.src = data.image_url;
              imagePreviewContainer.style.display = 'block';
            } else {
              imagePreviewContainer.style.display = 'none';
            }
            techCheckboxes.forEach(cb => cb.checked = false);
            if(data.technologies && data.technologies.length) {
              data.technologies.forEach(id => {
                const checkbox = document.getElementById('tech_' + id);
                if(checkbox) {
                  checkbox.checked = true;
                }
              });
            }
          })
          .catch(err => console.error('Erreur AJAX:', err));
      } else {
        titreInput.value = '';
        descInput.value = '';
        imagePreviewContainer.style.display = 'none';
        techCheckboxes.forEach(cb => cb.checked = false);
      }
    });
  }
});