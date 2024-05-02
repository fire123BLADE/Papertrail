<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
           'email'=>'required',
            'password'=>'required|min:5|max:12'
        ]);



        $ $user=User::where('email','=',$request->email)->first();
        if($user){
            if (Hash::check($request->password,$user->password)){
                $request->session()->put('loginId',$user->id);
                return redirect('/dashboard');
            }else{
                Alert::error('Something is wrong !!',"Password not matches !!");
                return redirect('/login');
            }
        }else{
            Alert::error('Something is wrong !!','This email is not registered !!');
            return redirect('/login');
        }
    }
}