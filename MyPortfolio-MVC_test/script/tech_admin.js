document.addEventListener('DOMContentLoaded', () => {
  const submitTechBtn = document.getElementById('submit-tech-btn');
  const techNameInput = document.getElementById('tech_name');
  const resultDiv = document.getElementById('tech-result');

  if (submitTechBtn) {
    submitTechBtn.addEventListener('click', () => {
      const techName = techNameInput.value.trim();
      if (techName === '') {
        resultDiv.textContent = "Veuillez saisir un nom.";
        return;
      }
      // Envoie AJAX vers add_technology.php
      fetch('controler/add_technology.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'tech_name=' + encodeURIComponent(techName)
      })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          resultDiv.textContent = data.error;
        } else if (data.success) {
          resultDiv.textContent = "Technologie ajoutée avec succès !";
          // Recharge la page pour mettre à jour l'affichage des technologies
          window.location.reload();
        }
      })
      .catch(error => {
        resultDiv.textContent = "Erreur : " + error;
      });
    });
  }
});