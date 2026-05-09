/**
 * Companion behaviour for the original-template sidebar.
 *
 * The bundled admin script (public/assets/backend/assets/js/app.js) already
 * wires up:
 *   - mobile-toggle-icon / toggle-icon -> .wrapper.toggled
 *   - .nav-toggle-icon (overlay) click
 *   - metismenu plugin on #menu (handles has-arrow expansion)
 *   - mm-active auto-applied based on the current URL
 *
 * This module only adds what the original script doesn't:
 *   - Back-to-top button visibility + smooth scroll.
 */
export function initSidebar() {
    const backTop = document.querySelector('.back-to-top');
    if (!backTop) return;

    const onScroll = () => {
        backTop.classList.toggle('show', window.scrollY > 200);
    };
    window.addEventListener('scroll', onScroll);
    onScroll();

    backTop.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}
