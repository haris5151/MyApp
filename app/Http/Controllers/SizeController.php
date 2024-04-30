<?php

namespace App\Http\Controllers;

use App\Models\MdSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    public function index()
    {
        $size=MdSize::all();
        return response()->json($size);
    }

    public function create(Request $request)
    {
        
        $mdsize=new mdsize([
            'size_name'=>$request->input('size_name'),
            'chest_width'=>$request->input('chest_width'),
            'waist_width'=>$request->input('waist_width'),
            'sleeve_length'=>$request->input('sleeve_length'),
            'shoulder_width'=>$request->input('shoulder_width'),
            'shirt_length'=>$request->input('shirt_length'),
            'collar'=>$request->input('collar'),
            'pent_length'=>$request->input('pent_length'),
            'gender'=>$request->input('gender'),
            'description'=>$request->input('description'),
            'created_by'=>$request->input('created_by'),
            'updated_by'=>$request->input('updated_by'),

            'is_active'=>$request->input('is_active')
            
        ]);

        $mdsize->save();

        return response()->json(['success' => 'Size Add Successfully!', 'data' => $mdsize]);


    }

    public function show(string $id)
    {
        $size=MdSize::find($id);
        return response()->json($size);
    }


    public function update(Request $request, string $id)
    {
        


        $mdsize = mdsize::find($id);
        $mdsize->size_name = $request->input('size_name');
        $mdsize->chest_width = $request->input('chest_width');
        $mdsize->waist_width = $request->input('waist_width');
        $mdsize->sleeve_length = $request->input('sleeve_length');
        $mdsize->shoulder_width = $request->input('shoulder_width');
        $mdsize->shirt_length = $request->input('shirt_length');
        $mdsize->collar = $request->input('collar');
        $mdsize->pent_length = $request->input('pent_length');
        $mdsize->gender = $request->input('gender');
        $mdsize->description = $request->input('description');

        $mdsize->is_active = $request->input('is_active');

        $mdsize->save();

        return response()->json(['success' => 'Order updated!', 'data' => $mdsize]);


    }

}
