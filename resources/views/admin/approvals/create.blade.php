@extends('layouts.app', ['activePage' => 'persetujuan'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Buat Pengajuan Atas Nama Pegawai</h6>
                    </div>
                </div>
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger text-white" role="alert">
                            <strong>Ups! Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="select-pegawai-search" class="form-label">Pilih Pegawai *</label>
                            <select id="select-pegawai-search" name="pegawai_id" required 
                                    placeholder="Ketik untuk mencari nama atau NIP...">
                                <option value="" disabled selected>-- Pilih Pegawai --</option>
                                @foreach ($pegawaiList as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="input-group input-group-static my-3">
                            <label for="status_kehadiran">Jenis Pengajuan *</label>
                            <select class="form-control" id="status_kehadiran" name="status_kehadiran" required>
                                <option value="" disabled selected>-- Pilih Jenis --</option>
                                <option value="S" {{ old('status_kehadiran') == 'S' ? 'selected' : '' }}>Sakit (S)</option>
                                <option value="I" {{ old('status_kehadiran') == 'I' ? 'selected' : '' }}>Izin (I)</option>
                                <option value="CT" {{ old('status_kehadiran') == 'CT' ? 'selected' : '' }}>Cuti (CT)</option>
                                <option value="H" {{ old('status_kehadiran') == 'H' ? 'selected' : '' }}>Hadir (H)</option>
                                <option value="T" {{ old('status_kehadiran') == 'T' ? 'selected' : '' }}>Terlambat (T)</option>
                            </select>
                        </div>

                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Pengajuan *</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal') }}" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 @if(old('jam_masuk')) is-filled @endif">
                                    <label class="form-label">Jam Masuk (Contoh: 07:30)</label>
                                    <input type="time" class="form-control" name="jam_masuk" value="{{ old('jam_masuk') }}">
                                </div>
                                <small class="text-secondary">Wajib diisi jika koreksi Hadir/Terlambat.</small>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 @if(old('jam_pulang')) is-filled @endif">
                                    <label class="form-label">Jam Pulang (Contoh: 14:00)</label>
                                    <input type="time" class="form-control" name="jam_pulang" value="{{ old('jam_pulang') }}">
                                </div>
                            </div>
                        </div>

                        <div class="input-group input-group-static my-3">
                            <label>Keterangan/Alasan *</label>
                            <textarea name="keterangan" rows="4" class="form-control" required>{{ old('keterangan') }}</textarea>
                        </div>
                        
                        <div class="input-group input-group-static my-3">
                            <label>File Lampiran (Opsional, maks 2MB)</label>
                            <input type="file" class="form-control" name="file_lampiran">
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.persetujuan.index') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-custom-purple-solid">
                                Simpan Pengajuan
                            </button>
                        </div>
                    </form>

                </div> </div> </div> </div> </div> @endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('select-pegawai-search')) {
            new TomSelect("#select-pegawai-search",{
                create: false, 
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }
    });
</script>
@endpush