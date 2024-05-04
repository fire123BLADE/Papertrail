<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Import the User model

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    
     $user = User::where('username','=',$request->username)->first();
        if($user && Hash::check($request->password, $user->Password)){
            return redirect()->intended('/dashboard');  
        }else{
            return back()->withErrors(['error' => 'Invalid credentials']);}

  
}
}
