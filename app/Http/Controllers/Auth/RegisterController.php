<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'username' => 'required|string|max:255|unique:user',
            'password' => 'required|min:8|max:60',
            'department' => 'required|string',
        ]);

        // create a new user instance
        $user = new User();
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->firstname = $request->input('FirstName');
        $user->lastname = $request->input('LastName');
        $user->email = $request->input('email');
        $user->department = $request->input('department');
        
        
    
        // Save the user record to the db
        $user->save();

        //back to login page with a success message
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}

