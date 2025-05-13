window.addEventListener('scroll', function() {
  const sections = document.querySelectorAll('.border-change');
  sections.forEach(function(section) {
    const rect = section.getBoundingClientRect();
    const sectionHeight = rect.height;
    const visiblePart = Math.min(window.innerHeight, rect.bottom) - Math.max(0, rect.top);
    let ratio = visiblePart / sectionHeight;
    ratio = Math.max(0, Math.min(ratio, 1)); // Contrainte entre 0 et 1
    section.style.borderColor = `rgba(255, 255, 255, ${ratio})`;
  });
});

document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section');
    
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.style.transform = 'scale(1)';
                entry.target.style.opacity = '1';
            } else {
                entry.target.style.transform = 'scale(0.5)';
                entry.target.style.opacity = '0';
            }
        });
    }, { threshold: 0.25 ,
        rootMargin: '20px 0px 0px 0px' // Ajuste la marge inférieure pour le déclenchement
    }); // L'animation démarre quand 50% de l'élément est visible

    
    sections.forEach(section => {
        observer.observe(section);
    });
});