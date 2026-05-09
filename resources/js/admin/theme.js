/**
 * Theme switcher: light / dark / semi-dark / minimal + 8 header colors.
 * Matches the theme CSS shipped under public/assets/backend/assets/css/:
 *   <html class="minimal-theme | dark-theme | semi-dark | light-theme">
 *   <html class="headercolor1 ... headercolor8">
 * Preferences persist via localStorage so they survive across sessions.
 */
const HTML = document.documentElement;
const MODE_KEY = 'sams.themeMode';
const COLOR_KEY = 'sams.headerColor';
const MODE_CLASSES = ['minimal-theme', 'dark-theme', 'semi-dark', 'light-theme'];
const COLOR_CLASSES = Array.from({ length: 8 }, (_, i) => `headercolor${i + 1}`);

function applyMode(mode) {
    MODE_CLASSES.forEach(cls => HTML.classList.remove(cls));
    HTML.classList.add(mode === 'minimal' ? 'minimal-theme' : `${mode}-theme`);
    const radio = document.querySelector(`.js-theme-mode[value="${mode}"]`);
    if (radio) radio.checked = true;
}

function applyColor(color) {
    COLOR_CLASSES.forEach(cls => HTML.classList.remove(cls));
    HTML.classList.toggle('color-header', !!color);
    if (color) HTML.classList.add(color);
}

export function initTheme() {
    const savedMode = localStorage.getItem(MODE_KEY) || 'minimal';
    const savedColor = localStorage.getItem(COLOR_KEY) || '';
    applyMode(savedMode);
    applyColor(savedColor);

    document.querySelectorAll('.js-theme-mode').forEach(input => {
        input.addEventListener('change', () => {
            const mode = input.value;
            localStorage.setItem(MODE_KEY, mode);
            applyMode(mode);
        });
    });

    document.querySelectorAll('.js-header-color').forEach(el => {
        el.addEventListener('click', () => {
            const color = el.dataset.color;
            localStorage.setItem(COLOR_KEY, color);
            applyColor(color);
        });
    });
}
