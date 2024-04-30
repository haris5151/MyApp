<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function search(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $locations = DB::table('cd_branches')
            ->select('cd_branches.*',
                DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                 * cos(radians(cd_branches.latitude))
                 * cos(radians(cd_branches.longitude) - radians(" . $longitude . "))
                 + sin(radians(" . $latitude . "))
                 * sin(radians(cd_branches.latitude))) AS distance")
            )
            ->having('distance', '<', 10) // 10km radius
            ->orderBy('distance')
            ->get();

        return response()->json($locations);
    }

    public function getNearbyBranches(Request $request ,$userId)
    {
        $user = User::find($userId);

        $userLatitude = $user->latitude;
        $userLongitude = $user->longitude;
        $userCity = $user->city;


    // Query the branches table to find nearby branches

    $nearbyBranches = DB::table('cd_branches')

        ->select('cd_branches.*', DB::raw("6371 * acos(cos(radians(" . $userLatitude . "))
         * cos(radians(cd_branches.latitude)) 
         *  cos(radians(cd_branches.longitude) - radians(" . $userLongitude . "))
         + sin(radians(" . $userLatitude . "))
         * sin(radians(cd_branches.latitude))) AS distance"))
        ->having('distance', '<', 10) // 2km radius

        ->orderBy('distance')

        ->get();

        if ($nearbyBranches->isEmpty()) {

            $allBranches = DB::table('cd_branches')
    
                ->where('city', $userCity)
    
                ->get();
    
    
            $nearbyBranches = $allBranches;
    
        }


    // Return the nearby branches as a JSON response

    return response()->json($nearbyBranches);



    }
}
