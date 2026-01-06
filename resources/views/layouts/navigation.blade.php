@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-none fixed-start bg-custom-purple-solid"
    id="sidenav-main">
    <div class="sidenav-header pt-3">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-3 font-weight-bold text-white nav-link-text-header ">E-ABSENSI PUSKESMAS SOROPIA</span>
        </a>
    </div>
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav mt-5">

            @if (Auth::user()->role && strtolower(Auth::user()->role->nama_peran) == 'admin')

                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('dashboard') }}">
                        <i class="material-icons opacity-10 me-2">dashboard</i>
                        <span class="nav-link-text ms-1 ">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('admin.locations.*') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('admin.locations.index') }}">
                        <i class="material-icons opacity-10 me-2">map</i>
                        <span class="nav-link-text ms-1">Manajemen Lokasi</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('admin.users.index') }}">
                        <i class="material-icons opacity-10 me-2">groups</i>
                        <span class="nav-link-text ms-1">Manajemen Pegawai</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('admin.persetujuan.*') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('admin.persetujuan.index') }}">
                        <i class="material-icons opacity-10 me-2">task_alt</i>
                        <span class="nav-link-text ms-1 ">Persetujuan</span>
                    </a>
                </li>

            @else

                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('dashboard') }}">
                        <i class="material-icons opacity-10 me-2">fingerprint</i>
                        <span class="nav-link-text ms-1 ">Absensi</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('absensi.index') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('absensi.index') }}">
                        <i class="material-icons opacity-10 me-2">receipt_long</i>
                        <span class="nav-link-text ms-1">Riwayat Absensi</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a class="nav-link text-white {{ request()->routeIs('pengajuan.create') ? ' active bg-purple-lilac' : '' }} "
                        href="{{ route('pengajuan.create') }}">
                        <i class="material-icons opacity-10 me-2">edit_calendar</i>
                        <span class="nav-link-text ms-1">Buat Pengajuan</span>
                    </a>
                </li>
            @endif

            <li class="nav-item my-2">
                <a class="nav-link text-white {{ request()->routeIs('profile.edit') ? ' active bg-purple-lilac' : '' }}  "
                    href="{{ route('profile.edit') }}">
                    <i class="material-icons opacity-10 me-2">person</i>
                    <span class="nav-link-text ms-1 ">Profile Saya</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar"> @csrf </form>
    
            <a class="btn w-100 font-weight-bold"
               style="background-color: white; color: #6A4AA6;" 
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                <i class="material-icons opacity-10 me-2">logout</i>
                Log Out
            </a>
        </div>
    
        <div class="mx-3 mt-3" style="text-align: center;">
            <span class="text-white text-xs" style="font-size: 0.75rem;">© {{ now()->year }} UPTD
                Puskesmas Soropia</span>
        </div>
    </div>
</aside>