<?php

namespace App\Services\Reports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TabularExport implements FromArray, WithHeadings, WithTitle
{
    public function __construct(
        protected string $title,
        protected array $columns,
        protected array $rows,
    ) {}

    public function headings(): array
    {
        return $this->columns;
    }

    public function array(): array
    {
        return array_map(function ($r) {
            $r = (array) $r;
            $line = [];
            foreach ($this->columns as $c) {
                $v = $r[$c] ?? '';
                $line[] = is_scalar($v) || $v === null ? $v : json_encode($v);
            }
            return $line;
        }, $this->rows);
    }

    public function title(): string
    {
        return mb_substr($this->title, 0, 31);
    }
}
