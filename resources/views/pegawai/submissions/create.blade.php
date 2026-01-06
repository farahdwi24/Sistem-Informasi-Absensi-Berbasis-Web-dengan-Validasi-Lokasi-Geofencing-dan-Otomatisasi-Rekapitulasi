@extends('layouts.app', ['activePage' => 'buat-pengajuan'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Formulir Pengajuan Manual</h6>
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
                    
                    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
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
                            <div class="col-6">
                                <div class="input-group input-group-outline my-3 @if(old('jam_masuk')) is-filled @endif">
                                    <label class="form-label">Jam Masuk</label>
                                    <input type="time" class="form-control" name="jam_masuk" value="{{ old('jam_masuk') }}">
                                </div>
                                <small class="text-secondary d-none d-lg-block">Jam masuk dan jam pulang wajib diisi jika koreksi Hadir/Terlambat.</small>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-outline my-3 @if(old('jam_pulang')) is-filled @endif">
                                    <label class="form-label">Jam Pulang</label>
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
                            <small class="text-secondary">Contoh: Surat Sakit (PDF, JPG, PNG).</small>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-custom-purple-solid">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>

                </div> </div> </div> </div> </div> @endsection