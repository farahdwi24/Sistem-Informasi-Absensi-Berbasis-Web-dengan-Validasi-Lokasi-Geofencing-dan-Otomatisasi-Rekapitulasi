<x-guest-layout bodyClass="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100 bg-gradient-custom-purple-white">
            <span class="mask opacity-6"></span> <div class="container my-auto">

                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-custom-purple-solid shadow-primary border-radius-lg py-3 pe-1 text-center">
                                    <h3 class="text-white font-weight-bolder mt-2 mb-0">E-ABSENSI</h3>
                                    <p class="text-white mb-2">UPTD PUSKESMAS SOROPIA</p>
                                    <h5 class="text-white font-weight-bolder mb-0">Login</h5>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                
                                <form role="form" class="text-start" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="input-group input-group-outline my-3 @if(old('identifier')) is-filled @endif">
                                        <label class="form-label">NIP atau Email</label>
                                        <input type="text" class="form-control" name="identifier" value="{{ old('identifier') }}" required>
                                    </div>
                                    <x-input-error :messages="$errors->get('identifier')" class="mt-2 text-danger text-xs" />


                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger text-xs" />


                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label>
                                    </div>

                                    <div class="text-center">
                                       <button type="submit" class="btn btn-custom-purple-solid w-100 my-4 mb-2">Login</button>
                                    </div>
                                    
                                    <div class="text-sm text-center">
                                        <a href="{{ route('password.request') }}" class="text-primary text-gradient font-weight-bold">
                                            Lupa Password?
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