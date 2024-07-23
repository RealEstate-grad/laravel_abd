<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Review;
use App\Models\realestate;
use App\Models\realestatedescription;
use Illuminate\Http\Request;

class realestateController extends Controller
{
    public function index()
    {
        $products = realestate::orderByDesc('updated_at')->orderByDesc('created_at')->get();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = realestate::find($id);

        if (!$realestate) {
            return response()->json(['message' => 'realestate not found'], 404);
        }

        $realestate_description = realestatedescription::find($id);
        
        return response()->json([
            'realestate' => $realestate,
            'description' => $realestate_description,
           
        ], 200);
    }

    public function Review(Request $request)
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
        // dd( $profile);
        $user_ids = $profile->user;
        // dd($user_ids);
        foreach ($user_ids as $user_id) {
            $user_id = $user_id->id;
        }
        // dd($user_id);
        $user =User::find($user_id);
        // dd($user->id);
        $review = new Review();
        $review->user_id = $user->id;
        $review->realestate_id = $request->input('realestate_id');
        $review->rating = $request->input('rating');
        // Save the review
        $review->save();

        // You can return a response indicating success or handle errors appropriately
        return response()->json(['message' => 'Review saved successfully'], 200);
    }
}
