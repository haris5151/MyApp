<?php

namespace App\Http\Controllers;

use App\Models\CdRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = CdRole::all();
        return response()->json($roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createRole(Request $request)
    {
        

            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'role_type' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
    
    
            $CdRole = new CdRole([
    
                'name' => $request->input('name'),
                'role_type'=>$request->input('role_type'),
                'description' => $request->input('description'),
                'is_active' => $request->input('is_active'),
                
                
            
            ]);
    
            $CdRole->save();
    
            return response()->json(['success' => 'Role create successfully!', 'data' => $CdRole]);
    
        
    
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
        $CdRole = CdRole::find($id);
        return response()->json($CdRole);
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
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'role_type' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $CdRole = CdRole::find($id);
        $CdRole->name = $request->input('name');
        $CdRole->role_type = $request->input('role_type');
        $CdRole->description = $request->input('description');
        $CdRole->is_active = $request->input('is_active');

        $CdRole->save();

        return response()->json(['success' => 'Role updated!', 'data' => $CdRole]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
