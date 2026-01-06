<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        
        $query = User::with('role');
        $search = $request->input('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%')
                  ->orWhere('penempatan', 'like', '%' . $search . '%')
                  ->orWhere('status_kepegawaian', 'like', $search . '%');
            });
        }
        $users = $query->latest()
                    ->paginate(15)
                    ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search ?? '',
        ]);
    }
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $nipClean = null;
        if ($request->has('nip') && $request->nip != null) {
            $nipClean = preg_replace('/[^0-9]/', '', $request->nip);
            if ($nipClean === '') {
                $nipClean = null;
            }
        }
        $request->merge(['nip' => $nipClean]);
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:users,nip',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jabatan' => [
                'required', 'string', 'max:255',
                Rule::unique('users', 'jabatan')
                    ->where(function ($query) {
                        return $query->whereIn('jabatan', ['Kepala Puskesmas', 'Koordinator Kepegawaian', 'Bendahara']);
                    })
            ],
            'status_kepegawaian' => 'required|in:PNS,P3K,PHL',
            'role_id' => 'required|exists:roles,id',
            'penempatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ],
[
        'jabatan.unique' => 'Jabatan ini sudah ada yang mengisi. Harap ubah jabatan pegawai yang lama terlebih dahulu.']
    );

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $nipClean,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'role_id' => $request->role_id,
            'penempatan' => $request->penempatan,
            'foto' => $fotoPath,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        $notif = [
            'title'   => 'Berhasil Ditambahkan',
            'message' => 'Data pegawai baru (' . $request->nama_lengkap . ') telah berhasil ditambahkan.'
        ];
        return redirect()->route('admin.users.index')->with('success', $notif);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $nipClean = null;
        if ($request->has('nip') && $request->nip != null) {
            $nipClean = preg_replace('/[^0-9]/', '', $request->nip);
            if ($nipClean === '') {
                $nipClean = null;
            }
        }
        $request->merge(['nip' => $nipClean]);
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:users,nip,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], 
            'jabatan' => [
                'required', 'string', 'max:255',
                Rule::unique('users', 'jabatan')
                    ->where(function ($query) {
                        return $query->whereIn('jabatan', ['Kepala Puskesmas', 'Koordinator Kepegawaian','Bendahara']);
                    })
                    ->ignore($user->id)
            ],
            'status_kepegawaian' => 'required|in:PNS,P3K,PHL',
            'role_id' => 'required|exists:roles,id',
            'penempatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ], [
            'jabatan.unique' => 'Jabatan ini sudah ada yang mengisi. Harap ubah jabatan pegawai yang lama terlebih dahulu.'
        ]);

        $dataToUpdate = $request->except('password', 'foto');

        $dataToUpdate['nip'] = $nipClean;

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $dataToUpdate['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $user->update($dataToUpdate);

        $notif = [
            'title'   => 'Data Tersimpan',
            'message' => 'Perubahan data pegawai (' . $user->nama_lengkap . ') telah berhasil disimpan.'
        ];
        return redirect()->route('admin.users.index')->with('success', $notif);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $namaPegawai = $user->nama_lengkap;
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        
        $user->delete();
        
        $notif = [
            'title'   => 'Data Berhasil Dihapus',
            'message' => 'Data pegawai ' . $namaPegawai . ' telah dihapus dari sistem.'
        ];
        return redirect()->route('admin.users.index')->with('success', $notif);
    }
}
