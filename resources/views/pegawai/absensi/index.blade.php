@extends('layouts.app', ['activePage' => 'riwayat-absensi'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4 shadow-custom-eabsensi">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="text-white text-capitalize ps-3 d-none d-lg-block">Riwayat Absensi</h2>
                            <h6 class="text-white text-capitalize ps-3 d-block d-lg-none">Riwayat Absensi</h6>
                            <form method="GET" action="{{ route('absensi.index') }}" class="mb-0 px-3">
                            <div class="input-group input-group-outline @if($search) is-filled @endif"
                                style="background-color: white;">
                                <label class="form-label">Cari</label>
                                <input type="text" class="form-control" name="search" value="{{ $search }}">
                                <span class="input-group-text"><i class="material-icons">search</i></span>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

            <div class="table-responsive shadow-custom-eabsensi p-0" >
                <table class="table table-striped align-items-center mb-0">
                    <thead>
                        <tr class="bg-custom-purple-light">
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-4">Tanggal</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Jam Masuk</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Jam Pulang</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Status Hadir</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Status Persetujuan</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2 pe-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatAbsensi as $absensi)
                            <tr>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color ps-4">{{ $absensi->tanggal->format('d M Y') }}</p>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</p>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</p>
                                </td>
                                <td>
                                    @if($absensi->status_kehadiran == 'H')
                                        <span class="badge badge-sm bg-gradient-success">Hadir</span>
                                    @elseif($absensi->status_kehadiran == 'T')
                                        <span class="badge badge-sm bg-gradient-warning">Terlambat</span>
                                    @elseif($absensi->status_kehadiran == 'S')
                                        <span class="badge badge-sm bg-gradient-info">Sakit</span>
                                    @elseif($absensi->status_kehadiran == 'I')
                                        <span class="badge badge-sm bg-gradient-secondary">Izin</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-danger">{{ $absensi->status_kehadiran }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absensi->status_persetujuan == 'Approved')
                                        <span class="badge badge-sm bg-gradient-success">Disetujui</span>
                                    @elseif($absensi->status_persetujuan == 'Pending')
                                        <span class="badge badge-sm bg-gradient-warning">Ditunda</span>
                                    @elseif($absensi->status_persetujuan == 'Rejected')
                                        <span class="badge badge-sm bg-gradient-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $absensi->keterangan ?? '-' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary text-sm p-4">
                                    Belum ada data riwayat absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $riwayatAbsensi->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>
@endsection