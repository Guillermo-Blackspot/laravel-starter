<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public const HOME = '/admin/home';
    public const INDEX = '/';

    /**
     * Index view
     */
    public function index()
    {
        return view('app.auth.starter_login');
    }

    /**
     * Do login 
     */
    public function doLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember', false))) {
            return redirect()->route(self::HOME);
        }

        $request->flash();
        
        return back()->with('error','¡Usuario no encontrado!');
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if ($request->confirm == true) {            
            Auth::logout();
            return redirect(self::INDEX);
        }

        return redirect()->back();
    }
}
