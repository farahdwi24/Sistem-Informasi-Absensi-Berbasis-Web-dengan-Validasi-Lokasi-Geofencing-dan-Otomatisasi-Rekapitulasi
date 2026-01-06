<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;  
use PhpOffice\PhpSpreadsheet\Style\Border; 
use PhpOffice\PhpSpreadsheet\Style\Alignment; 
use PhpOffice\PhpSpreadsheet\Style\Font;

class LaporanAbsensiPerStatusSheet implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    protected $startDate, $endDate, $daysInMonth, $month, $statusKepegawaian, $title, $year;
    
    protected $hariMinggu = [];
    protected $pegawaiCount = 0;
    protected $daysInRange = [];
    

    public function __construct($statusKepegawaian, $startDate, $endDate)
    {
        $this->statusKepegawaian = $statusKepegawaian;
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
        
        $this->daysInMonth = $this->endDate->day;
        $this->month = $this->startDate->month;
        $this->year = $this->startDate->year;
        
        $this->title = 'ABSEN ' . $statusKepegawaian;

        for ($date = $this->startDate->copy(); $date->lte($this->endDate); $date->addDay()) {
            $this->daysInRange[] = $date->day;
            
            if ($date->isSunday()) {
                $this->hariMinggu[] = $date->day;
            }
        }
    }

    public function title(): string
    {
        return $this->title;
    }

    public function view(): View
    {
        
        $pegawaiQuery = User::where('status_kepegawaian', $this->statusKepegawaian)
                            ->where('role_id', '!=', 1);
        
        $semuaPegawai = $pegawaiQuery->orderBy('nama_lengkap')->get();
        $this->pegawaiCount = $semuaPegawai->count();
        $semuaAbsensi = Attendance::whereBetween('tanggal', [$this->startDate, $this->endDate])
                                  ->get()->groupBy('pegawai_id'); 
        $pegawaiData = [];
        foreach ($semuaPegawai as $pegawai) {
            $rekapHarian = [];

            foreach ($this->daysInRange as $day) {
                $statusFinal = '';
                $tanggalCari = Carbon::create($this->startDate->year, $this->startDate->month, $day);

                if (in_array($day, $this->hariMinggu)) {
                    $statusFinal = '';
                } else {
                    $absensiHariIni = $semuaAbsensi->get($pegawai->id)
                                                  ?->firstWhere('tanggal', $tanggalCari);
                    if ($absensiHariIni) {
                        if ($absensiHariIni->status_persetujuan == 'Rejected') {
                                $statusFinal = 'A';
                            }
                        elseif ($absensiHariIni->status_persetujuan == 'Pending') {
                                $statusFinal = '';
                            }
                       else {
                                $statusAsli = $absensiHariIni->status_kehadiran;
                                if ($statusAsli == 'H') {
                                    
                                    $belumPulang = is_null($absensiHariIni->jam_pulang);
                                    $pulangCepat = false;

                                    if ($absensiHariIni->jam_pulang) {
                                        $jamPulang = Carbon::parse($absensiHariIni->jam_pulang);
                                        if ($jamPulang->format('H:i:s') < '14:00:00') {
                                            $pulangCepat = true;
                                        }
                                    }
                                    if ($belumPulang || $pulangCepat) {
                                        $statusFinal = 'PC';
                                    } else {
                                        $statusFinal = 'H';
                                    }

                                } else {
                                    $statusFinal = $statusAsli;
                                }
                            } 
                    }
                }
                $rekapHarian[$day] = $statusFinal;
            }
            $pegawaiData[] = [
                'nama' => $pegawai->nama_lengkap,
                'rekap' => $rekapHarian,
            ];
        }

        $kepalaPuskesmas = User::where('jabatan', 'Kepala Puskesmas')->first();
        $pengelolaProgram = User::where('jabatan', 'Koordinator Kepegawaian')->first();

        return view('admin.reports.excel-export', [
            'pegawaiData' => $pegawaiData,
            'daysInRange' => $this->daysInRange,
            'startDate' => $this->startDate->format('d M Y'),
            'endDate' => $this->endDate->format('d M Y'),
            'hariMinggu' => $this->hariMinggu, 
            'signatureDate' => $this->endDate->locale('id_ID')->isoFormat('D MMMM YYYY'),
            'kepalaPuskesmas' => $kepalaPuskesmas,
            'pengelolaProgram' => $pengelolaProgram,
        ]);
    }

    public function columnWidths(): array
    {
        $widths = ['A' => 5, 'B' => 50]; 
        $daysCount = count($this->daysInRange);
        for ($i = 0; $i < $daysCount; $i++) {
            $widths[Coordinate::stringFromColumnIndex(3 + $i)] = 4;
        }
        for ($i = 0; $i < 6; $i++) {
            $widths[Coordinate::stringFromColumnIndex(3 + $daysCount + $i)] = 4;
        }
        $widths[Coordinate::stringFromColumnIndex(3 + $daysCount + 6)] = 15;
        return $widths;
    }

    public function styles(Worksheet $sheet)
    {
        $daysCount = count($this->daysInRange);
        $lastRow = $sheet->getHighestDataRow();
        $colTglMulai = 'C';
        $colTglSelesai = Coordinate::stringFromColumnIndex(2 + $daysCount);
        $colJmlMulai = Coordinate::stringFromColumnIndex(3 + $daysCount);
        $colJmlSelesai = Coordinate::stringFromColumnIndex(2 + $daysCount + 6);
        $colKet = Coordinate::stringFromColumnIndex(3 + $daysCount + 6);
        $lastCol =$colKet;
        $lastDataRow = 5 + $this->pegawaiCount;

        $sheet->getStyle('A4:' . $lastCol . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getStyle('B6:B' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:' . $lastCol . '5')->getFont()->setBold(true);

        $stylePink = ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFC0CB']]];
        $styleKuning = ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFFF00']]];
        $styleHijau = ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC6E0B4']]];

        $sheet->getStyle($colTglMulai.'4:'.$colTglSelesai.'4')->applyFromArray($stylePink);
        $sheet->getStyle($colTglMulai.'5:'.$colTglSelesai.'5')->applyFromArray($styleKuning);
        $sheet->getStyle($colJmlMulai.'4:'.$colJmlSelesai.'5')->applyFromArray($styleHijau);

        $styleMerah = ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFF0000']]];
        $dayCounter = 0;
        foreach ($this->daysInRange as $day) {
            if (in_array($day, $this->hariMinggu)) {
                $col = Coordinate::stringFromColumnIndex(3 + $dayCounter);
                $sheet->getStyle($col.'5:'.$col.$lastDataRow)->applyFromArray($styleMerah);
            }
            $dayCounter++;
        }

        $sheet->mergeCells('A1:'.$lastCol.'1');
        $sheet->mergeCells('A2:'.$lastCol.'2'); 
        $sheet->mergeCells('A4:A5'); 
        $sheet->mergeCells('B4:B5');
        $sheet->mergeCells($colTglMulai.'4:'.$colTglSelesai.'4');
        $sheet->mergeCells($colJmlMulai.'4:'.$colJmlSelesai.'4'); 
        $sheet->mergeCells($colKet.'4:'.$colKet.'5');

        $startSignatureRow = $lastDataRow + 1;
        
        $styleArrayTanpaBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_NONE,
            ]
        ];
        
        $sheet->getStyle('A' . $startSignatureRow . ':' . $lastCol . $sheet->getHighestDataRow())
              ->applyFromArray($styleArrayTanpaBorder);
    }
}