<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\CdCountry;
use App\Models\City;

class DropdownController extends Controller
{

    // public function index()
    // {
    //     $data =  CdCountry::all();
    //     return response()->json($data);
    // }
    public function fetchCountry(){
        return City::groupBy("country")->select("country")->get()->pluck("country");
    }
    
    public function fetchCity($country){
        return City::where("country",$country)->select("city")->get()->pluck("city");
    }
}
