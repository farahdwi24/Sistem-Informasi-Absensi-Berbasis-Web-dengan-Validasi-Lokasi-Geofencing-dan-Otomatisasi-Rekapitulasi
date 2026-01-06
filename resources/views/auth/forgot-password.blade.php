<x-guest-layout bodyClass="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100 bg-gradient-custom-purple-white">
            <span class="mask opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-custom-purple-solid shadow-primary border-radius-lg py-3 pe-1 text-center">
                                    <h3 class="text-white font-weight-bolder mt-2 mb-0">RESET PASSWORD</h3>
                                    <p class="text-white mb-2">Masukkan email terdaftar Anda</p>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success text-white font-weight-bold" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form role="form" class="text-start" method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="input-group input-group-outline my-3 @if(old('email')) is-filled @endif">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @error('email')
                                        <p class='text-danger text-xs mt-n2'>{{ $message }} </p>
                                    @enderror

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-custom-purple-solid w-100 my-4 mb-2">
                                            {{ __('Kirim Link Reset') }}
                                        </button>
                                    </div>
                                    
                                    <div class="text-sm text-center">
                                        <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">
                                            &larr; Kembali ke Login
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-guest-layout>