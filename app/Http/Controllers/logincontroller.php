<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class logincontroller extends Controller
{
    public function index()
    { if(Auth::cheack()){
        return redirect()->to('dashbord');
     } else{
            return view ('login');
     }
    } 
    public function login (Request $request)
    {
       $validate= request()->
            validatate( [
                'name' => 'required|',
                'email' => 'required',
                'password' => 'required',
            ]);
       if ($validatate){
        $info= $request->only('email', 'password' );
       if(Auth::attempt($info)){
        return redirect()->to('dashbord');
       }
        return redirect()->to('login');
       
    }
       }
    }  
  
