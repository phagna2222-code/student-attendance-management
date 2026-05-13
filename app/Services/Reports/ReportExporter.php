<?php

namespace App\Services\Reports;

use App\Models\GeneratedReport;
use App\Models\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;

class ReportExporter
{
    public function export(GeneratedReport $report, string $key, array $payload, string $format)
    {
        $rows    = $payload['rows'] ?? [];
        $columns = $payload['columns'] ?? (empty($rows) ? [] : array_keys((array) $rows[0]));
        $title   = $payload['title'] ?? 'Report';

        $base = 'reports/'.now()->format('Y/m').'/'.$report->report_no;

        return match ($format) {
            'pdf'   => $this->exportPdf($report, $title, $columns, $rows, $base),
            'excel' => $this->exportExcel($report, $title, $columns, $rows, $base),
            'csv'   => $this->exportCsv($report, $columns, $rows, $base),
            default => abort(400, 'Unknown format: '.$format),
        };
    }

    protected function exportPdf(GeneratedReport $report, string $title, array $columns, array $rows, string $base)
    {
        $pdf = Pdf::loadView('admin.reports.pdf', compact('title', 'columns', 'rows'));
        $path = $base.'.pdf';
        Storage::disk('public')->put($path, $pdf->output());
        $this->logExport($report, 'pdf', $path);
        return Storage::disk('public')->download($path, basename($path));
    }

    protected function exportExcel(GeneratedReport $report, string $title, array $columns, array $rows, string $base)
    {
        $path = $base.'.xlsx';
        $abs = Storage::disk('public')->path($path);
        Storage::disk('public')->makeDirectory(dirname($path));

        ExcelFacade::store(new TabularExport($title, $columns, $rows), $path, 'public', Excel::XLSX);
        $this->logExport($report, 'excel', $path);
        return Storage::disk('public')->download($path, basename($path));
    }

    protected function exportCsv(GeneratedReport $report, array $columns, array $rows, string $base)
    {
        $path = $base.'.csv';
        Storage::disk('public')->makeDirectory(dirname($path));
        $abs = Storage::disk('public')->path($path);

        $fp = fopen($abs, 'w');
        if ($fp === false) abort(500, 'Failed to write CSV');
        if ($columns) fputcsv($fp, $columns);
        foreach ($rows as $r) {
            $r = (array) $r;
            $line = [];
            foreach ($columns as $c) {
                $v = $r[$c] ?? '';
                $line[] = is_scalar($v) || $v === null ? $v : json_encode($v);
            }
            fputcsv($fp, $line);
        }
        fclose($fp);

        $this->logExport($report, 'csv', $path);
        return Storage::disk('public')->download($path, basename($path));
    }

    protected function logExport(GeneratedReport $report, string $format, string $path): void
    {
        ReportExport::create([
            'generated_report_id' => $report->id,
            'format'              => $format,
            'file_path'           => $path,
            'exported_by'         => auth()->id(),
            'exported_at'         => now(),
        ]);
    }
}
