/**
 * Generic SweetAlert2 confirm-delete wiring.
 *
 * Usage 1 (form submit):
 *   <form action="..." method="POST" class="d-inline">
 *      @csrf @method('DELETE')
 *      <button type="submit" class="btn btn-sm btn-danger js-confirm-delete">Delete</button>
 *   </form>
 *
 * Usage 2 (link with data-action):
 *   <a href="#" class="js-confirm-delete" data-action="..."
 *      data-method="DELETE">Delete</a>
 *
 * The data-confirm-* attributes optionally override the SweetAlert text.
 */
import Swal from 'sweetalert2';

function tr(key, fallback) {
    const dataset = document.documentElement.dataset;
    if (dataset.locale === 'km') {
        const map = {
            'confirm.title': 'តើអ្នកប្រាកដឬ?',
            'confirm.text': 'អ្នកនឹងមិនអាចត្រឡប់មកវិញបានទេ!',
            'confirm.yes': 'បាទ! លុបវា',
            'confirm.no': 'បោះបង់',
        };
        return map[key] || fallback;
    }
    return fallback;
}

export function initDeleteHandlers() {
    document.addEventListener('click', (e) => {
        const target = e.target.closest('.js-confirm-delete');
        if (!target) return;
        e.preventDefault();
        const title = target.dataset.confirmTitle || tr('confirm.title', 'Are you sure?');
        const text = target.dataset.confirmText || tr('confirm.text', "You won't be able to revert this!");
        const yes = target.dataset.confirmYes || tr('confirm.yes', 'Yes, delete it!');
        const no = target.dataset.confirmNo || tr('confirm.no', 'Cancel');

        Swal.fire({
            title,
            text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: yes,
            cancelButtonText: no,
        }).then((result) => {
            if (!result.isConfirmed) return;

            // Form submit usage
            const form = target.closest('form');
            if (form) {
                form.submit();
                return;
            }

            // Link usage
            const action = target.dataset.action;
            const method = (target.dataset.method || 'DELETE').toUpperCase();
            if (!action) return;

            const f = document.createElement('form');
            f.method = 'POST';
            f.action = action;
            f.style.display = 'none';
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
            f.appendChild(csrf);
            if (method !== 'POST') {
                const m = document.createElement('input');
                m.type = 'hidden';
                m.name = '_method';
                m.value = method;
                f.appendChild(m);
            }
            document.body.appendChild(f);
            f.submit();
        });
    });
}
