<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Registercontroller extends Controller
{
    public function index()
    {
        return view ('registerr');
     
    }
    public function registre(Request $request)
    {
       $validator=
            Validator::make($request -> all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
       if ($validator->fails()){
        return redirect()->back()-> withErrors ($validator)->withinput();
       }
            $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    //   return redirect() ->route('login')->with('success',
      //  'Registration successful , please log in.');
}
}
