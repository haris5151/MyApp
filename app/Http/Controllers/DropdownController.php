<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CdCountry;
use App\Models\CdState;
use App\Models\CdCity;

class DropdownController extends Controller
{
    public function fetchCountry(){
        $data['cd_countries']=CdCountry::get(['name','id']);
        return response()->json($data);

    }
    public function fetchState(Request $request){

       
        $cd_country_id = $request->input('cd_country_id');
        $data['cd_states'] = CdState::where('cd_country_id', $cd_country_id)->get(['name','id']);
        return response()->json($data);
       

    }
    public function fetchCity(Request $request){
        
        $cd_state_id = $request->input('cd_state_id');
        $data['cd_cities']=CdCity::where('cd_state_id', $cd_state_id)->get(['name','id']);
        return response()->json($data);
       

    }
}
