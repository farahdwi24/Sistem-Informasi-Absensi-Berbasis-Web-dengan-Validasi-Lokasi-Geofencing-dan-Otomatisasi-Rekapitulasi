@extends('layouts.app', ['activePage' => 'dashboard'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4 shadow-custom-eabsensi">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="text-white text-capitalize ps-3 d-none d-lg-block">Laporan Absensi Pegawai</h2>
                            <h6 class="text-white text-capitalize ps-3 d-block d-lg-none">Laporan Absensi</h6>
                            <a href="{{ route('admin.laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-light me-4">
                                <i class="material-icons text-sm me-2">download</i> Export
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card my-4 shadow-custom-eabsensi">
                    <div class="card-body">
                        <form method="GET" action="{{ route('dashboard') }}" class="px-4 py-3">
                            <div class="row align-items-end">
                                <div class="col-6 col-lg-2 mb-3">
                                    <div class="input-group input-group-static input-group-outline @if($startDate) is-filled @endif">
                                        <label>Dari Tanggal</label>
                                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}"
                                            style="background-color: white;">
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 mb-3">
                                    <div class="input-group input-group-static input-group-outline @if($endDate) is-filled @endif">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}"
                                            style="background-color: white;">
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 mb-3">
                                    <div class="input-group input-group-static input-group-outline">
                                        <label>Status Pegawai</label>
                                        <select class="form-control auto-submit-filter" style="background-color: white;"
                                            name="status_pegawai">
                                            <option value="">Semua</option>
                                            <option value="PNS" {{ $statusPegawai == 'PNS' ? 'selected' : '' }}>PNS</option>
                                            <option value="P3K" {{ $statusPegawai == 'P3K' ? 'selected' : '' }}>P3K</option>
                                            <option value="PHL" {{ $statusPegawai == 'PHL' ? 'selected' : '' }}>PHL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 mb-3">
                                    <div class="input-group input-group-static input-group-outline">
                                        <label>Status Hadir</label>
                                        <select class="form-control auto-submit-filter" 
                                            name="status_kehadiran">
                                            <option value="">Semua</option>
                                            <option value="H" {{ $statusKehadiran == 'H' ? 'selected' : '' }}>Hadir</option>
                                            <option value="T" {{ $statusKehadiran == 'T' ? 'selected' : '' }}>Terlambat</option>
                                            <option value="S" {{ $statusKehadiran == 'S' ? 'selected' : '' }}>Sakit</option>
                                            <option value="I" {{ $statusKehadiran == 'I' ? 'selected' : '' }}>Izin</option>
                                            <option value="A" {{ $statusKehadiran == 'A' ? 'selected' : '' }}>Alfa</option>
                                            <option value="CT" {{ $statusKehadiran == 'CT' ? 'selected' : '' }}>Cuti</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 mb-3">
                                    <div class="input-group input-group-outline @if($search) is-filled @endif">
                                        <label class="form-label">Cari </label>
                                        <input type="text" class="form-control" name="search" value="{{ $search }}">
                                        <span class="input-group-text"><i class="material-icons">search</i></span>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 mb-3 d-flex gap-2">
                                    <button type="submit"
                                        class="btn mb-0 d-flex align-items-center justify-content-center flex-fill"
                                        style="background-color: white; color: #534D59; border: 1px solid #534D59;">
                                        <i class="material-icons text-sm me-2">filter_list</i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive shadow-custom-eabsensi p-0">
                            <table class="table table-striped align-items-center mb-0">
                                <thead>
                                    <tr class="bg-custom-purple-light ">
                                        <th class="text-uppercase text-s font-weight-bolder ps-2">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal', 'sort_order' => ($sortBy == 'tanggal' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}"
                                                class="text-custom-color">
                                                Tanggal
                                                @if($sortBy == 'tanggal')
                                                    <i class="material-icons text-xs">{{ $sortOrder == 'asc' ? 'arrow_upward' : 'arrow_downward' }}</i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-uppercase text-s font-weight-bolder">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_lengkap', 'sort_order' => ($sortBy == 'nama_lengkap' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}"
                                                class="text-custom-color">
                                                Nama Pegawai
                                                @if($sortBy == 'nama_lengkap')
                                                    <i class="material-icons text-xs">{{ $sortOrder == 'asc' ? 'arrow_upward' : 'arrow_downward' }}</i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-uppercase text-s font-weight-bolder ps-2">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status_kehadiran', 'sort_order' => ($sortBy == 'status_kehadiran' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}"
                                                class="text-custom-color">
                                                Status Hadir
                                                @if($sortBy == 'status_kehadiran')
                                                    <i class="material-icons text-xs">{{ $sortOrder == 'asc' ? 'arrow_upward' : 'arrow_downward' }}</i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Jam Masuk</th>
                                        <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Jam Pulang</th>
                                        <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Status Persetujuan</th>
                                        <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2 pe-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $absensi)
                                        <tr>
                                            <td>
                                                <p class="text-s font-weight-bold mb-0 text-custom-color">
                                                    {{ $absensi->tanggal->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @if ($absensi->pegawai->foto)
                                                            <img src="{{ asset('storage/' . $absensi->pegawai->foto) }}"
                                                                class="avatar avatar-sm me-3 border-radius-lg" alt="Foto">
                                                        @else
                                                            <div
                                                                class="avatar avatar-sm me-3 border-radius-lg bg-dark d-flex justify-content-center align-items-center">
                                                                <span
                                                                    class="text-white text-s font-weight-bold">{{ substr($absensi->pegawai->nama_lengkap ?? '?', 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm text-custom-color">
                                                            {{ $absensi->pegawai->nama_lengkap ?? 'N/A' }}
                                                        </h6>
                                                        <p class="text-s text-secondary mb-0">{{ $absensi->pegawai->nip ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $status = $absensi->status_kehadiran;
                                                    if ($absensi->status_persetujuan == 'Rejected') {
                                                        $status = 'A';
                                                    } elseif ($absensi->status_persetujuan == 'Pending') {
                                                        $status = '';
                                                    }
                                                @endphp
                                                @if($status == 'H') <span class="badge badge-sm bg-gradient-success">Hadir</span>
                                                @elseif($status == 'T') <span class="badge badge-sm bg-gradient-warning">Terlambat</span>
                                                @elseif($status == 'S') <span class="badge badge-sm bg-gradient-info">Sakit</span>
                                                @elseif($status == 'I') <span class="badge badge-sm bg-gradient-secondary">Izin</span>
                                                @else <span class="badge badge-sm bg-gradient-danger">{{ $status }}</span>
                                                @endif
                                            </td>
                                            <td><span
                                                    class="text-s font-weight-bold text-custom-color">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</span>
                                            </td>
                                            <td><span
                                                    class="text-s font-weight-bold text-custom-color">{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</span>
                                            </td>
                                            <td>
                                                @if($absensi->status_persetujuan == 'Approved') <span
                                                    class="badge badge-sm bg-gradient-success">Disetujui</span>
                                                @elseif($absensi->status_persetujuan == 'Pending') <span
                                                    class="badge badge-sm bg-gradient-warning">Ditunda</span>
                                                @elseif($absensi->status_persetujuan == 'Rejected') <span
                                                    class="badge badge-sm bg-gradient-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.absensi.edit', $absensi->id) }}" 
                                                class="btn btn-link text-dark px-3 mb-0" 
                                                data-bs-toggle="tooltip" data-bs-original-title="Edit Absensi">
                                                    <i class="material-icons text-sm me-2">edit</i>Edit
                                                </a>
                                                
                                                <button type="button" 
                                                        class="btn btn-link text-danger px-3 mb-0" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        data-action="{{ route('admin.absensi.destroy', $absensi->id) }}"
                                                        data-name="{{ $absensi->pegawai->nama_lengkap ?? 'N/A' }}"
                                                        data-date="{{ $absensi->tanggal->format('d M Y') }}"
                                                        data-bs-original-title="Hapus Absensi">
                                                    <i class="material-icons text-sm me-2">delete</i>Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-secondary text-sm p-4">
                                                Tidak ada data absensi untuk rentang tanggal ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div> 

                <div class="d-flex justify-content-center mt-4">
                    {{ $attendances->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Absensi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Anda yakin ingin menghapus data absensi ini?</p>
            <ul class="list-unstyled">
                <li><strong>Pegawai:</strong> <span id="absensiPegawai" class="text-dark"></span></li>
                <li><strong>Tanggal:</strong> <span id="absensiTanggal" class="text-dark"></span></li>
            </ul>
            <p class="text-danger mb-0"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        var deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var action = button.getAttribute('data-action');
                var name = button.getAttribute('data-name');
                var date = button.getAttribute('data-date');
                
                var form = deleteModal.querySelector('#deleteForm');
                form.setAttribute('action', action);
                
                deleteModal.querySelector('#absensiPegawai').textContent = name;
                deleteModal.querySelector('#absensiTanggal').textContent = date;
            });
        }
    });
</script>
@endpush