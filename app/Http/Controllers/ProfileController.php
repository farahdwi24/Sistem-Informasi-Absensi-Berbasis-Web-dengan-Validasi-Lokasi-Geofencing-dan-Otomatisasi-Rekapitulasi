<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule; 

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $nipClean = null;
        if ($request->has('nip') && $request->nip != null) {
            $nipClean = preg_replace('/[^0-9]/', '', $request->nip);
            if ($nipClean === '') {
                $nipClean = null; 
            }
        }
        $request->merge(['nip' => $nipClean]);
        $user = $request->user();
        $validatedData = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nip' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'jabatan' => [
                'required', 
                'string', 
                'max:255',
                function ($attribute, $value, $fail) use ($user) {
                    $forbiddenJobs = ['Kepala Puskesmas', 'Koordinator Kepegawaian', 'Bendahara'];
                    if ($user->role->nama_peran != 'Admin') {
                        if (in_array($value, $forbiddenJobs) && $value != $user->jabatan) {
                            $fail('Anda tidak diizinkan memilih jabatan ini.');
                        }
                    }
                }
            ],
            'status_kepegawaian' => ['required', 'in:PNS,P3K,PHL'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'penempatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($user->email !== $validatedData['email']) {
            $validatedData['email_verified_at'] = null;
        }
        
        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $validatedData['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $user->update($validatedData);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        if ($user->foto) Storage::disk('public')->delete($user->foto);
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}