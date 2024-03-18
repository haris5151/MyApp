<?php

namespace App\Http\Controllers;

use App\Models\TdOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order=TdOrder::all();
        return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOrder(Request $request)
    {
        $validator=validator::make($request->all(),[
            'cd_company_id'=>['required'],
            'cd_branch_id'=>['required']

        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],400);
        }
        $TdOrder=new TdOrder([
            'cd_company_id'=>$request->input('cd_company_id'),
            'cd_branch_id'=>$request->input('cd_branch_id'),
            'description'=>$request->input('description'),
            'is_active'=>$request->input('is_active')
            
        ]);

        $TdOrder->save();

        return response()->json(['success' => 'Order Add Successfully!', 'data' => $TdOrder]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order=TdOrder::find($id);
        return response()->json($order);
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
        $validator=validator::make($request->all(),[
            'cd_company_id'=>['required'],
            'cd_branch_id'=>['required']

        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],400);
        }


        $TdOrder = TdOrder::find($id);
        $TdOrder->cd_company_id = $request->input('cd_company_id');
        $TdOrder->cd_branch_id = $request->input('cd_branch_id');
        $TdOrder->description = $request->input('description');
        $TdOrder->is_active = $request->input('is_active');

        $TdOrder->save();

        return response()->json(['success' => 'Order updated!', 'data' => $TdOrder]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
