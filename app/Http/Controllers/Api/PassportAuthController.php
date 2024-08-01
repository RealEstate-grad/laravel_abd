<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

use App\Models\Profile;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);


        $user = Profile::create([
            'user_name' => $request->first_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $profileId = $user->id;

        $token = $user->createToken('Register')->accessToken;

        $user= new User();
        $user->profile_id = $profileId; // $profileId is the ID of the associated profile
        $user->save();

        return response()->json(['token' => $token], 200)->header('Location', '/');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // dd($user );
            $token = $user->createToken('Login')->accessToken;

            // Store the token in the api_token column of the Profiles table
            $user->remember_token = $token;
            $user->save();
            return response()->json(['token' => $token], 200)->header('Location', '/');
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function getUserDetails(Request $request)
    {
        // Authenticate the user using the token
        if ($request->header('Authorization')) {
            $token = str_replace('Bearer ', '', $request->header('Authorization'));
            // dd( $token );
            $profile = Profile::where('remember_token', $token)->first();
            // dd( $profile );
            if (!$profile) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
       
        $Name = $profile->user_name ;
        $email = $profile->email;
        // dd($Name);
        $profile_id = $profile->id;
        // dd($profile_id);
        $user_id = $profile->user;
        // dd($user_ids);
        foreach ($user_ids as $user_id ) {
            $user_id = $user_id ->id;
        }
        // dd($user_id);
        $User= User::find($user_id);
        // dd($user);

        if ( $user ) {
            // Retrieve user 
            $user_data = $user->user ->map(function ( $user ) {
                return [
                    'user_id' => $user_id,
                    'user_name' => $user->user_name,
                    'email' => $user >email,
                    'password' => $user->password 
                ]; 
            });
            if ($user_data ->isNotEmpty()) {
                $user = $user_data ->toArray();
            }
        }

        // Return response with user's name, token, and user
        return response()->json([
            'user_id' => $user_id,
            'user_name' => $user->user_name,
            'email' => $user ->email,
            'password' => $user->password
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response([
            'message' => 'Logged out successfully'
        ]);
    }

    public function AdminRegister(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        $user = Profile::create([
            'user_name' => $request->first_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $profileId = $user->id;

        $token = $user->createToken('Register')->accessToken;

        $admin = new Admin();
        $admin->profile_id = $profileId; // $profileId is the ID of the associated profile
        $admin->save();

        return response()->json(['token' => $token], 200)->header('Location', '/');
    }

    public function AdminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Login')->accessToken;

             // Store the token in the api_token column of the Profiles table
             $user->remember_token = $token;
             $user->save();
            return response()->json(['token' => $token], 200)->header('Location', '/');
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

