/**
 * Server-side Yajra DataTables bootstrapper.
 *
 * Usage in a blade:
 *   <table class="table table-striped js-datatable"
 *          data-source="{{ route('admin.branches.datatable') }}"
 *          data-columns='[
 *            { "data": "id", "name": "id" },
 *            { "data": "code", "name": "code" },
 *            { "data": "name_en", "name": "name_en" },
 *            { "data": "actions", "orderable": false, "searchable": false }
 *          ]'>
 *     <thead><tr><th>ID</th><th>Code</th><th>Name</th><th>Actions</th></tr></thead>
 *   </table>
 *
 * Provides BS5 pagination (full_numbers) by default.
 */
export function initDataTables() {
    const $ = window.jQuery;
    if (!$ || !$.fn.dataTable) return;

    document.querySelectorAll('table.js-datatable').forEach(t => {
        if (t.dataset.dtInitialized === '1') return;
        t.dataset.dtInitialized = '1';
        const $t = $(t);
        const url = t.dataset.source;
        const columns = JSON.parse(t.dataset.columns || '[]');
        const order = JSON.parse(t.dataset.order || '[[0,"desc"]]');
        const pageLength = parseInt(t.dataset.pageLength || '10', 10);
        $t.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url,
                type: 'GET',
                data: (d) => {
                    // Allow custom filters from inputs marked .js-dt-filter
                    document.querySelectorAll('.js-dt-filter').forEach(input => {
                        if (input.name) d[input.name] = input.value;
                    });
                },
            },
            columns,
            order,
            pageLength,
            lengthMenu: [10, 25, 50, 100, 250],
            pagingType: 'full_numbers',
            language: window.__dtLanguage || undefined,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });
    });

    // Re-draw a table when one of its filter inputs changes
    document.querySelectorAll('.js-dt-filter').forEach(input => {
        input.addEventListener('change', () => {
            document.querySelectorAll('table.js-datatable').forEach(t => {
                $(t).DataTable().ajax.reload();
            });
        });
    });
}
