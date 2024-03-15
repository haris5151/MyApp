<?php

namespace App\Http\Controllers;

use App\Models\MdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services=MdService::all();
        return response()->json($services);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createService(Request $request)
    {
        $validator=Validator::make($request->all(),[

            'name'=>['required']
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],400);

        }

        $MdService=new MdService([

            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'description'=>$request->input('description'),
            'is_active'=>$request->input('is_active'),
            'cd_company_id' => $request->input('cd_company_id'),

        ]);

        $MdService->save();

        return response()->json(['success'=>'Service Create Successfully!','data'=>$MdService]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $services=MdService::find($id);
        return response()->json($services);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'name'=>['required']
        ]);

        if($validator->fails()){

            return response()->json(['errors'=>$validator->errors()],400);
        }

        $MdService=MdService::find($id);
        $MdService->name=$request->input('name');
        $MdService->price=$request->input('price');
        $MdService->description=$request->input('description');
        $MdService->is_active=$request->input('is_active');
        $MdService->cd_company_id = $request->input('cd_company_id');

        $MdService->save();

        return response()->json(['success'=>'service update successfully','data'=>$MdService]);


    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
