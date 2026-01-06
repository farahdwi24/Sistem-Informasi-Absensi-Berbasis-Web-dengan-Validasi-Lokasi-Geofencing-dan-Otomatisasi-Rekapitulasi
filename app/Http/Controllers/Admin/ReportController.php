<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanAbsensiExport; 
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        //
    }

    public function exportExcel(Request $request) 
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $searchName = $request->input('search');

        if (!$startDate || !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }
        
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        if ($start->month !== $end->month) {
            $notif = [
                'title'   => 'Ekspor Gagal',
                'message' => 'Ekspor Excel hanya bisa memproses rentang tanggal di bulan yang sama.'
            ];
            return redirect()->route('dashboard')->with('error', $notif);
        }

        return Excel::download(new LaporanAbsensiExport($startDate, $endDate, $searchName), 
            'BPJS UPTD Puskesmas Soropia - ' . $start->format('F Y') . '.xlsx'
        );
    }
}