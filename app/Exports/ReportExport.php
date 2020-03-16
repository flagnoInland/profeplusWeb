<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Invoice::query();
    }
}