import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

function initHeaderDropdowns() {
    document.querySelectorAll('.js-header-dropdown').forEach((toggle) => {
        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            document
                .querySelectorAll('.js-header-dropdown.show')
                .forEach((openToggle) => {
                    if (openToggle !== toggle) {
                        bootstrap.Dropdown.getOrCreateInstance(openToggle).hide();
                    }
                });

            const dropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
            dropdown.toggle();
        });
    });
}

// The bundled admin theme (public/assets/backend/...) ships its own jQuery 3
// and a chain of plugins (metismenu, simplebar, perfect-scrollbar) that attach
// to it. To keep those plugins working we DO NOT overwrite window.$ when the
// theme has already loaded its jQuery; we just register DataTables on whichever
// jQuery is currently exposed.
import jQuery from 'jquery';
const $jq = window.jQuery && window.jQuery.fn ? window.jQuery : jQuery;
if (!window.jQuery) {
    window.$ = window.jQuery = jQuery;
}

import('datatables.net-bs5').then(({ default: dtFactory }) => dtFactory && dtFactory(window, $jq));
import('datatables.net-buttons-bs5').then(({ default: btnFactory }) => btnFactory && btnFactory(window, $jq));

import Swal from 'sweetalert2';
window.Swal = Swal;

import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;

import TomSelect from 'tom-select/dist/js/tom-select.complete.min.js';
window.TomSelect = TomSelect;

import { initI18n } from './admin/i18n.js';
import { initDataTables } from './admin/datatable.js';
import { initDeleteHandlers } from './admin/delete.js';
import { initFormWidgets } from './admin/form.js';
import { initTheme } from './admin/theme.js';
import { initSidebar } from './admin/sidebar.js';
import { mountReactRoots } from './react/mount.jsx';

document.addEventListener('DOMContentLoaded', () => {
    // CSRF for jQuery AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrfToken) {
        jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
    }

    initHeaderDropdowns();
    initTheme();
    initI18n();
    initSidebar();
    initDataTables();
    initDeleteHandlers();
    initFormWidgets();
    mountReactRoots();
});
