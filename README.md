# Student Attendance Management System (SAMS)

Multi-branch Laravel 12 + React + Bootstrap 5 admin panel for school student
attendance.

## Stack

- **Backend**: Laravel 12 (PHP 8.3), SQLite (default), MySQL/PostgreSQL ready
- **Frontend**: React 19, Bootstrap 5, jQuery 3.7, DataTables 2 (Bootstrap 5
  fixed pagination, server-side via [Yajra Laravel DataTables](https://yajrabox.com/docs/laravel-datatables))
- **UX**: SweetAlert2 (confirm delete), [PHPFlasher](https://php-flasher.io/)
  SweetAlert toasts (success), Flatpickr (date/time pickers), Tom Select (select
  fields)
- **i18n**: Khmer / English with **no-refresh** switcher (DOM updates +
  DataTables redraw + cookie/session persist)

## Module map

28 separate CRUD modules following the standard pattern: `index.blade.php`,
`create.blade.php`, `edit.blade.php`, `_form.blade.php`.

| Group | Modules |
|---|---|
| School setup | Branches, School Profiles, Academic Years, Terms, Shifts, Rooms, Grade Levels, Subjects, Attendance Statuses |
| People | Users, Teachers, Parents, Students |
| Classes | Classes, Class Students, Teacher–Subject Assignments, Class Attendance Settings, Timetables |
| Attendance | Sessions, Records (bulk entry via React), Leave Requests |
| Communications | Notification Templates, Notifications |
| Security / Admin | Roles, Permissions, Audit Logs, System Settings |
| Reports | Reports |

## Setup

```bash
# 1. Install backend deps
composer install

# 2. Install frontend deps
npm install

# 3. Configure .env
cp .env.example .env
php artisan key:generate
# database is SQLite by default (database/database.sqlite)

# 4. Run migrations + seeder
php artisan migrate:fresh --seed

# 5. Build assets
npm run build      # production
# or
npm run dev        # dev server (Vite hot-reload)

# 6. Run the app
php artisan serve
```

Default admin credentials: **admin@example.com / password**
Demo teacher: **teacher@example.com / password**

## Architecture notes

- `app/Http/Controllers/Admin/ResourceController.php` — base CRUD class used by
  most modules. Subclasses define `$modelClass`, `$viewPath`, `$routePrefix` and
  `validationRules()`; override hooks `dataTableQuery()`, `buildDataTable()`,
  `extraData()`, `mapInput()` for module-specific behaviour.
- `app/Services/BranchContext.php` — session-scoped current branch + helpers to
  scope queries by `branch_id` and gate which branches a user may switch to.
- `app/Http/Middleware/SetLocale.php` — applies `app.locale` from session/cookie
  on every request.
- `app/Http/Middleware/EnsureAdminAuthenticated.php` — gates `/admin/*` to
  super_admin/school_admin/teacher/secretary/auditor user types.
- `app/Http/Controllers/LocaleController.php` — `GET /lang/{locale}` returns the
  merged JSON for client-side translations; `POST /lang/{locale}/persist`
  persists the choice.
- `resources/js/app.js` is the single Vite entry point that wires Bootstrap,
  DataTables (Bootstrap 5), SweetAlert2, Flatpickr, Tom Select, the i18n
  switcher, the React mount loop, and the navigation toggle.
- `resources/js/admin/i18n.js` swaps text in `[data-i18n]`, placeholders in
  `[data-i18n-placeholder]`, and DataTables strings without reloading.
- `resources/js/admin/datatable.js` initialises every `table.js-datatable` with
  AJAX server-side, fixed Bootstrap 5 full-numbers pagination.
- `resources/js/admin/delete.js` wires SweetAlert2 confirms to
  `.js-confirm-delete` buttons and submits the parent form on confirm.
- `resources/js/admin/form.js` auto-initialises Flatpickr (`.flatpickr`,
  `.flatpickr-datetime`, `.flatpickr-time`) and Tom Select
  (`select.tom-select`, `select.tom-select-multi`).
- `resources/js/react/mount.jsx` mounts every `[data-react]` container and
  passes `data-props` JSON as props.

## Component patterns

### List page

Uses `resources/views/admin/partials/_card_index.blade.php`, e.g.

```blade
@include('admin.partials._card_index', [
  'title'        => __('admin.branches'),
  'createUrl'    => route('admin.branches.create'),
  'datatableUrl' => route('admin.branches.datatable'),
  'columns'      => [ /* DataTables column defs */ ],
])
```

### Form pages

```blade
<x-admin.form-card :title="..." :action="route('admin.X.update', $model->id)" method="PUT" :cancel-url="route('admin.X.index')">
  @include('admin.X._form')
</x-admin.form-card>
```

`_form.blade.php` uses the field partials in `resources/views/admin/partials/`:
`_input`, `_select`, `_textarea`, `_checkbox`. These wire up Flatpickr/Tom
Select classes and old() values automatically.

### Delete

Buttons inside list rows or forms get class `js-confirm-delete`; the global
delete handler shows a SweetAlert2 confirmation and then submits the
surrounding form.

### Flash messages

`flash()->success(...)` from controllers — the @flasher_render directive
renders the SweetAlert2 toast on the next response.
