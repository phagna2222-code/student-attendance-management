import React from 'react';
import { createRoot } from 'react-dom/client';
import AttendanceEntry from './AttendanceEntry.jsx';
import DashboardSummary from './DashboardSummary.jsx';

const componentMap = {
    'attendance-entry': AttendanceEntry,
    'dashboard-summary': DashboardSummary,
};

export function mountReactRoots() {
    document.querySelectorAll('[data-react]').forEach(el => {
        if (el.dataset.reactMounted === '1') return;
        const name = el.dataset.react;
        const Component = componentMap[name];
        if (!Component) return;
        const props = JSON.parse(el.dataset.props || '{}');
        const root = createRoot(el);
        root.render(<Component {...props} />);
        el.dataset.reactMounted = '1';
    });
}
