<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('app.auth.login');
    }


    public function doLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember', false))) {
            return redirect()->route('admin.index');
        }

        $request->flash();
        
        return back()->with('error','Usuario no encontrado');
    }

    public function logout(Request $request)
    {
        if ($request->confirm == true) {            
            Auth::logout();
            return redirect('/');
        }

        return redirect()->back();
    }
}
