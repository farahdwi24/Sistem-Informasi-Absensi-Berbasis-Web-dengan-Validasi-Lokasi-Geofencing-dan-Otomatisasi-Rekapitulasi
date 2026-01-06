@extends('layouts.app', ['activePage' => 'profile'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        <div class="col-12 col-lg-4">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-body text-center">
                    
                    <div class="position-relative d-inline-block">
                        @if (Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil"
                                 class="avatar avatar-xxl rounded-circle shadow-lg border border-2 border-white">
                        @else
                            <div class="avatar avatar-xxl rounded-circle shadow-lg bg-dark d-flex justify-content-center align-items-center">
                                <span class="text-white text-h5 font-weight-bold">{{ substr(Auth::user()->nama_lengkap ?? '?', 0, 1) }}</span>
                            </div>
                        @endif
                        <a href="#data-pribadi" data-bs-toggle="tab"
                           class="btn btn-sm btn-icon-only btn-custom-purple-solid rounded-circle position-absolute bottom-0 end-0 mb-n2 me-n2" 
                           style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-original-title="Ganti Foto">
                            <i class="material-icons text-sm">edit</i>
                        </a>
                    </div>

                    <h3 class="mt-3 mb-0 text-custom-color">{{ Auth::user()->nama_lengkap }}</h3>
                    <p class="text-sm text-secondary mb-1">{{ Auth::user()->jabatan ?? 'Belum Diatur' }}</p>
                    <p class="text-sm text-muted">{{ Auth::user()->nip }}</p>
                    
                    <span class="badge 
                        @if(Auth::user()->status_kepegawaian == 'PNS') bg-gradient-success
                        @elseif(Auth::user()->status_kepegawaian == 'P3K') bg-gradient-info
                        @else bg-gradient-warning
                        @endif">
                        {{ Auth::user()->status_kepegawaian }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-3 pb-2">
                        <ul class="nav nav-tabs nav-fill p-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-white active" data-bs-toggle="tab" href="#data-pribadi" role="tab" aria-controls="data-pribadi" aria-selected="true">
                                    <i class="material-icons text-sm me-2">person</i> Data Pribadi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" data-bs-toggle="tab" href="#ganti-password" role="tab" aria-controls="ganti-password" aria-selected="false">
                                    <i class="material-icons text-sm me-2">lock</i> Ganti Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" data-bs-toggle="tab" href="#hapus-akun" role="tab" aria-controls="hapus-akun" aria-selected="false">
                                    <i class="material-icons text-sm me-2">delete</i> Hapus Akun
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content">
                        
                        <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <h6 class="text-custom-color">Informasi Akun</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group input-group-static @if(old('nama_lengkap', $user->nama_lengkap)) is-filled @endif">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                                        </div>
                                        @error('nama_lengkap') <p class='text-danger text-xs'>{{ $message }} </p> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group input-group-static @if(old('nip', $user->nip)) is-filled @endif">
                                            <label>NIP</label>
                                            <input type="text" class="form-control" name="nip" value="{{ old('nip', $user->nip) }}">
                                        </div>
                                        @error('nip') <p class='text-danger text-xs'>{{ $message }} </p> @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-group input-group-static @if(old('email', $user->email)) is-filled @endif">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        @error('email') <p class='text-danger text-xs'>{{ $message }} </p> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group input-group-static">
                                            <label>Status Kepegawaian</label>
                                            <select class="form-control" name="status_kepegawaian" required>
                                                <option value="PNS" {{ old('status_kepegawaian', $user->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                                <option value="P3K" {{ old('status_kepegawaian', $user->status_kepegawaian) == 'P3K' ? 'selected' : '' }}>P3K</option>
                                                <option value="PHL" {{ old('status_kepegawaian', $user->status_kepegawaian) == 'PHL' ? 'selected' : '' }}>PHL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group input-group-static">
                                            <label>Jenis Kelamin</label>
                                            <select class="form-control" name="jenis_kelamin" required>
                                                <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group input-group-static">
                                            <label>Jabatan</label>
                                            <select class="form-control" name="jabatan" required>
                                                @php
                                                    $daftarJabatanPenuh = [
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
                                                    
                                                    $daftarJabatanPegawai = [
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
                                                    $jabatanSaatIni = old('jabatan', $user->jabatan);
                                                @endphp
                                                
                                                @if(Auth::user()->role->nama_peran == 'Admin')
                                                    
                                                    @foreach ($daftarJabatanPenuh as $jabatan)
                                                        <option value="{{ $jabatan }}" {{ $jabatanSaatIni == $jabatan ? 'selected' : '' }}>
                                                            {{ $jabatan }}
                                                        </option>
                                                    @endforeach
                                                    
                                                @else
                                                    
                                                    @if(!in_array($jabatanSaatIni, $daftarJabatanPegawai) && $jabatanSaatIni)
                                                        <option value="{{ $jabatanSaatIni }}" selected>{{ $jabatanSaatIni }}</option>
                                                    @endif
                                                    
                                                    @foreach ($daftarJabatanPegawai as $jabatan)
                                                        <option value="{{ $jabatan }}" {{ $jabatanSaatIni == $jabatan ? 'selected' : '' }}>
                                                            {{ $jabatan }}
                                                        </option>
                                                    @endforeach
                                                    
                                                @endif
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
                                                    <option value="{{ $penempatan }}" {{ old('penempatan', $user->penempatan) == $penempatan ? 'selected' : '' }}>
                                                        {{ $penempatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-group input-group-static">
                                            <label>Ganti Foto (Opsional)</label>
                                            <input type="file" class="form-control" name="foto" id="foto-upload">
                                        </div>
                                        @error('foto') <p class='text-danger text-xs'>{{ $message }} </p> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-custom-purple-solid mt-3">Simpan Data Pribadi</button>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="ganti-password" role="tabpanel">
                            <form method="post" action="{{ route('password.update') }}">
                                @csrf @method('put')
                                <h6 class="text-custom-color">Ubah Password</h6>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                @error('current_password', 'updatePassword') <p ...>{{ $message }} </p> @enderror
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                @error('password', 'updatePassword') <p ...>{{ $message }} </p> @enderror
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-custom-purple-solid mt-3">Simpan Password</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="hapus-akun" role="tabpanel">
                            <h6 class="text-custom-color">Hapus Akun</h6>
                            <p class="text-sm text-secondary">
                                Setelah akun Anda dihapus, semua data dan sumber dayanya akan dihapus secara permanen.
                            </p>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                Hapus Akun
                            </button>
                            
                            <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Akun</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form method="post" action="{{ route('profile.destroy') }}">
                                      @csrf
                                      @method('delete')
                                      
                                      <div class="modal-body">
                                        <p>Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.</p>
                                        <p>Silakan masukkan password Anda untuk mengkonfirmasi.</p>
                                        
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Password Anda</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        @error('password', 'userDeletion') 
                                            <p class='text-danger text-xs'>{{ $message }} </p> 
                                        @enderror
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Ya, Hapus Akun Saya</button>
                                      </div>
                                  </form>
                                </div>
                            </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editFotoButton = document.querySelector('a[href="#data-pribadi"][data-bs-toggle="tab"]');
        const fotoUploadInput = document.getElementById('foto-upload');
        if (editFotoButton && fotoUploadInput) {
            editFotoButton.addEventListener('click', function (e) {
                fotoUploadInput.click();
            });
        }

        @if ($errors->userDeletion->any())
            var tabTrigger = new bootstrap.Tab(document.querySelector('a[href="#hapus-akun"]'));
            tabTrigger.show();
        
        @elseif ($errors->updatePassword->any())
            var tabTrigger = new bootstrap.Tab(document.querySelector('a[href="#ganti-password"]'));
            tabTrigger.show();
        
        @elseif ($errors->any())
            var tabTrigger = new bootstrap.Tab(document.querySelector('a[href="#data-pribadi"]'));
            tabTrigger.show();
        @endif
    });
</script>
@endpush