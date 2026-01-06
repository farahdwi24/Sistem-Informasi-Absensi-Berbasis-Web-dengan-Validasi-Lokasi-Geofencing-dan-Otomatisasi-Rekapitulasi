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
                                    <h3 class="text-white font-weight-bolder mt-2 mb-0">BUAT PASSWORD BARU</h3>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <form role="form" class="text-start" method="POST" action="{{ route('password.store') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <div class="input-group input-group-outline my-3 is-filled">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="{{ old('email', $request->email) }}" 
                                               required readonly>
                                    </div>
                                    @error('email')
                                        <p class='text-danger text-xs mt-n2'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" name="password" required autofocus>
                                    </div>
                                    @error('password')
                                        <p class='text-danger text-xs mt-n2'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                    @error('password_confirmation')
                                        <p class='text-danger text-xs mt-n2'>{{ $message }} </p>
                                    @enderror

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-custom-purple-solid w-100 my-4 mb-2">
                                            {{ __('Simpan') }}
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