<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator; 
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse 
    {
        

        $validator = Validator::make($request->all(), [
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'identifier.required' => 'Kolom NIP atau Email wajib diisi.',
            'password.required' => 'Kolom Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return Redirect::route('login')
                        ->withErrors($validator)
                        ->withInput($request->except('password'));
        }


        $loginField = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

        $identifier = $request->identifier;
        $loginField = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
            if ($loginField === 'nip') {
                $identifier = preg_replace('/[^0-9]/', '', $identifier);
            }
            $credentials = [
                $loginField => $identifier,
                'password' => $request->password,
            ];
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                Auth::logoutOtherDevices($request->password);

                return redirect()->intended(route('dashboard', absolute: false));
            }
            return back()->withErrors([
                'identifier' => trans('NIP/Email atau Password yang Anda masukkan salah.'), 
            ])->onlyInput('identifier');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}