@extends('layouts.app', ['activePage' => 'manajemen-pegawai'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Tambah Pegawai Baru</h6>
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
                    
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline @if(old('nama_lengkap')) is-filled @endif">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" 
                                           value="{{ old('nama_lengkap') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline @if(old('nip')) is-filled @endif">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip" 
                                           value="{{ old('nip') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline @if(old('email')) is-filled @endif">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static">
                                    <label for="jabatan">Jabatan</label>
                                    <select class="form-control" id="jabatan" name="jabatan" required>
                                        @php
                                            $daftarJabatan = [
                                                        'Kepala Puskesmas', 'Koordinator Kepegawaian', 'Bendahara',
                                                        'ADMINKES AHLI MADYA', 'AHLI PERTAMA - ADMINISTRATOR KESEHATAN',
                                                        'AHLI PERTAMA - NUTRISIONIS', 'AHLI PERTAMA-ADMINISTRASI KESEHATAN',
                                                        'AHLI PERTAMA-BIDAN', 'AHLI PERTAMA-EPIDEMIOLOG KESEHATAN',
                                                        'AHLI PERTAMA-PERAWAT', 'APOTEKER AHLI MADYA', 'BIDAN MAHIR',
                                                        'BIDAN PENYELIA', 'DOKTER GIGI AHLI PERTAMA', 'EPIDEMIOLOGI AHLI MADYA',
                                                        'NUTRISIONIS PENYELIA', 'PERAWAT AHLI MUDA', 'PERAWAT MAHIR',
                                                        'PERAWAT PENYELIA', 'TERAMPIL - PRANATA LABORATORIUM KESEHATAN',
                                                        'TERAMPIL - TENAGA SANITASI LINGKUNGAN', 'TERAMPIL - TERAPIS GIGI DAN MULUT',
                                                        'TERAMPIL-BIDAN', 'TERAMPIL-GIZI', 'TERAMPIL-PERAWAT', 'Lainnya'
                                                    ];
                                        @endphp
                                        <option value="" disabled selected>-- Pilih Jabatan --</option>
                                        @foreach ($daftarJabatan as $jabatan)
                                            <option value="{{ $jabatan }}" {{ old('jabatan') == $jabatan ? 'selected' : '' }}>
                                                {{ $jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group input-group-static">
                                    <label for="status_kepegawaian">Status Kepegawaian</label>
                                    <select class="form-control" id="status_kepegawaian" name="status_kepegawaian" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="P3K" {{ old('status_kepegawaian') == 'P3K' ? 'selected' : '' }}>P3K</option>
                                        <option value="PHL" {{ old('status_kepegawaian') == 'PHL' ? 'selected' : '' }}>PHL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group input-group-static">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="input-group input-group-static">
                                    <label for="role_id">Role (Peran)</label>
                                    <select class="form-control" id="role_id" name="role_id" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->nama_peran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                           <div class="col-md-6 mb-3">
                            <div class="input-group input-group-static">
                                <label>Lokasi Penempatan</label>
                                <select class="form-control" name="penempatan" required>
                                    @php
                                        $daftarPenempatan = [
                                            'Kantor Induk Puskesmas Soropia',
                                            'Pustu Toronipa',
                                            'Pustu Tapulaga',
                                            'Lainnya'
                                        ];
                                    @endphp
                                    
                                    <option value="" disabled selected>-- Pilih Lokasi --</option>
                                    
                                    @foreach ($daftarPenempatan as $penempatan)
                                        <option value="{{ $penempatan }}" {{ (old('penempatan', $user->penempatan ?? '') == $penempatan) ? 'selected' : '' }}>
                                            {{ $penempatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Foto (Opsional)</label>
                                    <input class="form-control" type="file" name="foto">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-custom-purple-solid">
                                Simpan Pegawai
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection