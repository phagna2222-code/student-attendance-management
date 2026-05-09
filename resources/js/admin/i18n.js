/**
 * Multi-language switcher (KH/EN) with no page refresh.
 * - Dropdown buttons with class .js-set-locale and data-locale attribute trigger switch.
 * - Server returns merged JSON for the requested locale at GET /lang/{locale}.
 * - Translations are applied to:
 *      [data-i18n] elements (text content)
 *      [data-i18n-placeholder] inputs (placeholder)
 *      [data-i18n-title] elements (title attribute)
 *      [data-i18n-html] elements (innerHTML)
 * - Active DataTable instances have their language updated and redrawn.
 */

let cache = {};
let currentLocale = document.documentElement.dataset.locale || 'en';

async function loadLocale(locale) {
    if (cache[locale]) return cache[locale];
    const r = await fetch(`/lang/${locale}`, {
        headers: { Accept: 'application/json' },
    });
    if (!r.ok) throw new Error('Failed to load locale ' + locale);
    cache[locale] = await r.json();
    return cache[locale];
}

function translate(messages, key) {
    if (!key) return null;
    if (Object.prototype.hasOwnProperty.call(messages, key)) {
        return messages[key];
    }
    // Allow dotted keys like "admin.dashboard"
    return key.split('.').reduce((acc, part) => (acc && acc[part] !== undefined ? acc[part] : null), messages);
}

function applyTranslations(messages) {
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        const v = translate(messages, key);
        if (v != null) el.textContent = v;
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
        const key = el.getAttribute('data-i18n-placeholder');
        const v = translate(messages, key);
        if (v != null) el.setAttribute('placeholder', v);
    });
    document.querySelectorAll('[data-i18n-title]').forEach(el => {
        const key = el.getAttribute('data-i18n-title');
        const v = translate(messages, key);
        if (v != null) el.setAttribute('title', v);
    });
    document.querySelectorAll('[data-i18n-html]').forEach(el => {
        const key = el.getAttribute('data-i18n-html');
        const v = translate(messages, key);
        if (v != null) el.innerHTML = v;
    });
}

function applyDataTableLocale(messages) {
    const dt = window.jQuery?.fn?.dataTable;
    if (!dt) return;
    const langTable = translate(messages, 'datatable') || {};
    document.querySelectorAll('table.dataTable').forEach(t => {
        const api = window.jQuery(t).DataTable();
        if (api && api.context && api.context[0]) {
            api.context[0].oLanguage = window.jQuery.extend(true, api.context[0].oLanguage, langTable);
            api.draw(false);
        }
    });
}

async function setLocale(locale) {
    if (!['en', 'km'].includes(locale)) return;
    try {
        const messages = await loadLocale(locale);
        currentLocale = locale;
        document.documentElement.lang = locale;
        document.documentElement.dataset.locale = locale;
        document.body.dataset.appLocale = locale;
        const label = document.getElementById('current-locale-label');
        if (label) label.textContent = locale.toUpperCase();
        applyTranslations(messages);
        applyDataTableLocale(messages);
        // persist to cookie + session for next page load
        document.cookie = `app_locale=${locale};path=/;max-age=31536000;SameSite=Lax`;
        await fetch(`/lang/${locale}/persist`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
            },
        });
        document.dispatchEvent(new CustomEvent('localeChanged', { detail: { locale, messages } }));
    } catch (e) {
        console.error(e);
    }
}

export function initI18n() {
    document.querySelectorAll('.js-set-locale').forEach(btn => {
        btn.addEventListener('click', () => setLocale(btn.dataset.locale));
    });
    // Pre-load current locale into cache
    loadLocale(currentLocale).catch(() => {});
}

export { setLocale };
