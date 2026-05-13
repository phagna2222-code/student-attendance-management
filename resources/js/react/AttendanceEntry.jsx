import React, { useMemo, useState } from "react";

/**
 * AttendanceEntry — interactive grid for marking attendance per student.
 * Props:
 *   sessionId: number
 *   students: [{ id, code, studentNo, nameEn, nameKh, gender }]
 *   statuses: [{ id, code, name, color, countsAsPresent, countsAsAbsent }]
 *   initial: { [studentId]: { attendance_status_id, late_minutes, teacher_note } }
 *   submitUrl: string
 *   csrfToken: string
 */
export default function AttendanceEntry({
    sessionId,
    students = [],
    statuses = [],
    initial = {},
    submitUrl,
    csrfToken,
    submissionStatus = "draft",
}) {
    const [state, setState] = useState(() => {
        const seed = {};
        students.forEach((student) => {
            seed[student.id] = initial[student.id] || {
                attendance_status_id: statuses[0]?.id,
                late_minutes: 0,
                teacher_note: "",
            };
        });
        return seed;
    });
    const [saving, setSaving] = useState(false);
    const [message, setMessage] = useState(null);
    const isLocked = submissionStatus === "locked";

    const summary = useMemo(() => {
        const result = {
            total: students.length,
            present: 0,
            absent: 0,
            pending: 0,
        };
        students.forEach((student) => {
            const selected = statuses.find(
                (status) =>
                    status.id === state[student.id]?.attendance_status_id,
            );
            if (!selected) {
                result.pending += 1;
                return;
            }
            if (selected.countsAsPresent) {
                result.present += 1;
                return;
            }
            if (selected.countsAsAbsent) {
                result.absent += 1;
                return;
            }
            result.pending += 1;
        });
        return result;
    }, [state, statuses, students]);

    const counts = useMemo(() => {
        const statusCounts = {};
        statuses.forEach((status) => {
            statusCounts[status.id] = 0;
        });
        Object.values(state).forEach((value) => {
            if (value.attendance_status_id) {
                statusCounts[value.attendance_status_id] =
                    (statusCounts[value.attendance_status_id] || 0) + 1;
            }
        });
        return statusCounts;
    }, [state, statuses]);

    const presentStatus = useMemo(
        () =>
            statuses.find((status) => status.code === "P") ||
            statuses.find((status) => status.countsAsPresent) ||
            statuses[0],
        [statuses],
    );

    const absentStatus = useMemo(
        () =>
            statuses.find((status) => status.code === "A") ||
            statuses.find((status) => status.countsAsAbsent),
        [statuses],
    );

    function setStudent(id, field, value) {
        setState((prev) => ({
            ...prev,
            [id]: { ...prev[id], [field]: value },
        }));
    }

    function setAllStudents(statusId) {
        if (!statusId) {
            return;
        }
        setState((prev) => {
            const next = { ...prev };
            students.forEach((student) => {
                next[student.id] = {
                    ...next[student.id],
                    attendance_status_id: statusId,
                };
            });
            return next;
        });
    }

    async function submit() {
        setSaving(true);
        setMessage(null);
        try {
            const res = await fetch(submitUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: JSON.stringify({ session_id: sessionId, records: state }),
            });
            const data = await res.json();
            setMessage({
                ok: res.ok,
                text: data.message || (res.ok ? "Saved" : "Failed"),
            });
            if (res.ok && window.Swal) {
                window.Swal.fire({
                    icon: "success",
                    title: data.message || "Saved",
                    timer: 1500,
                    showConfirmButton: false,
                });
            }
        } catch (e) {
            setMessage({ ok: false, text: e.message });
        } finally {
            setSaving(false);
        }
    }

    function formatGender(gender) {
        if (!gender) {
            return "—";
        }
        const normalized = gender.toLowerCase();
        if (normalized === "m" || normalized === "male") {
            return "Male";
        }
        if (normalized === "f" || normalized === "female") {
            return "Female";
        }
        return gender;
    }

    return (
        <div className="teacher-attendance-sheet">
            <div className="attendance-sheet-summary-row">
                <div className="attendance-summary-card">
                    <span className="attendance-summary-card__label">
                        Total Students
                    </span>
                    <strong>{summary.total}</strong>
                </div>
                <div className="attendance-summary-card attendance-summary-card--present">
                    <span className="attendance-summary-card__label">
                        Present
                    </span>
                    <strong>{summary.present}</strong>
                </div>
                <div className="attendance-summary-card attendance-summary-card--absent">
                    <span className="attendance-summary-card__label">
                        Absent
                    </span>
                    <strong>{summary.absent}</strong>
                </div>
                <div className="attendance-summary-card attendance-summary-card--pending">
                    <span className="attendance-summary-card__label">
                        Other / Pending
                    </span>
                    <strong>{summary.pending}</strong>
                </div>
            </div>

            <div className="attendance-actions-bar">
                <div className="attendance-status-pills">
                    {statuses.map((status) => (
                        <span
                            key={status.id}
                            className="attendance-status-pill"
                            style={{ "--status-color": status.color }}
                        >
                            <strong>{status.code}</strong>
                            <span>{counts[status.id] || 0}</span>
                        </span>
                    ))}
                </div>

                <div className="attendance-bulk-actions">
                    <button
                        type="button"
                        className="btn btn-outline-success btn-sm"
                        onClick={() => setAllStudents(presentStatus?.id)}
                        disabled={saving || isLocked || !presentStatus}
                    >
                        Mark All Present
                    </button>
                    <button
                        type="button"
                        className="btn btn-outline-danger btn-sm"
                        onClick={() => setAllStudents(absentStatus?.id)}
                        disabled={saving || isLocked || !absentStatus}
                    >
                        Mark All Absent
                    </button>
                </div>
            </div>

            <div className="table-responsive attendance-roster-wrap">
                <table className="table attendance-roster-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th rowSpan="2" style={{ width: 70 }}>
                                No.
                            </th>
                            <th rowSpan="2" style={{ width: 140 }}>
                                Student ID
                            </th>
                            <th rowSpan="2">Name in Khmer</th>
                            <th rowSpan="2">Name in Latin</th>
                            <th rowSpan="2" style={{ width: 110 }}>
                                Gender
                            </th>
                            <th
                                colSpan={statuses.length}
                                className="text-center"
                            >
                                Attendance Status
                            </th>
                            <th rowSpan="2" style={{ width: 240 }}>
                                Late / Note
                            </th>
                        </tr>
                        <tr>
                            {statuses.map((status) => (
                                <th
                                    key={status.id}
                                    className="attendance-roster-table__status-head"
                                    style={{ color: status.color }}
                                >
                                    {status.code}
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {students.map((student, index) => (
                            <tr key={student.id}>
                                <td>{index + 1}</td>
                                <td>
                                    {student.code || student.studentNo || "—"}
                                </td>
                                <td>{student.nameKh || "—"}</td>
                                <td>{student.nameEn || "—"}</td>
                                <td>{formatGender(student.gender)}</td>
                                {statuses.map((status) => {
                                    const selected =
                                        state[student.id]
                                            ?.attendance_status_id ===
                                        status.id;
                                    return (
                                        <td
                                            key={status.id}
                                            className="attendance-roster-table__mark-cell"
                                        >
                                            <button
                                                type="button"
                                                className={`attendance-mark ${selected ? "is-active" : ""}`}
                                                onClick={() =>
                                                    setStudent(
                                                        student.id,
                                                        "attendance_status_id",
                                                        status.id,
                                                    )
                                                }
                                                style={{
                                                    "--mark-color":
                                                        status.color,
                                                }}
                                                aria-label={`Mark ${student.nameEn || student.nameKh || student.code} as ${status.name}`}
                                                disabled={saving || isLocked}
                                            >
                                                {status.code}
                                            </button>
                                        </td>
                                    );
                                })}
                                <td>
                                    <div className="attendance-note-stack">
                                        <input
                                            type="number"
                                            min="0"
                                            className="form-control form-control-sm"
                                            value={
                                                state[student.id]
                                                    ?.late_minutes || 0
                                            }
                                            onChange={(event) =>
                                                setStudent(
                                                    student.id,
                                                    "late_minutes",
                                                    event.target.value,
                                                )
                                            }
                                            placeholder="Late min"
                                            disabled={saving || isLocked}
                                        />
                                        <input
                                            type="text"
                                            className="form-control form-control-sm"
                                            value={
                                                state[student.id]
                                                    ?.teacher_note || ""
                                            }
                                            onChange={(event) =>
                                                setStudent(
                                                    student.id,
                                                    "teacher_note",
                                                    event.target.value,
                                                )
                                            }
                                            placeholder="Teacher note"
                                            disabled={saving || isLocked}
                                        />
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            <div className="attendance-sheet-footer">
                {message && (
                    <div
                        className={`alert mb-0 ${message.ok ? "alert-success" : "alert-danger"}`}
                    >
                        {message.text}
                    </div>
                )}
                <button
                    type="button"
                    className="btn btn-primary attendance-submit-btn"
                    onClick={submit}
                    disabled={saving || isLocked}
                >
                    {saving
                        ? "Saving..."
                        : isLocked
                          ? "Session Locked"
                          : "Submit Attendance"}
                </button>
            </div>
        </div>
    );
}
