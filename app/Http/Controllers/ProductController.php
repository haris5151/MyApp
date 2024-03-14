<?php

namespace App\Http\Controllers;

use App\Models\MdProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createProduct(Request $request)
    {
        
    
                $validator = Validator::make($request->all(), [
                    'name' => ['required'],
                    'price' => ['required'],
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
        
        
                $MdProduct = new MdProduct([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'description' => $request->input('description'),
                    'is_active' => $request->input('is_active'),
                ]);
                
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $destinationPath = public_path('image/product_img/');
                    $imageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $imageName);
                    $MdProduct->image = $imageName;
                }
                
        
                $MdProduct->save();
        
                return response()->json(['success' => 'Product Add Successfully!', 'data' => $MdProduct]);
        
          
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
        $MdProduct = MdProduct::find($id);
        return response()->json($MdProduct);
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
            'price' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $MdProduct = MdProduct::find($id);
        $MdProduct->name = $request->input('name');
        $MdProduct->price=$request->input('price');
        $MdProduct->description = $request->input('description');
        $MdProduct->is_active = $request->input('is_active');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('image/product_img/');
            $imageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            
            if ($MdProduct->image) {
                $previousImagePath = $destinationPath . $MdProduct->image;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
    
    
            $MdProduct->image = $imageName;
        }

        $MdProduct->save();

        return response()->json(['success' => 'Product updated!', 'data' => $MdProduct]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
