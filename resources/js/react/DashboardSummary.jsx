import React, { useEffect, useRef } from 'react';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

export default function DashboardSummary({ stats = {}, weekly = [] }) {
    const ref = useRef(null);

    useEffect(() => {
        if (!ref.current) return;
        const ctx = ref.current.getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weekly.map(w => w.label),
                datasets: [
                    { label: 'Present', data: weekly.map(w => w.present), borderColor: '#16a34a', tension: .3 },
                    { label: 'Absent',  data: weekly.map(w => w.absent),  borderColor: '#dc2626', tension: .3 },
                    { label: 'Late',    data: weekly.map(w => w.late),    borderColor: '#f59e0b', tension: .3 },
                ],
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } },
        });
        return () => chart.destroy();
    }, [weekly]);

    return (
        <div>
            <div className="row g-3 mb-3">
                <Card title="Total Students" value={stats.students ?? '—'} icon="bi-people" color="#6366f1" />
                <Card title="Total Teachers" value={stats.teachers ?? '—'} icon="bi-person-badge" color="#0ea5e9" />
                <Card title="Branches" value={stats.branches ?? '—'} icon="bi-building" color="#16a34a" />
                <Card title="Classes" value={stats.classes ?? '—'} icon="bi-collection" color="#f59e0b" />
            </div>
            <div className="card">
                <div className="card-body">
                    <h6 className="card-title mb-3">Weekly attendance trend</h6>
                    <div style={{ height: 280 }}><canvas ref={ref}></canvas></div>
                </div>
            </div>
        </div>
    );
}

function Card({ title, value, icon, color }) {
    return (
        <div className="col-sm-6 col-xl-3">
            <div className="card h-100">
                <div className="card-body d-flex align-items-center">
                    <div className="rounded-circle d-flex align-items-center justify-content-center"
                         style={{ width: 48, height: 48, background: color + '22', color }}>
                        <i className={`bi ${icon} fs-4`}></i>
                    </div>
                    <div className="ms-3">
                        <div className="text-muted small">{title}</div>
                        <div className="h4 mb-0">{value}</div>
                    </div>
                </div>
            </div>
        </div>
    );
}
