import React, { useEffect, useState, useMemo } from 'react';

/**
 * AttendanceEntry — interactive grid for marking attendance per student.
 * Props:
 *   sessionId: number
 *   students: [{ id, name, code }]
 *   statuses: [{ id, code, name, color }]
 *   initial: { [studentId]: { attendance_status_id, late_minutes, teacher_note } }
 *   submitUrl: string
 *   csrfToken: string
 */
export default function AttendanceEntry({ sessionId, students = [], statuses = [], initial = {}, submitUrl, csrfToken }) {
    const [state, setState] = useState(() => {
        const seed = {};
        students.forEach(s => {
            seed[s.id] = initial[s.id] || { attendance_status_id: statuses[0]?.id, late_minutes: 0, teacher_note: '' };
        });
        return seed;
    });
    const [saving, setSaving] = useState(false);
    const [message, setMessage] = useState(null);

    const counts = useMemo(() => {
        const c = {};
        statuses.forEach(s => { c[s.id] = 0; });
        Object.values(state).forEach(v => {
            if (v.attendance_status_id) c[v.attendance_status_id] = (c[v.attendance_status_id] || 0) + 1;
        });
        return c;
    }, [state, statuses]);

    function setStudent(id, field, value) {
        setState(prev => ({ ...prev, [id]: { ...prev[id], [field]: value } }));
    }

    async function submit() {
        setSaving(true);
        setMessage(null);
        try {
            const res = await fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ session_id: sessionId, records: state }),
            });
            const data = await res.json();
            setMessage({ ok: res.ok, text: data.message || (res.ok ? 'Saved' : 'Failed') });
            if (res.ok && window.Swal) {
                window.Swal.fire({ icon: 'success', title: data.message || 'Saved', timer: 1500, showConfirmButton: false });
            }
        } catch (e) {
            setMessage({ ok: false, text: e.message });
        } finally {
            setSaving(false);
        }
    }

    return (
        <div>
            <div className="d-flex flex-wrap gap-2 mb-3">
                {statuses.map(st => (
                    <span key={st.id} className="badge" style={{ backgroundColor: st.color, fontSize: '.85rem' }}>
                        {st.name}: {counts[st.id] || 0}
                    </span>
                ))}
            </div>
            <div className="table-responsive">
                <table className="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th style={{ width: 60 }}>#</th>
                            <th>Student</th>
                            <th style={{ width: 320 }}>Status</th>
                            <th style={{ width: 120 }}>Late (min)</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        {students.map((s, i) => (
                            <tr key={s.id}>
                                <td>{i + 1}</td>
                                <td>
                                    <div className="fw-semibold">{s.name}</div>
                                    <small className="text-muted">{s.code}</small>
                                </td>
                                <td>
                                    <div className="btn-group btn-group-sm flex-wrap" role="group">
                                        {statuses.map(st => (
                                            <button
                                                type="button"
                                                key={st.id}
                                                className="btn"
                                                onClick={() => setStudent(s.id, 'attendance_status_id', st.id)}
                                                style={{
                                                    backgroundColor: state[s.id]?.attendance_status_id === st.id ? st.color : 'transparent',
                                                    color: state[s.id]?.attendance_status_id === st.id ? '#fff' : st.color,
                                                    border: `1px solid ${st.color}`,
                                                    minWidth: 50,
                                                }}
                                            >
                                                {st.code}
                                            </button>
                                        ))}
                                    </div>
                                </td>
                                <td>
                                    <input
                                        type="number"
                                        min="0"
                                        className="form-control form-control-sm"
                                        value={state[s.id]?.late_minutes || 0}
                                        onChange={(e) => setStudent(s.id, 'late_minutes', e.target.value)}
                                    />
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        className="form-control form-control-sm"
                                        value={state[s.id]?.teacher_note || ''}
                                        onChange={(e) => setStudent(s.id, 'teacher_note', e.target.value)}
                                    />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            {message && <div className={`alert ${message.ok ? 'alert-success' : 'alert-danger'}`}>{message.text}</div>}
            <button type="button" className="btn btn-primary" onClick={submit} disabled={saving}>
                {saving ? 'Saving...' : 'Save attendance'}
            </button>
        </div>
    );
}
