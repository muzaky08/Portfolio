document.addEventListener('DOMContentLoaded', () => {
    const storageKey = 'portfolio-theme';
    const toggle = document.querySelector('[data-theme-toggle]');
    const icon = toggle ? toggle.querySelector('i') : null;

    const applyTheme = (theme) => {
        document.documentElement.setAttribute('data-bs-theme', theme);
        if (! icon) {
            return;
        }
        if (theme === 'dark') {
            icon.classList.remove('bi-moon-stars');
            icon.classList.add('bi-sun');
        } else {
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon-stars');
        }
    };

    if (toggle) {
        toggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem(storageKey, nextTheme);
            applyTheme(nextTheme);
        });
    }

    applyTheme(document.documentElement.getAttribute('data-bs-theme') || 'light');
});

