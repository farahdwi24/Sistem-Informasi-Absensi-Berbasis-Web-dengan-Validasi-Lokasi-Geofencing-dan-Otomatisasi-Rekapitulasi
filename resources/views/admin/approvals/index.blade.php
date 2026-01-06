@extends('layouts.app', ['activePage' => 'persetujuan'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4 shadow-custom-eabsensi">
               <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="text-white text-capitalize ps-3 d-none d-lg-block">Persetujuan Pengajuan Manual</h2>
                        <h6 class="text-white text-capitalize ps-3 d-block d-lg-none">Persetujuan Pengajuan</h6>
                        <div class="col-auto">
                        <a href="{{ route('admin.pengajuan.create') }}"
                        class="btn btn-light me-4 mb-0 d-none d-lg-inline-block">
                        <i class="material-icons text-sm me-2">edit_calendar</i> Buat Pengajuan
                        </a>

                        <a href="{{ route('admin.pengajuan.create') }}"
                        class="btn btn-light btn-sm me-4 mb-0 d-inline-block d-lg-none">
                        <i class="material-icons text-sm me-2">edit_calendar</i> Buat Pengajuan
                        </a>
                        </div>

                    </div>
                        
                    </div>
                </div>
            </div>

            <div class="table-responsive shadow-custom-eabsensi p-0" style="border-radius: 0.75rem;">
                <table class="table table-striped align-items-center mb-0">
                    <thead>
                        <tr class="bg-custom-purple-light">
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-4">Nama Pegawai</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Tanggal</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Jenis</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Keterangan</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Lampiran</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuanPending as $pengajuan)
                            <tr>
                                <td>
                                    <div class="d-flex px-4 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm text-custom-color">{{ $pengajuan->pegawai->nama_lengkap }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $pengajuan->pegawai->nip }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $pengajuan->tanggal->format('d M Y') }}</p>
                                </td>
                                <td>
                                    @php $jenisText = ''; @endphp
                                    @if($pengajuan->status_kehadiran == 'S')
                                        @php $jenisText = 'Sakit'; @endphp
                                        <span class="badge badge-sm bg-gradient-info">Sakit</span>
                                    @elseif($pengajuan->status_kehadiran == 'I')
                                        @php $jenisText = 'Izin'; @endphp
                                        <span class="badge badge-sm bg-gradient-secondary">Izin</span>
                                    @elseif($pengajuan->status_kehadiran == 'H')
                                        @php $jenisText = 'Hadir'; @endphp
                                        <span class="badge badge-sm bg-gradient-success">Hadir</span>
                                    @elseif($pengajuan->status_kehadiran == 'T')
                                        @php $jenisText = 'Terlambat'; @endphp
                                        <span class="badge badge-sm bg-gradient-warning">Terlambat</span>
                                    @else
                                        @php $jenisText = 'Koreksi (' . $pengajuan->status_kehadiran . ')'; @endphp
                                        <span class="badge badge-sm bg-gradient-warning">Koreksi ({{ $pengajuan->status_kehadiran }})</span>
                                    @endif
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color" style="white-space: normal; min-width: 200px;">
                                        {{ $pengajuan->keterangan }}
                                    </p>
                                </td>
                                <td>
                                    @if ($pengajuan->file_lampiran)
                                        <a href="{{ asset('storage/' . $pengajuan->file_lampiran) }}" target="_blank" class="btn btn-link text-dark px-3 mb-0">
                                            <i class="material-icons text-sm me-2">visibility</i>Lihat
                                        </a>
                                    @else
                                        <span class="text-secondary text-s font-weight-bold">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-danger mb-0"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal"
                                            data-action="{{ route('admin.persetujuan.reject', $pengajuan->id) }}"
                                            data-name="{{ $pengajuan->pegawai->nama_lengkap }}"
                                            data-date="{{ $pengajuan->tanggal->format('d M Y') }}"
                                            data-type="{{ $jenisText }}">
                                        Tolak
                                    </button>
                                    
                                    <button type="button" class="btn btn-xs btn-success mb-0"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#approveModal"
                                            data-action="{{ route('admin.persetujuan.approve', $pengajuan->id) }}"
                                            data-name="{{ $pengajuan->pegawai->nama_lengkap }}"
                                            data-date="{{ $pengajuan->tanggal->format('d M Y') }}"
                                            data-type="{{ $jenisText }}">
                                        Setujui
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary text-sm p-4">
                                    Tidak ada pengajuan yang menunggu persetujuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $pengajuanPending->links('pagination::bootstrap-5') }}
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Penolakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin <strong class="text-danger">MENOLAK</strong> pengajuan ini?</p>
        <ul class="list-unstyled">
            <li><strong>Pegawai:</strong> <span id="rejectName" class="text-dark"></span></li>
            <li><strong>Tanggal:</strong> <span id="rejectDate" class="text-dark"></span></li>
            <li><strong>Jenis:</strong> <span id="rejectType" class="text-dark"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="rejectForm" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Ya, Tolak</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel">Konfirmasi Persetujuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin <strong class="text-success">MENYETUJUI</strong> pengajuan ini?</p>
        <ul class="list-unstyled">
            <li><strong>Pegawai:</strong> <span id="approveName" class="text-dark"></span></li>
            <li><strong>Tanggal:</strong> <span id="approveDate" class="text-dark"></span></li>
            <li><strong>Jenis:</strong> <span id="approveType" class="text-dark"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="approveForm" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Ya, Setujui</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rejectModal = document.getElementById('rejectModal');
        if (rejectModal) {
            rejectModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var action = button.getAttribute('data-action');
                var name = button.getAttribute('data-name');
                var date = button.getAttribute('data-date');
                var type = button.getAttribute('data-type');
                
                var form = rejectModal.querySelector('#rejectForm');
                form.setAttribute('action', action);
                
                rejectModal.querySelector('#rejectName').textContent = name;
                rejectModal.querySelector('#rejectDate').textContent = date;
                rejectModal.querySelector('#rejectType').textContent = type;
            });
        }

        var approveModal = document.getElementById('approveModal');
        if (approveModal) {
            approveModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var action = button.getAttribute('data-action');
                var name = button.getAttribute('data-name');
                var date = button.getAttribute('data-date');
                var type = button.getAttribute('data-type');
                
                var form = approveModal.querySelector('#approveForm');
                form.setAttribute('action', action);
                
                approveModal.querySelector('#approveName').textContent = name;
                approveModal.querySelector('#approveDate').textContent = date;
                approveModal.querySelector('#approveType').textContent = type;
            });
        }
    });
</script>
@endpush