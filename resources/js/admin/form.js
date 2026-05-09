/**
 * Auto-binds Flatpickr to .flatpickr / .flatpickr-time / .flatpickr-datetime
 * Auto-binds Tom Select to .tom-select / select.tom-select-multi
 */
import flatpickr from 'flatpickr';
import TomSelect from 'tom-select/dist/js/tom-select.complete.min.js';

export function initFormWidgets() {
    document.querySelectorAll('.flatpickr').forEach(el => {
        if (el.classList.contains('initialized')) return;
        flatpickr(el, { dateFormat: el.dataset.format || 'Y-m-d', allowInput: true });
        el.classList.add('initialized');
    });
    document.querySelectorAll('.flatpickr-datetime').forEach(el => {
        if (el.classList.contains('initialized')) return;
        flatpickr(el, { enableTime: true, dateFormat: 'Y-m-d H:i', allowInput: true });
        el.classList.add('initialized');
    });
    document.querySelectorAll('.flatpickr-time').forEach(el => {
        if (el.classList.contains('initialized')) return;
        flatpickr(el, { enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true, allowInput: true });
        el.classList.add('initialized');
    });

    document.querySelectorAll('select.tom-select, select.tom-select-multi').forEach(el => {
        if (el.classList.contains('initialized')) return;
        new TomSelect(el, {
            allowEmptyOption: true,
            create: false,
            plugins: el.classList.contains('tom-select-multi') ? ['remove_button'] : [],
        });
        el.classList.add('initialized');
    });
}
