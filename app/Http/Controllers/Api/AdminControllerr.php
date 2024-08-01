<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\realestate;
use App\Models\realestatedescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function addrealestate(Request $request)
    {
        
        // // Create a new realestateDescription instance
        $realestatedescription= new realestatedescription();
        $realestatedescription->address= $request->input('address');
        $realestatedescription->description = $request->input('description');
        $realestatedescription->realestate_num= $request->input('realestate_num');
        $realestatedescription->space = $request->input('space');
        $realestatedescription->floor = $request->input('floor');
        $realestatedescription->bathroom = $request->input('price');
        $realestatedescriptionn->status = $request->input('status');
        $realestatedescription->owner_name= $request->input('owner_name');
        $realestatedescription->user_id = $request->input('user_id');
        $realestatedescription->state_id = $request->input('state_id');
        $realestatedescription->place_id= $request->input('place_id');
        $realestatedescription->save();

        // Handle image upload
        $ImageFile = $request->file('image');
        $ImagePath = ('/img'); // Set the path where you want to store cover images
        $uniqueImageFileName = uniqid() . '.' . $ImageFile->getClientOriginalExtension();
        $ImageFile->move(public_path($ImagePath), $uniqueImageFileName);

        // Create a new realestate instance
        $realestate= new realestate();
        $realestate->name = $request->input('name');
        $realestate->realestate_description = $realestate_description->id;
        $realestate->price = $request->input('price');
        $realestateoy->image = 'http://localhost:8000' . $ImagePath . '/' . $uniqueImageFileName;
        $realestate>save();

        // Redirect back to dashboard with success message
        return response()->json(['success' => true, 'message' => 'realestate added successfully!'], 200);
    }

    public function updaterealestate(Request $request, $id)
    {
        // Retrieve the realestate edit
        $realestate = realestate::findOrFail($id);
        $ImageFile = $request->file('image');

        // Update the associated realestate Description

        $realestatedescription->address= $request->input('address');
        $realestatedescription->description = $request->input('description');
        $realestatedescription->realestate_num= $request->input('realestate_num');
        $realestatedescription->space = $request->input('space');
        $realestatedescription->floor = $request->input('floor');
        $realestatedescription->bathroom = $request->input('price');
        $realestatedescriptionn->status = $request->input('status');
        $realestatedescription->owner_name= $request->input('owner_name');
        $realestatedescription->user_id = $request->input('user_id');
        $realestatedescription->state_id = $request->input('state_id');
        $realestatedescription->place_id= $request->input('place_id');
        $realestatedescription->save();

        $ImagePath = '/img'; // Set the default image path
        $uniqueImageFileName = null; // Define $uniqueImageFileName with a default value

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $ImageFile = $request->file('image');
            // Set the path where you want to store cover images
            $uniqueImageFileName = uniqid() . '.' . $ImageFile->getClientOriginalExtension();
            $ImageFile->move(public_path($ImagePath), $uniqueImageFileName);
        }
        
        // Update other realestate details
        $realestate->name = $request->input('name');
        $realestate->image = $request->input('image');
        $realestate->realestate_description= $request->input('realestate_description');

        // Check if $uniqueImageFileName is not null before using it
        if ($uniqueImageFileName !== null) {
            $realestate->image = 'http://localhost:8000' . $ImagePath . '/' . $uniqueImageFileName;
        }
        $realestate>save();

        // Redirect back to dashboard with success message
        return response()->json([
            'success' => true,
            'message' => 'realestate updated successfully!'
        ], 200);
    }


    public function delete($id)
    {
        try {
            // Find the realestate record by ID
            $realestate= realestate::findOrFail($id);

            // Fetch the associated realestatedescription record
            $realestatedescription = ealestatedescription::where('id', $id)->first();

            // Check if the realestatedescription record exists
            if ($realestatedescription) {
                // Find the realestate record by its ID
                $realestate= realestate::findOrFail($realestatedescription->realestate_id);
                // Delete the associated realestatedescription record
                $realestatedescription->delete();

                // Check if the realestate record exists
                if ($realestate) {
                    // Delete the associated realestate record
                    $realestate->delete();
                }
            }

            // Check if the cover and attachment_url fields are not null or empty
            if (!empty($realestate->image)) {
                // Define file paths
                $imagepath =  $realestate->image;
                //"C:\Users\AbdAljaddar\Desktop\realestatedesmanagment\public\http://localhost:8000/img/65deea21e5943.jpg"
                //the image is in C:\Users\AbdAljaddar\Desktop\realestatedesmanagment\public\img\65dee9a9e1b74.jpg
                // Construct the absolute file paths using public_path
                // Construct the absolute file paths using public_path
                $imageAbsolutePath = public_path('img/' . basename($imagepath));

                // Check if the file exists before attempting to delete it
                if (File::exists($imageAbsolutePath)) {
                    // Delete the image file
                    File::delete($imageAbsolutePath);
                }
            }

            // Delete the realestat record
            $realestate->delete();

            return "realestat Deleted";
        } catch (\Throwable $th) {
            return "error " . $th->getMessage();
        }
    }
}
