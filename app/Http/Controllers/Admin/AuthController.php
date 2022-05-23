<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin(){
        return Inertia::render('Admin/Login');
    }

    public function authenticateAdmnin(Request $request){

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($credentials)){
            return redirect('/task')->with('success','Welcome '.Auth::user()->name);
        }
        else{
            return redirect()->back()->with('error','Email and Password does not match');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function showResetPassword(){

        return Inertia::render('Admin/ResetPassword');
    }

    public function resetPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:5'
        ]);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect('/login')->with('info','Change Password Successfully. Please Login Again.');
    }

    public function showRegister(){
        return Inertia::render('Admin/Register');
    }

    public function postRegister(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:5'
        ]);
        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect('/task')->with('success','Welcome '.$request->name);
        }
    }
}
