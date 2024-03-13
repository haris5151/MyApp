<?php

namespace App\Http\Controllers;

use App\Models\CdBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = CdBranch::all();
        return response()->json($branches);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createBranch(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => ['required'],
            'cd_company_id'=>['required','exists:cd_companies,id']

        ]);
        if ($validator->fails()){

            return response()->json(['errors'=>$validator->errors()], 400);

        }

        $CdBranch= new CdBranch([

            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active'),
            'cd_company_id' => $request->input('cd_company_id'),

        ]);

        $CdBranch->save();

        return response()->json(['success'=>'Branch Create Successfully!','data'=>$CdBranch]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $CdBranch = CdBranch::find($id);
        return response()->json($CdBranch);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)

    {

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'cd_company_id'=>['required','exists:cd_companies,id']
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $CdBranch = CdBranch::find($id);
        $CdBranch->name = $request->input('name');
        $CdBranch->address = $request->input('address');
        $CdBranch->description = $request->input('description');
        $CdBranch->is_active = $request->input('is_active');
        $CdBranch->cd_company_id = $request->input('cd_company_id');

        $CdBranch->save();

        return response()->json(['success' => 'Company updated!', 'data' => $CdBranch]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
