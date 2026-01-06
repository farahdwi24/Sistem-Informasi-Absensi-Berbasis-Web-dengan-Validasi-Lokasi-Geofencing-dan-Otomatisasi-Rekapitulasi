<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets; 
use Carbon\Carbon;

class LaporanAbsensiExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;
    protected $searchName;
    public function __construct($startDate, $endDate, $searchName)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->searchName = $searchName;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        $statusKepegawaian = ['PNS', 'P3K', 'PHL'];

        foreach ($statusKepegawaian as $status) {
            $sheets[] = new LaporanAbsensiPerStatusSheet(
                $status, 
                $this->startDate,
                $this->endDate,
            );
        }

        return $sheets;
    }
}