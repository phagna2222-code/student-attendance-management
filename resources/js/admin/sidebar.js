export function initSidebar() {
    const wrapper = document.querySelector('.wrapper');
    const sidebar = document.querySelector('.sidebar-wrapper');
    const menu = window.jQuery?.fn?.metisMenu ? window.jQuery('#menu') : null;
    const mobileToggle = document.querySelector('.mobile-toggle-icon');
    const desktopToggle = document.querySelector('.toggle-icon');
    const overlayToggle = document.querySelector('.nav-toggle-icon');
    const searchToggle = document.querySelector('.search-toggle-icon');
    const searchClose = document.querySelector('.search-close-icon');
    const searchbar = document.querySelector('.top-header .searchbar');
    const backTop = document.querySelector('.back-to-top');

    if (menu && !menu.data('mm-initialized')) {
        menu.metisMenu();
        menu.data('mm-initialized', true);
    }

    const toggleSidebar = (expanded) => {
        if (!wrapper) return;
        if (expanded === undefined) {
            wrapper.classList.toggle('toggled');
            return;
        }
        wrapper.classList.toggle('toggled', expanded);
    };

    const bindDesktopHover = () => {
        if (!wrapper || !sidebar) return;
        sidebar.addEventListener('mouseenter', () => {
            if (window.innerWidth >= 1025 && wrapper.classList.contains('toggled')) {
                wrapper.classList.add('sidebar-hovered');
            }
        });

        sidebar.addEventListener('mouseleave', () => {
            wrapper.classList.remove('sidebar-hovered');
        });
    };

    const syncResponsiveState = () => {
        if (!wrapper) return;
        if (window.innerWidth < 1200) {
            wrapper.classList.remove('sidebar-hovered');
            return;
        }

        if (!wrapper.classList.contains('toggled')) {
            wrapper.classList.remove('sidebar-hovered');
        }
    };

    mobileToggle?.addEventListener('click', () => toggleSidebar(true));
    desktopToggle?.addEventListener('click', () => toggleSidebar());
    overlayToggle?.addEventListener('click', () => toggleSidebar(false));
    searchToggle?.addEventListener('click', () => searchbar?.classList.add('is-open'));
    searchClose?.addEventListener('click', () => searchbar?.classList.remove('is-open'));
    bindDesktopHover();
    window.addEventListener('resize', syncResponsiveState);
    syncResponsiveState();

    document.querySelectorAll('.header-message-list, .header-notifications-list').forEach((element) => {
        if (window.PerfectScrollbar && !element.dataset.psReady) {
            new window.PerfectScrollbar(element);
            element.dataset.psReady = '1';
        }
    });

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
