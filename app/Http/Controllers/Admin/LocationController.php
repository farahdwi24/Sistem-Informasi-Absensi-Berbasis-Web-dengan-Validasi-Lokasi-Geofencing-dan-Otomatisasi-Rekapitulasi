<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $locations = Location::latest()->get();
        
        return view('admin.locations.index', [
            'locations' => $locations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:10',
        ]);

        Location::create($request->all());

        $notif = [
            'title'   => 'Berhasil Ditambahkan',
            'message' => 'Data lokasi baru (' . $request->nama_lokasi . ') telah berhasil ditambahkan.'
        ];
        return redirect()->route('admin.locations.index')->with('success', $notif);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', [
            'location' => $location,
        ]);
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:10',
        ]);

        $location->update($request->all());

        $notif = [
            'title'   => 'Data Tersimpan',
            'message' => 'Perubahan data lokasi (' . $location->nama_lokasi . ') telah berhasil disimpan.'
        ];
        return redirect()->route('admin.locations.index')->with('success', $notif);
    }

    public function destroy(Location $location)
    {
        $namaLokasi = $location->nama_lokasi;
        $location->delete();
        
        $notif = [
            'title'   => 'Data Berhasil Dihapus',
            'message' => 'Data lokasi ' . $namaLokasi . ' telah dihapus dari sistem.'
        ];
        return redirect()->route('admin.locations.index')->with('success', $notif);
        
    }
}
