@extends('layouts.app', ['activePage' => 'absensi'])
@section('content')
<header class="header-2">
    <div class="page-header py-5 py-lg-7 relative" style="background-image: url('{{ asset('assets/img/foto-puskesmas.jpeg') }}')">
      <span class="mask bg-custom-purple-solid opacity-6"></span>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 text-center mx-auto">
            <h3 class="text-white">Hai, {{ Auth::user()->nama_lengkap }}</h3>
            <h6 class="text-white mt-3">Silakan Lakukan Absensi Hari Ini<br/>
               dengan Menekan Tombol Absen di Bawah.</h6>
            <a href="#kartu-absen" class="btn btn-light mt-3">Absen Di bawah 
                <i class="material-icons fs-3 ms-1">keyboard_arrow_down</i>
            </a>
          </div>
        </div>
      </div>

    <div class="position-absolute w-100 z-index-1 bottom-0">
      <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
          <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="moving-waves">
          <use xlink:href="#gentle-wave" x="48" y="-1" fill="rgba(255,255,255,0.40" />
          <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.35)" />
          <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.25)" />
          <use xlink:href="#gentle-wave" x="48" y="8" fill="rgba(255,255,255,0.20)" />
          <use xlink:href="#gentle-wave" x="48" y="13" fill="rgba(255,255,255,0.15)" />
          <use xlink:href="#gentle-wave" x="48" y="16" fill="rgba(255,255,255,0.95" />
        </g>
      </svg>
    </div>
  </div>
</header>


