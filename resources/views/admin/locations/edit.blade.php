@extends('layouts.app', ['activePage' => 'manajemen-lokasi'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card my-4 shadow-custom-eabsensi">
                <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                    <div class="bg-custom-purple-solid shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Lokasi</h6>
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
                    <form method="POST" action="{{ route('admin.locations.update', $location->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">Nama Lokasi</label>
                                    <input type="text" class="form-control" name="nama_lokasi" 
                                           value="{{ old('nama_lokasi', $location->nama_lokasi) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" 
                                           value="{{ old('latitude', $location->latitude) }}"  required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" 
                                           value="{{ old('longitude', $location->longitude) }}"  required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="input-group input-group-outline is-filled">
                                    <label class="form-label">Radius (dalam meter)</label>
                                    <input type="number" class="form-control" name="radius_meter" 
                                           value="{{ old('radius_meter', $location->radius_meter) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary me-2">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-custom-purple-solid">
                                Perbarui
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection