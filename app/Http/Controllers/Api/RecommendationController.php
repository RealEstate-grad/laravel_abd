<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\realestate ;
use App\Models\realestatedescription;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class RecommendationController extends Controller
{
    public function recommendations(Request $request)
    {
        $user_id = $request->input('user_id');

        // Fetch the user data based on the user_id
        $user = User::find($user_id);
        // Prepare data for Python script (use actual form data)
        $userData = [
            'user_name' => $user->user_name,
            'password' =>$user->password,
            'email' => $use->email,
            'phon' => $use->phon,
            'role' => $use->role,
        ];

        // Query the realestate_description able for relevant data
        $realestatedescription = realestatedescription::all();

        // // Extract relevant fields from realestates descriptions
        $realestatedescription = [];

        foreach ($realestatedescription as $description) {
            $realestatedescription[] = [
                'address' => $description->address,
                'description' => $description->description,
                'realestate_num' => $description->realestate_num,
                'space' => $description->space,
                'floor' => $description->floor,
                'bathroom' => $description->bathroom,
                'bedroom' => $description->bedroom,
                'price' => $description->price,
                'status' => $description->status,
                'owner_name' => $description->owner_name,

            ];
        }
        // dd($realestatedescription Data);

        // Ensure proper JSON encoding and command execution
        $JsonData = json_encode( $userData);
        // Write JSON data to a temporary file
        $tmpFile = tempnam(sys_get_temp_dir(), 'realestates_descriptions_');
        file_put_contents($tmpFile, json_encode($realestatedescriptionData));

        // Prepare command with file path as argument
        $command = [
            'C:\Users\AbdAljabbar\AppData\Local\Programs\Python\Python311\python.exe',
            'C:/Users/AbdAljabbar/Desktop/realestatemanagment/recommendation_algorithm.py',
            $JsonData,
            $tmpFile, // Pass file path as argument
        ];

        // Execute the Python script
        $process = new Process($command);
        $process->run();

        // Clean up temporary file
        unlink($tmpFile);


        // Handle output and potential errors
        if ($process->isSuccessful()) {
            $output = $process->getOutput();

            $matches = [];
            // Use regular expression to extract ID numbers
            preg_match_all('/\s+(\d+)\s+/', $output, $matches);

            // Check if matches are found
            if (!empty($matches[1])) {
                // Extract the first 5 ID numbers
                $idNumbers = array_slice($matches[1], 0, 5);

                // Add 1 to each extracted number
                $idNumbers = array_map(function ($num) {
                    return intval($num) + 1;
                }, $idNumbers);

                // Query the database for realestates based on the extracted IDs
                $realestate= realestate::whereIn('id', $idNumbers)->get();
                $realestates_description = realestatedescription::whereIn('id', $idNumbers)->get();

                // Serialize the realestate data
                $serializeduser = [];
                foreach ($user as $user) {
                    // Find the corresponding description for the current realestate
                    $description = $user_description->firstWhere('id', $realestate->id);
            
                    $serializedrealestates[] = [
                        'id' => $user->id,
                        'user_name' => $realestate->user_name,
                        'address' => $description->address,
                        'description' => $description->description,
                        'realestate_num' => $description->realestate_num,
                        'space' => $description->space,
                        'floor' => $description->floor,
                        'bathroom' => $description->bathroom,
                        'bedroom' => $description->bedroom,
                        'price' => $description->price,
                        'status' => $description->status,
                        'owner_name' => $description->owner_name,
                        'image' => $realestate->image,
                    ];
                }

                // Return the realestates data as JSON response
                return response()->json([
                    'user_id' => $user->id,
                    'realestate' => $serializedrealestate,
                ]);
            } else {
                return response()->json(['error' => 'No recommendations found in output'], 500);
            }
        } else {
            $error = $process->getErrorOutput();
            return response()->json(['error' => $error], 500); // Internal Server Error
        }
    }
}

