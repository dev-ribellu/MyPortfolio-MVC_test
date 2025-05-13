document.getElementById('add-competence').addEventListener('click', function() {
    const competenceList = document.getElementById('competence-list');
    const newRow = document.createElement('div');
    newRow.className = 'form-group d-flex align-items-center mb-2';
    newRow.innerHTML = `
      <input type="text" name="competence_name[]" class="form-control me-2" placeholder="Nom de la compétence">
      <select name="competence_level[]" class="form-select me-2">
        <option value="Expert">Expert</option>
        <option value="Avancé">Avancé</option>
        <option value="Intérmédiaire">Intérmédiaire</option>
      </select>
      <button type="button" class="btn btn-danger btn-sm remove-competence">Supprimer</button>
    `;
    competenceList.appendChild(newRow);
  });
document.addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('remove-competence')) {
      e.target.parentElement.remove();
    }
  });