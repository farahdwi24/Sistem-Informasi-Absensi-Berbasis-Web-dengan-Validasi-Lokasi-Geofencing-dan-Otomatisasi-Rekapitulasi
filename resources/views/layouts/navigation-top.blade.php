@props(['activePage'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="true">
    <div class="container-fluid py-1 px-3">  
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-5 me-5">
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    @if ($activePage == 'dashboard')
                        Dashboard
                    @elseif ($activePage == 'manajemen-lokasi')
                        Manajemen Lokasi
                    @elseif ($activePage == 'manajemen-pegawai')
                        Manajemen Pegawai
                    @elseif ($activePage == 'persetujuan')
                        Persetujuan
                    @elseif ($activePage == 'absensi')
                        Absensi
                    @elseif ($activePage == 'riwayat-absensi')
                        Riwayat Absensi
                    @elseif ($activePage == 'buat-pengajuan')
                        Buat Pengajuan
                    @elseif ($activePage == 'profile')
                        Profile
                    @else
                        {{ $activePage }}
                    @endif
                </li>
            </ol>
        </nav>
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>

            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown d-flex align-items-center pe-2 me-3">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownNotificationButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons cursor-pointer" id="notification-icon">notifications</i>
                        
                        @if($notificationCount > 0)
                        <span class="position-absolute top-10 start-80 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">Notifikasi baru</span>
                        </span>
                        @endif
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4 dropdown-menu-responsive" aria-labelledby="dropdownNotificationButton">
                        
                        <li class="mb-2">
                            <h6 class="text-center mb-0 text-custom-color">Notifikasi</h6>
                        </li>

                        <div style="max-height: 400px; overflow-y: auto;">
                            @forelse($unreadNotifications as $notification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="{{ $notification->data['url'] }}">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-icons opacity-10 me-3 {{ $notification->data['color'] ?? 'text-info' }}">{{ $notification->data['icon'] }}
                                                </i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    {{ $notification->data['message'] }}
                                                </h6>
                                                <p class="text-xs text-secondary mb-0"><i class="fa fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <p class="text-xs text-secondary mb-0 text-center">Tidak ada notifikasi baru.</p>
                                    </a>
                                </li>
                            @endforelse
                            
                        </div> 
                        <li class="mt-2">
                            @if($notificationCount > 5 && !request()->has('show_all_notifications'))
                                <a class="dropdown-item border-radius-md text-center text-primary" 
                                   href="{{ request()->fullUrlWithQuery(['show_all_notifications' => 'true']) }}">
                                    <span class="font-weight-bold">Lihat Semua ({{ $notificationCount }}) Notifikasi</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown d-flex align-items-center pe-2">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownProfileButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            
                            @if (Auth::user()->foto)
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="avatar avatar-sm me-1 border-radius-lg">
                            @else
                                <div class="avatar avatar-sm me-1 bg-dark d-flex justify-content-center align-items-center border-radius-lg">
                                    <span class="text-white text-xs font-weight-bold">{{ substr(Auth::user()->nama_lengkap ?? '?', 0, 1) }}</span>
                                </div>
                            @endif
                            
                            <span class="d-sm-inline d-none">{{ Auth::user()->nama_lengkap }}</span>
                            
                            <i class="material-icons opacity-10 ms-1" style="font-size: 1.2rem;">arrow_drop_down</i>
                
                        </div>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownProfileButton">   
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('profile.edit') }}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="material-icons opacity-10 me-3">person</i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Profile Saya</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-nav">
                                @csrf
                            </form>
                            <a class="dropdown-item border-radius-md" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="material-icons opacity-10 me-3">logout</i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Log Out</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>