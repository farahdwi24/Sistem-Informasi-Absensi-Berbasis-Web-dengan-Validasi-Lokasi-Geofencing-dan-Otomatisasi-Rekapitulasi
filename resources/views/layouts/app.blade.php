<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Absensi UPTD Puskesmas Soropia</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900" />
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-200">

    @include('layouts.navigation') 
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navigation-top')
        
        <div class="container-fluid py-4">
            
            @yield('content') </div>

            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                <div id="toastContainer">
                    </div>
    </main>

    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastContainer = document.getElementById('toastContainer');
        
            function createToast(data, type = 'success') {
                const icons = {
                    success: 'check_circle',
                    error: 'error',
                    info: 'info',
                    warning: 'warning'
                };
        
                const bgColors = {
                    success: 'bg-success',
                    error: 'bg-danger',
                    info: 'bg-info',
                    warning: 'bg-warning'
                };
        
                const alertColors = {
                    success: 'bg-custom-purple-solid',
                    error: 'bg-custom-purple-solid',
                    info: 'bg-custom-purple-solid',
                    warning: 'bg-custom-purple-solid',
                };
        
                const icon = icons[type] || 'fa-info-circle';
                const bgColor = bgColors[type] || 'bg-info';
                const alertColor = alertColors[type] || 'alert-info';
        
                const title = data.title || 'Informasi';
                const message = data.message || 'Terjadi sesuatu.';
        
                const toastEl = document.createElement('div');
                toastEl.classList.add(
                    'alert', alertColor,
                    'border-0', 'd-flex', 'align-items-start',
                    'fade', 'show', 'shadow-sm', 'mb-2', 'p-2', 'rounded'
                );
                toastEl.setAttribute('role', 'alert');
                toastEl.style.width = '100%';
                toastEl.style.maxWidth = '400px';
                toastEl.style.wordBreak = 'break-word';
        
                toastEl.innerHTML = `
                    <div class="${bgColor} me-2 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width:36px; height:36px; min-width:36px;">
                        <span class="material-icons-round text-white">${icon}</span>
                    </div>
                    <div class="flex-grow-1 text-wrap" style="min-width:0;">
                        <strong class="d-block text-truncate text-white">${title}</strong>
                        <small class="text-break d-block text-white">${message}</small>
                    </div>
                    <button type="button" class="btn-close ms-2 flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
        
                toastContainer.appendChild(toastEl);
    
                toastEl.style.transform = 'translateX(120%)';
                toastEl.style.opacity = '0';
                setTimeout(() => {
                    toastEl.style.transition = 'transform 0.4s ease, opacity 0.4s ease';
                    toastEl.style.transform = 'translateX(0)';
                    toastEl.style.opacity = '1';
                }, 10);
                setTimeout(() => {
                    toastEl.style.transform = 'translateX(120%)';
                    toastEl.style.opacity = '0';
                    setTimeout(() => toastEl.remove(), 400);
                }, 5000);
            }

            @if (session('success'))
                createToast(@json(session('success')), 'success');
            @endif
        
            @if (session('error'))
                createToast(@json(session('error')), 'error');
            @endif
        
            @if (session('status') === 'profile-updated')
                createToast({
                    title: 'Data Tersimpan',
                    message: 'Perubahan data pribadi Anda telah berhasil disimpan.'
                }, 'success');
            @endif
        
            @if (session('status') === 'password-updated')
                createToast({
                    title: 'Password Berhasil Diganti',
                    message: 'Perubahan Password Anda telah berhasil disimpan.'
                }, 'success');
            @endif
        });
        </script>
        
        
@stack('js')
</body>
</html>