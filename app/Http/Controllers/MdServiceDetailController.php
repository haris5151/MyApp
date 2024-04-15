<?php

namespace App\Http\Controllers;

use App\Models\MdServiceDetail;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class MdServiceDetailController extends Controller
{

    // public function __construct(){
    //     $this->middleware(['auth:sanctum','vendor']);
    // }
    public function index()
    {
        $servicedetails=MdServiceDetail::all();
        return response()->json($servicedetails);
    }
    public function createServiceDetails(Request $request)
    {
        $validator=validator::make($request->all(),[
            'md_service_id'=>['required'],
            'service_name'=>['required']

        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],400);
        }
        $servicedetail=new MdServiceDetail([
            'md_service_id'=>$request->input('md_service_id'),
            'service_name'=>$request->input('service_name'),
            // 'icon'=>$request->input('icon'),
            'description'=>$request->input('description'),
           
            
        ]);

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
        
            $destinationPath = public_path('icon/service_icon/');
            // if (!file_exists($destinationPath)) {
            //     mkdir($destinationPath, 0777, true);
            // }
            $iconName = date('YmdHis') . '.' . $icon->getClientOriginalExtension();
            $icon->move($destinationPath, $iconName);
            
            $servicedetail->icon = $iconName;
        }

        $servicedetail->save();

        return response()->json(['success' => 'service details Add Successfully!', 'data' => $servicedetail]);


    }
    public function show(string $id)
    {
        $servicedetail=MdServiceDetail::find($id);
        return response()->json($servicedetail);
    }
    public function updateServiceDetails(Request $request,string $id){
        {
            $validator=validator::make($request->all(),[
                'md_service_id'=>['required'],
                'service_name'=>['required']
    
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()],400);
            }
    
    
            $servicedetail = MdServiceDetail::find($id);
            $servicedetail->md_service_id = $request->input('md_service_id');
            $servicedetail->service_name=$request->input('service_name');
            // $servicedetail->icon=$request->input('icon');
            $servicedetail->description = $request->input('description');

            if ($request->hasFile('icons')) {
                $icon = $request->file('icons');
                $destinationPath = public_path('icons/service_icons/');
                $iconName = date('YmdHis') . '.' . $icon->getClientOriginalExtension();
                $icon->move($destinationPath, $iconName);
                
                if ($servicedetail->icon) {
                    $previousIconPath = $destinationPath . $servicedetail->icon;
                    if (file_exists($previousIconPath)) {
                        unlink($previousIconPath);
                    }
                }
        
        
                $servicedetail->icon = $iconName;
            }
            
    
            $servicedetail->save();
    
            return response()->json(['success' => 'service details updated!', 'data' => $servicedetail]);
    
    
        }
    }
}