<section class="pt-7 pb-4" id="count-stats">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 z-index-2 border-radius-xl mt-n4 mt-md-n10 mx-auto py-3 blur shadow-blur" style="background-color: rgba(255,255,255,0.8);">
          
          <div class="row">
            
            <div class="col-4 position-relative">
              <div class="p-3 text-center d-none d-md-block">
                <h3 class="text-gradient text-dark mb-0"><span id="state1_desktop" countTo="{{ $totalHadir }}">{{ $totalHadir }}</span></h3>
                <h6 class="mt-2 text-custom-color">Hadir</h6>
                <p class="text-xs mb-0" style="line-height: 1.2;">Total kehadiran bulan ini</p>
              </div>
              
              <div class="p-2 text-center d-block d-md-none">
                <h5 class="text-gradient text-dark mb-0"><span id="state1_mobile" countTo="{{ $totalHadir }}">{{ $totalHadir }}</span></h5>
                <h6 class="mt-1 text-custom-color" style="font-size: 0.8rem;">Hadir</h6>
              </div>
              
              <hr class="vertical dark d-none d-md-block">
            </div>
            
            <div class="col-4 position-relative">
              
              <div class="p-3 text-center d-none d-md-block">
                <h3 class="text-gradient text-dark mb-0"> <span id="state2_desktop" countTo="{{ $totalTerlambat }}">{{ $totalTerlambat }}</span></h3>
                <h6 class="mt-2 text-custom-color">Terlambat</h6>
                <p class="text-xs mb-0" style="line-height: 1.2;">Total keterlambatan bulan ini</p>
              </div>
              
              <div class="p-2 text-center d-block d-md-none">
                <h5 class="text-gradient text-dark mb-0"> <span id="state2_mobile" countTo="{{ $totalTerlambat }}">{{ $totalTerlambat }}</span></h5>
                <h6 class="mt-1 text-custom-color" style="font-size: 0.8rem;">Terlambat</h6>
              </div>
  
              <hr class="vertical dark d-none d-md-block">
            </div>
            
            <div class="col-4">
              
              <div class="p-3 text-center d-none d-md-block">
                <h3 class="text-gradient text-dark mb-0" id="state3_desktop" countTo="{{ $totalIzinSakit }}">{{ $totalIzinSakit }}</h3>
                <h6 class="mt-2 text-custom-color">Izin / Sakit</h6>
                <p class="text-xs mb-0" style="line-height: 1.2;">Total Izin/Sakit bulan ini</p>
              </div>
              
              <div class="p-2 text-center d-block d-md-none">
                <h5 class="text-gradient text-dark mb-0" id="state3_mobile" countTo="{{ $totalIzinSakit }}">{{ $totalIzinSakit }}</h5>
                <h6 class="mt-1 text-custom-color" style="font-size: 0.8rem;">Izin / Sakit</h6>
              </div>
  
            </div>
  
          </div>
        </div>
      </div>
    </div>
  </section>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto" id="kartu-absen"> 
            
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h5 class="text-white text-capitalize ps-3">Absensi Harian</h5>
                    </div>
                </div>
                <div class="card-body">

                    <div class="text-center mb-3">
        
                    <h6 class="text-custom-color font-weight-normal mb-1">
                        {{ \Carbon\Carbon::now()->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}
                    </h6>
                    
                    <h1 id="realtime-clock" class="font-weight-bolder text-custom-color" style="font-size: 3rem;">
                        --:--:--
                    </h1>
                    </div>

                    <form action="{{ route('absensi.store') }}" method="POST" id="formAbsen">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button type="submit" 
                                        id="btnAbsenMasuk"
                                        class="btn btn-lg w-100 {{ !$attendanceToday ? 'btn-custom-purple-solid' : 'btn-secondary' }}"
                                        {{ !$attendanceToday ? '' : 'disabled' }}>
                                    
                                    <i class="material-icons text-sm me-2">login</i>
                                    {{ __('Absen Masuk') }}
                                    
                                    @if($attendanceToday && $attendanceToday->jam_masuk)
                                        <span class="d-block text-xs">({{ \Carbon\Carbon::parse($attendanceToday->jam_masuk)->format('H:i') }})</span>
                                    @endif
                                </button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="submit" 
                                        id="btnAbsenPulang"
                                        class="btn btn-lg w-100 {{ ($attendanceToday && !$attendanceToday->jam_pulang && in_array($attendanceToday->status_kehadiran, ['H', 'T'])) ? 'btn-custom-purple-solid' : 'btn-secondary' }}"
                                        {{ ($attendanceToday && !$attendanceToday->jam_pulang && in_array($attendanceToday->status_kehadiran, ['H', 'T'])) ? '' : 'disabled' }}>
                                    
                                    <i class="material-icons text-sm me-2">logout</i>
                                    {{ __('Absen Pulang') }}

                                    @if($attendanceToday && $attendanceToday->jam_pulang)
                                        <span class="d-block text-xs">({{ \Carbon\Carbon::parse($attendanceToday->jam_pulang)->format('H:i') }})</span>
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Ada masalah dengan GPS?
                            <a href="{{ route('pengajuan.create') }}" class="text-primary font-weight-bold">
                                Buat Pengajuan Manual
                            </a>
                        </small>
                    </div>

                </div> </div> </div> </div> </div> <div class="modal fade" id="gpsErrorModal" tabindex="-1" aria-labelledby="gpsErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gpsErrorModalLabel">Absen Gagal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <i class="material-icons text-danger" style="font-size: 4rem;">error_outline</i>
        <p class="mt-3 text-custom-color" id="gpsErrorModalMessage">
            Pesan error akan muncul di sini.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const clockElement = document.getElementById('realtime-clock');
            
            function updateClock() {
                const now = new Date();
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                const s = String(now.getSeconds()).padStart(2, '0');
                if (clockElement) {
                    clockElement.innerText = `${h}:${m}:${s}`;
                }
            }
            updateClock(); 
            setInterval(updateClock, 1000);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const gpsErrorModal = new bootstrap.Modal(document.getElementById('gpsErrorModal'));
            const gpsErrorModalMessage = document.getElementById('gpsErrorModalMessage');

            if ("geolocation" in navigator) {
                const btnAbsenMasuk = document.getElementById('btnAbsenMasuk');
                const btnAbsenPulang = document.getElementById('btnAbsenPulang');
                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');

                navigator.geolocation.getCurrentPosition(
                    
                    function(position) {
                        latitudeInput.value = position.coords.latitude;
                        longitudeInput.value = position.coords.longitude;
                        
                        if(btnAbsenMasuk) btnAbsenMasuk.disabled = btnAbsenMasuk.hasAttribute('disabled');
                        if(btnAbsenPulang) btnAbsenPulang.disabled = btnAbsenPulang.hasAttribute('disabled');
                    }, 
                    
                    function(error) {
                        let errorMessage = 'Gagal mendapatkan lokasi: ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += "Anda menolak izin akses lokasi.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += "Informasi lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                errorMessage += "Waktu permintaan lokasi habis.";
                                break;
                            default:
                                errorMessage += "Terjadi kesalahan tidak diketahui.";
                        }
                        
                        gpsErrorModalMessage.innerText = errorMessage;
                        gpsErrorModal.show();

                        if(btnAbsenMasuk) btnAbsenMasuk.disabled = btnAbsenMasuk.hasAttribute('disabled');
                        if(btnAbsenPulang) btnAbsenPulang.disabled = btnAbsenPulang.hasAttribute('disabled');
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );

            } else {
               gpsErrorModalMessage.innerText = 'Browser Anda tidak mendukung Geolocation. Silakan gunakan browser lain.';
               gpsErrorModal.show();
            }
            @if (session('modal_error'))
                gpsErrorModalMessage.innerText = @json(session('modal_error'));
                gpsErrorModal.show();
            @endif
        });
</script>

<script src="{{ asset('assets') }}/js/plugins/countup.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('state1_desktop')) {
                new CountUp('state1_desktop', document.getElementById('state1_desktop').getAttribute('countTo')).start();
                new CountUp('state1_mobile', document.getElementById('state1_mobile').getAttribute('countTo')).start();
            }
            if (document.getElementById('state2_desktop')) {
                new CountUp('state2_desktop', document.getElementById('state2_desktop').getAttribute('countTo')).start();
                new CountUp('state2_mobile', document.getElementById('state2_mobile').getAttribute('countTo')).start();
            }
            if (document.getElementById('state3_desktop')) {
                new CountUp('state3_desktop', document.getElementById('state3_desktop').getAttribute('countTo')).start();
                new CountUp('state3_mobile', document.getElementById('state3_mobile').getAttribute('countTo')).start();
            }
        });
    </script>
@endpush