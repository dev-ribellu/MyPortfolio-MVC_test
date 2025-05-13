// Description: JavaScript pour écriture manuscrite 
document.addEventListener('DOMContentLoaded', function() {
    const textElement = document.getElementById('ligne3');
    const texts = ['Front-end développeur ', 'Community manager ', 'Graphiste '];
    let currentTextIndex = 0;
    let currentCharIndex = 0;
    let isDeleting = false;

    function type() {
        const currentText = texts[currentTextIndex];
        if (isDeleting) {
            currentCharIndex--;
            if (currentCharIndex <= 0) {
                isDeleting = false;
                currentTextIndex = (currentTextIndex + 1) % texts.length;
            }
        } else {
            currentCharIndex++;
            if (currentCharIndex >= currentText.length) {
                isDeleting = true;
                setTimeout(type, 2000); // Pause avant de commencer à supprimer
                return;
            }
        }

        textElement.textContent = currentText.substring(0, currentCharIndex);
        setTimeout(type, isDeleting ? 50 : 100);
    }

    type();
});

// JavaScript pour l'effet de glitch
document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.getElementById('profile-image');

    function glitchEffect() {
        const translateX = Math.random() * 3 - 2; // Réduire l'effet de translation
        const translateY = Math.random() * 3 - 2; // Réduire l'effet de translation
        const clipPath = `polygon(${Math.random() * 100}% ${Math.random() * 100}%, 
                                  ${Math.random() * 100}% ${Math.random() * 100}%, 
                                  ${Math.random() * 100}% ${Math.random() * 100}%, 
                                  ${Math.random() * 100}% ${Math.random() * 100}%)`;

        profileImage.style.transform = `translate(${translateX}px, ${translateY}px)`;
        profileImage.style.clipPath = clipPath;
    }

    setInterval(glitchEffect, 500); // Applique l'effet de glitch toutes les 500ms (0.5 seconde)
});