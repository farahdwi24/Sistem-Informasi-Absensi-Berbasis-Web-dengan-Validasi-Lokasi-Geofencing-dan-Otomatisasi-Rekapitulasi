@php use PhpOffice\PhpSpreadsheet\Cell\Coordinate; @endphp
<table>
    <thead>
        <tr>
            <th>DAFTAR HADIR PEGAWAI PUSKESMAS SOROPIA</th>
            </tr>
        <tr>
            <th>UPTD PUSKESMAS SOROPIA - PERIODE {{ $startDate }} s/d {{ $endDate }}</th>
        </tr>
        <tr></tr>

        <tr>
            <th>NO</th> 
            <th>NAMA PEGAWAI</th>
             <th>TANGGAL</th> 
             @for ($i = 1; $i <= count($daysInRange); $i++)
                <th>JUMLAH</th>
            @endfor
             <th></th> 
            @for ($i = 1; $i <= (5-1); $i++)
                <th></th>
            @endfor
            <th>KET.</th>
        
        <tr>
            <th></th> 
            <th></th> 
            @foreach ($daysInRange as $day)
                <th>{{ $day }}</th>
            @endforeach
            
            <th>H</th>
            <th>I</th>
            <th>S</th>
            <th>A</th>
            <th>T</th>
            <th>CT</th>
        </tr>
    </thead>
    <tbody>
                @foreach ($pegawaiData as $index => $pegawai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pegawai['nama'] }}</td>
                
                @foreach ($daysInRange as $day)
                    <td>
                        @if (in_array($day, $hariMinggu))
                            {{ '' }}
                        @else
                            {{ $pegawai['rekap'][$day] ?? '' }}
                        @endif
                    </td>
                @endforeach

                @php
                    $excelRow = $index + 6; 
                    $startCol = 'C';
                    $endCol = Coordinate::stringFromColumnIndex(2 + count($daysInRange));
                    $range = $startCol . $excelRow . ':' . $endCol . $excelRow;
                @endphp
                
                <td>{!! "=COUNTIF($range, \"H\")" !!}</td>
                <td>{!! "=COUNTIF($range, \"I\")" !!}</td>
                <td>{!! "=COUNTIF($range, \"S\")" !!}</td>
                <td>{!! "=COUNTIF($range, \"A\")" !!}</td>
                <td>{!! "=COUNTIF($range, \"T\")" !!}</td>
                <td>{!! "=COUNTIF($range, \"CT\")" !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table> 
    <tbody>
        <tr></tr> 
        <tr>
            <td></td> 
            <td colspan="5">Mengetahui,</td>
            @for ($i = 1; $i <= (count($daysInRange) - 5); $i++)
                <td></td>
            @endfor
            <td colspan="6">Soropia, {{ $signatureDate }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5">Kepala Puskesmas Soropia</td>
            @for ($i = 1; $i <= (count($daysInRange) - 5); $i++)
                <td></td>
            @endfor
            <td colspan="6">Koordinator Kepegawaian</td>
        </tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr> 
        <tr>
            <td></td>
            <td colspan="5" style="text-decoration: underline; font-weight: bold;">
                {{ $kepalaPuskesmas->nama_lengkap ?? '(Nama Kepala Puskesmas)' }}
            </td>
            @for ($i = 1; $i <= (count($daysInRange) - 5); $i++)
                <td></td>
            @endfor
            <td colspan="6" style="text-decoration: underline; font-weight: bold;">
                {{ $pengelolaProgram->nama_lengkap ?? '(Nama Koordinator Kepegawaian)' }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5">
                NIP: {{ $kepalaPuskesmas->nip ?? '(NIP Kepala Puskesmas)' }}
            </td>
            @for ($i = 1; $i <= (count($daysInRange) - 5); $i++)
                <td></td>
            @endfor
            <td colspan="6">
                NIP: {{ $pengelolaProgram->nip ?? '(NIP Koordinator Kepegawaian)' }}
            </td>
        </tr>
    </tbody>
</table>