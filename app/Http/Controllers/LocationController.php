<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function search(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        // $lat= '31.46599979720397'; 
        // $lon='74.26198825672564';

         $locations= DB::table('cd_branches')
        ->select('cd_branches.id',
            DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                 * cos(radians(cd_branches.latitude))
                 * cos(radians(cd_branches.longitude) - radians(" .$longitude . "))
                 + sin(radians(" . $latitude . "))
                 * sin(radians(cd_branches.latitude))) AS distance")
        )
        ->having('distance', '<', 10) // 10km radius
        ->orderBy('distance')
        ->get();

        return response()->json($locations);
    }
}
