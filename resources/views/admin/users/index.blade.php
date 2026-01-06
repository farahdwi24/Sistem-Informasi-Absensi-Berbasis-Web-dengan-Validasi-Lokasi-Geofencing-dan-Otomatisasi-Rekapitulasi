@extends('layouts.app', ['activePage' => 'manajemen-pegawai'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                    <div class="row align-items-center mx-3">
                        
                        <div class="col-md-4">
                            <h2 class="text-white text-capitalize ps-3 d-none d-lg-block">Manajemen Pegawai</h2>
                            <h6 class="text-white text-capitalize ps-3 d-block d-lg-none">Manajemen Pegawai</h6>
                        </div>

                        <div class="col-md-8">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                
                                <form method="GET" action="{{ route('admin.users.index') }}" class="mb-0">
                                    <div class="input-group input-group-outline input-bg-white @if($search ?? '') is-filled @endif" style="background-color: white;">
                                        <label class="form-label">Cari</label>
                                        <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}">
                                        <span class="input-group-text"><i class="material-icons">search</i></span>
                                    </div>
                                </form>
                                
                                <a href="{{ route('admin.users.create') }}" class="btn btn-light mb-0">
                                    + Tambah Pegawai
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
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Status</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Role</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Penempatan</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-4 py-1"> 
                                        <div>
                                            @if ($user->foto)
                                                <img src="{{ asset('storage/' . $user->foto) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="Foto">
                                            @else
                                                <div class="avatar avatar-sm me-3 border-radius-lg bg-dark d-flex justify-content-center align-items-center">
                                                    <span class="text-white text-xs font-weight-bold">{{ substr($user->nama_lengkap, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm text-custom-color">{{ $user->nama_lengkap }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $user->nip }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $user->status_kepegawaian }}</p>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $user->role->nama_peran ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $user->penempatan ?? 'N/A' }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-link text-dark px-3 mb-0" 
                                       data-bs-toggle="tooltip" data-bs-original-title="Edit Pegawai">
                                        <i class="material-icons text-sm me-2">edit</i>Edit
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-link text-danger px-3 mb-0" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.users.destroy', $user) }}"
                                            data-name="{{ $user->nama_lengkap }}"
                                            data-bs-original-title="Hapus Pegawai">
                                        <i class="material-icons text-sm me-2">delete</i>Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary text-sm p-4">
                                    @if ($search)
                                        Tidak ada pegawai yang ditemukan untuk "{{ $search }}".
                                    @else
                                        Belum ada data pegawai.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus pegawai: <strong id="userName" class="text-dark"></strong>?</p>
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
                
                var form = deleteModal.querySelector('#deleteForm');
                var userNameEl = deleteModal.querySelector('#userName'); 
                
                form.setAttribute('action', action);
                userNameEl.textContent = name; 
            });
        }
    });
</script>
@endpush