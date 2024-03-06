<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

     //INI FUNGSI YANG DIPAKE BUAT REDIRECT LOGIN
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        //ini jangan langsung diredirect
        //harus lewat validasi dulu

        // return redirect()->intended(RouteServiceProvider::HOME);

        //kalau role user nya lebih dari 2
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin');
        }elseif (auth()->user()->role == 'user') {
            return redirect()->route('user');   
        }

        //tapi kalau role nya itu hanya ada 2 pake ini saja [percabangan ternary]
        return redirect()->intended(
            auth()->user()->role == 'admin' ? route('admin') : route('user')
        );

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
