import './bootstrap';

import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';

// Header dropdowns (branch picker, language switcher, user menu) rely on
// Bootstrap 5's built-in `data-bs-toggle="dropdown"` data-API which is loaded
// from public/assets/backend/assets/js/bootstrap.bundle.min.js. Bootstrap
// already coordinates open/close across multiple dropdowns and handles the
// outside-click + escape-key dismissal, so no manual JS is needed here. An
// earlier custom click handler ended up double-toggling and left the menus
// stuck closed — see https://github.com/phagna2222-code/student-attendance-management/issues

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
if ($jq !== jQuery && DataTable && jQuery.fn.dataTable) {
    $jq.fn.dataTable = jQuery.fn.dataTable;
    $jq.fn.DataTable = jQuery.fn.DataTable;
}

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
import { mountReactRoots } from './react/mount.jsx';

document.addEventListener('DOMContentLoaded', () => {
    // CSRF for jQuery AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrfToken) {
        jQuery.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
    }

    initTheme();
    initI18n();
    initDataTables();
    initDeleteHandlers();
    initFormWidgets();
    mountReactRoots();
});
