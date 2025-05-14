document.addEventListener('DOMContentLoaded', function() {
    const skillLevels = document.querySelectorAll('.skill_level');

    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function animateSkills() {
        skillLevels.forEach(skill => {
            if (isElementInViewport(skill)) {
                const targetWidth = skill.getAttribute('data-skill') + '%';
                skill.style.width = targetWidth;
            }
        });
    }

    window.addEventListener('scroll', animateSkills);
    window.addEventListener('resize', animateSkills);
    animateSkills(); // Initial check
});