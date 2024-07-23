<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\realestate;
use App\Models\realestatedescription;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please provide a search query',
            ], 400);
        }

        $products = realestate::where('name', 'like', '%' . $query . '%')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Search results',
            'data' => $products,
        ]);
    }

    public function getFilters()
    {
        $address = realestatedescription::distinct()->pluck('address');
        $description = realestatedescription::distinct()->orderBy('description', 'asc')->pluck('description');
        $ealestate_num = realestatedescription::distinct()->pluck('ealestate_num');
        $space= realestatedescription::distinct()->pluck('space');
        $floor = realestatedescription::distinct()->pluck('floor');
        $bathroom= realestatedescription::distinct()->orderBy('bathroom', 'asc')->pluck('bathroom');
        $bedroom = realestatedescription::distinct()->pluck('bedroom');
        $price= realestatedescription::distinct()->pluck('price');
        $status = realestatedescription::distinct()->pluck('status');
        $owner_name= realestatedescription::distinct()->pluck('owner_name');
     ;

        // Prepare the response data
        $filters = [
            'address' => $address,
            'description' => $description,
            'realestate_num' => $realestate_num,
            'space' => $space,
            'floor' => $floor,
            'bathroom' => $bathroom,
            'bedroom' => $bedroom,
            'price' => $price,
            'status' => $status,
            'owner_name' => $owner_name,
            'companies' => $companies,
        ];
        // Return the response
        return response()->json($filters);
    }

    public function handleCheckboxSubmission(Request $request)
    {
        // Retrieve selected categories, ages, holidays, skill developments, and companies
        $selectedaddress = $request->input('address', []);
        $selecteddescription = $request->input('description', []);
        $selectedrealestate_num = $request->input('realestate_num', []);
        $selectedspace = $request->input('space', []);
        $selectefloor= $request->input('floor', []);
        $selectedbathroom = $request->input('bathroom', []);
        $selectedrbedroom = $request->input('bedroom', []);
        $selectedprice= $request->input('price', []);
        $selectedstatus= $request->input('status', []);
        $selectedowner_name= $request->input('owner_name', []);
        $selectedCompanies = $request->input('companies', []);

        // Query realestates based on selected criteria 
        $realestate = realestate::with(['realestate_description'])
            ->whereHas('realestate_description', function ($query) use ($selectedCompanies,  $selectedaddress ,  $selecteddescription , $selectedrealestate_num , $selectedspace ,  $selectefloor, $selectedbathroom , $selectedrbedroom , $selectedprice , $selectedstatus , $selectedowner_name ) {
                // Applying filters if there are multiple criteria specified

                $query->when(!empty( $selectedaddress ), function ($q) use ( $selectedaddress ) {
                    $q->whereIn('address',  $selectedaddress );
                });
                $query->when(!empty( $selecteddescription), function ($q) use ( $selecteddescription) {
                    $q->whereIn('description',  $selecteddescription);
                });
                $query->when(!empty($selectedrealestate_num ), function ($q) use ($selectedrealestate_num ) {
                    $q->whereIn('realestate_num',$selectedrealestate_num );
                });
                $query->when(!empty($selectedspace ), function ($q) use ($selectedspace ) {
                    $q->whereIn('space ', $selectedspace );
                });

                $query->when(!empty( $selectefloor), function ($q) use ( $selectefloor ) {
                    $q->whereIn('floor', $selectefloor );
                });
                $query->when(!empty(  $selectedbathroom ), function ($q) use (  $selectedbathroom  ) {
                    $q->whereIn('bathroom )',  $selectedbathroom );
                });
                $query->when(!empty( $selectedrbedroom  ), function ($q) use ( $selectedrbedroom  ) {
                    $q->whereIn(' bedroom ',  $selectedrbedroom  );

                    $query->when(!empty($price), function ($q) use ($price) {
                        if (isset($price['min']) && isset($price['max'])) {
                            $q->whereBetween('price', [$price['min'], $price['max']]);
                        }
                });
                $query->when(!empty(  $selectedstatus ), function ($q) use (  $selectedstatus) {
                    $q->whereIn('status',  $selectedstatus);
                });
                $query->when(!empty(  $selectedowner_name ), function ($q) use (  $selectedowner_name) {
                    $q->whereIn('owner_name',  $selectedowner_name);
                }); 
                });
            })
            ->get();

        // Return the filtered realestates along 
        return response()->json([
            'realestate' => $realestate,
        ]);
    }

    public function getFilteredrealestates(Request $request)
    {
        // Retrieve selected address,description, realestate_num, space, ,floor,bathroom,bedroom,,pric,status,owner_name and companies
        $selectedaddress = $request->input('address', []);
        $selecteddescription = $request->input('description', []);
        $selectedrealestate_num = $request->input('realestate_num', []);
        $selectedspace = $request->input('space', []);
        $selectefloor= $request->input('floor', []);
        $selectedbathroom = $request->input('bathroom', []);
        $selectedrbedroom = $request->input('bedroom', []);
        $selectedprice= $request->input('price', []);
        $selectedstatus= $request->input('status', []);
        $selectedowner_name= $request->input('owner_name', []);
        $selectedCompanies = $request->input('companies', []);


        // Query realestate based on selected criteria 
        $realestate = realestate::with(['realestate_description'])
        ->whereHas('realestate_description', function ($query) use ($selectedCompanies,  $selectedaddress ,  $selecteddescription , $selectedrealestate_num , $selectedspace ,  $selectefloor, $selectedbathroom , $selectedrbedroom , $selectedprice , $selectedstatus , $selectedowner_name ) {
            // Applying filters if there are multiple criteria specified
       
            $query->when(!empty( $selectedaddress ), function ($q) use ( $selectedaddress ) {
                $q->whereIn('address',  $selectedaddress );
            });
            $query->when(!empty( $selecteddescription), function ($q) use ( $selecteddescription) {
                $q->whereIn('description',  $selecteddescription);
            });
            $query->when(!empty($selectedrealestate_num ), function ($q) use ($selectedrealestate_num ) {
                $q->whereIn('realestate_num',$selectedrealestate_num );
            });
            $query->when(!empty($selectedspace ), function ($q) use ($selectedspace ) {
                $q->whereIn('space ', $selectedspace );
            });

            $query->when(!empty( $selectefloor), function ($q) use ( $selectefloor ) {
                $q->whereIn('floor', $selectefloor );
            });
            $query->when(!empty(  $selectedbathroom ), function ($q) use (  $selectedbathroom  ) {
                $q->whereIn('bathroom )',  $selectedbathroom );
            });
            $query->when(!empty( $selectedrbedroom  ), function ($q) use ( $selectedrbedroom  ) {
                $q->whereIn(' bedroom ',  $selectedrbedroom  );

                $query->when(!empty($price), function ($q) use ($price) {
                    if (isset($price['min']) && isset($price['max'])) {
                        $q->whereBetween('price', [$price['min'], $price['max']]);
                    }
            });
            $query->when(!empty(  $selectedstatus ), function ($q) use (  $selectedstatus) {
                $q->whereIn('status',  $selectedstatus);
            });
            $query->when(!empty(  $selectedowner_name ), function ($q) use (  $selectedowner_name) {
                $q->whereIn('owner_name',  $selectedowner_name);
            }); 
            });
        })
            ->get();

        // Return the filtered realestates along 
        return response()->json([
            'trealestate' => $trealestate,
        ]);
    }
}

