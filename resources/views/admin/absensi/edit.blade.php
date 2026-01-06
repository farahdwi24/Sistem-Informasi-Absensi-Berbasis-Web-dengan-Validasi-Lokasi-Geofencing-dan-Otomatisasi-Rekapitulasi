@extends('layouts.app', ['activePage' => 'dashboard'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Data Absensi</h6>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-sm text-secondary">Anda sedang mengedit absensi untuk: 
                        <strong class="text-dark">{{ $absensi->pegawai->nama_lengkap }}</strong> 
                        pada tanggal 
                        <strong class="text-dark">{{ $absensi->tanggal->format('d M Y') }}</strong>
                    </p>

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
                    
                    <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static is-filled">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" 
                                           value="{{ old('tanggal', $absensi->tanggal->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Status Kehadiran</label>
                                    <select class="form-control" name="status_kehadiran" required>
                                        <option value="H" {{ old('status_kehadiran', $absensi->status_kehadiran) == 'H' ? 'selected' : '' }}>Hadir</option>
                                        <option value="T" {{ old('status_kehadiran', $absensi->status_kehadiran) == 'T' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="S" {{ old('status_kehadiran', $absensi->status_kehadiran) == 'S' ? 'selected' : '' }}>Sakit</option>
                                        <option value="I" {{ old('status_kehadiran', $absensi->status_kehadiran) == 'I' ? 'selected' : '' }}>Izin</option>
                                        <option value="A" {{ old('status_kehadiran', $absensi->status_kehadiran) == 'A' ? 'selected' : '' }}>Alfa</option>
                                        <option value="CT" {{ old('status_kehadiran', $absensi->status_kehadiran) == 'CT' ? 'selected' : '' }}>Cuti</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline @if(old('jam_masuk', $absensi->jam_masuk)) is-filled @endif">
                                    <label class="form-label">Jam Masuk (Contoh: 07:30)</label>
                                    <input type="time" class="form-control" name="jam_masuk" 
                                           value="{{ old('jam_masuk', $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline @if(old('jam_pulang', $absensi->jam_pulang)) is-filled @endif">
                                    <label class="form-label">Jam Pulang (Contoh: 14:00)</label>
                                    <input type="time" class="form-control" name="jam_pulang" 
                                           value="{{ old('jam_pulang', $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-custom-purple-solid">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection