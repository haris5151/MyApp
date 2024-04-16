<?php

namespace App\Http\Controllers;

use App\Models\CdCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  public function __construct(){
    //     $this->middleware(['auth:sanctum','vendor']);
    // }
    public function index()

    {
        $companies = CdCompany::all();
         return response()->json($companies);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function createCompany(Request $request)
    // {
    //     $CdCompany = new CdCompany();
    //     $CdCompany->name = $request->name;
    //     $CdCompany->description = $request->description;
    //     $CdCompany->address = $request->address;
    //     $CdCompany->is_active= $request->is_active;
    //     $CdCompany->save();

    //     return response()->json([
    //         "message" => "company created successfully"
    //     ], 201);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function createCompany(Request $request)

    {

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'address' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $CdCompany = new CdCompany([

            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active'),
            'country'=>$request->input('country'),
            'city'=>$request->input('city'),
            'user_id' => $request->input('user_id'),

            
        
        ]);

        $CdCompany->save();

        return response()->json(['success' => 'Company create successfully!', 'data' => $CdCompany]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $CdCompany = CdCompany::find($id);
        return response()->json($CdCompany);
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

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'address' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $CdCompany = CdCompany::find($id);
        $CdCompany->name = $request->input('name');
        $CdCompany->address = $request->input('address');
        $CdCompany->description = $request->input('description');
        $CdCompany->is_active = $request->input('is_active');
        $CdCompany->country=$request->input('country');
        $CdCompany->city=$request->input('city');
        $CdCompany->user_id=$request->input('user_id');



        $CdCompany->save();

        return response()->json(['success' => 'Company updated!', 'data' => $CdCompany]);

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
