<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userFormController extends Controller
{
    public function processForm(Request $request)
    {
        // Validate form data (uncomment if needed)
        // $validator = Validator::make($request->all(), [
        //     'user_name' => 'required|string',
        //     'password' => 'required|integer',
        //     'email' => 'required|string',
        //     'phon'' => 'required|string',
        //     'role' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 400);
        // }

        // Save form data to the database
        $user = new User();
        $user->user_id = $request->input('user_id');
        $user->user_name= $request->input('user_name');
        $user->password = $request->input('password');
        $user->email= $request->input('email');
        $user->phon = $request->input('phon');
        $user->role= $request->input('role');
        $user->save();
        return response([
            'message' => 'Form Submitted'
        ]);
    }
}




