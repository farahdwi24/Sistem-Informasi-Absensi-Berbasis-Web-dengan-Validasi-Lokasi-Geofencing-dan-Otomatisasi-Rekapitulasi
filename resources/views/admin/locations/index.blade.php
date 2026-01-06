@extends('layouts.app', ['activePage' => 'manajemen-lokasi'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4 shadow-custom-eabsensi">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="text-white text-capitalize ps-3 d-none d-lg-block">Tabel Koordinat Lokasi</h2>
                            <h6 class="text-white text-capitalize ps-3 d-block d-lg-none">Koordinat Lokasi</h6>
                            <a href="{{ route('admin.locations.create') }}" class="btn btn-light me-4">
                                + Tambah Lokasi
                            </a>
                        </div>
                    </div>
            </div>

            <div class="table-responsive shadow-custom-eabsensi p-0" style="border-radius: 0.75rem;">
                <table class="table table-striped align-items-center mb-0">
                    <thead>
                        <tr class="bg-custom-purple-light">
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-4">Nama Lokasi</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Latitude</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Longitude</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder ps-2">Radius (m)</th>
                            <th class="text-uppercase text-custom-color text-s font-weight-bolder text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($locations as $location)
                            <tr>
                                <td>
                                    <div class="d-flex px-4 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm text-custom-color">{{ $location->nama_lokasi }}</h6>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $location->latitude }}</p>
                                </td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $location->longitude }}</p>
                                </td>
                                
                                <td>
                                    <p class="text-s font-weight-bold mb-0 text-custom-color">{{ $location->radius_meter }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.locations.edit', $location) }}" 
                                       class="btn btn-link text-dark px-3 mb-0" 
                                       data-bs-toggle="tooltip" data-bs-original-title="Edit Lokasi">
                                        <i class="material-icons text-sm me-2">edit</i>Edit
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-link text-danger px-3 mb-0" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.locations.destroy', $location->id) }}"
                                            data-name="{{ $location->nama_lokasi }}"
                                            data-bs-original-title="Hapus Lokasi">
                                        <i class="material-icons text-sm me-2">delete</i>Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary text-sm p-4">
                                    Belum ada data lokasi.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus lokasi: <strong id="locationName" class="text-dark"></strong>?</p>
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
                var locationNameEl = deleteModal.querySelector('#locationName');
                
                form.setAttribute('action', action);
                locationNameEl.textContent = name;
            });
        }
    });
</script>
@endpush