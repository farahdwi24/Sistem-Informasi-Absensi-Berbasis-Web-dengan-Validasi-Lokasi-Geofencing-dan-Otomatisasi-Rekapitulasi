@extends('layouts.app', ['activePage' => 'manajemen-pegawai'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card my-4 shadow-custom-eabsensi"> <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Pegawai: {{ $user->nama_lengkap }}</h6>
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
                    
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" 
                                           value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip" 
                                           value="{{ old('nip', $user->nip) }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                        <div class="input-group input-group-static">
                                            <label>Jabatan</label>
                                            <select class="form-control" name="jabatan" required>
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
                                                @foreach ($daftarJabatan as $jabatan)
                                                    <option value="{{ $jabatan }}" {{ old('jabatan', $user->jabatan) == $jabatan ? 'selected' : '' }}>
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
                                        <option value="PNS" {{ old('status_kepegawaian', $user->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="P3K" {{ old('status_kepegawaian', $user->status_kepegawaian) == 'P3K' ? 'selected' : '' }}>P3K</option>
                                        <option value="PHL" {{ old('status_kepegawaian', $user->status_kepegawaian) == 'PHL' ? 'selected' : '' }}>PHL</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="input-group input-group-static">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group input-group-static">
                                    <label for="role_id">Role (Peran)</label>
                                    <select class="form-control" id="role_id" name="role_id" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
                            
                            <div class="col-md-8 mb-3">
                                <div class="input-group input-group-static">
                                    <label>Ganti Foto (Opsional)</label>
                                    <input class="form-control" type="file" name="foto">
                                </div>
                                @if ($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Lama" 
                                         class="mt-2 avatar avatar-xl shadow-lg border-radius-lg">
                                    <small class="text-secondary d-block">Foto saat ini</small>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-custom-purple-solid">
                                Perbarui Pegawai
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection