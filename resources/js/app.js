import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';

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

    initTheme();
    initI18n();
    initSidebar();
    initDataTables();
    initDeleteHandlers();
    initFormWidgets();
    mountReactRoots();
});
