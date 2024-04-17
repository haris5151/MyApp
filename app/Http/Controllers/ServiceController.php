<?php

namespace App\Http\Controllers;

use App\Models\MdService;
use App\Models\MdServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth:sanctum','vendor']);
    // }
    public function index()
    {
        $services = MdService::all();
        return response()->json($services);
    }

    public function createService(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'details.*.price' => ['required'],
            'details.*.service_name' => ['required'],
            'details.*.icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Allow icon to be nullable
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Create MdService
        $mdService = new MdService([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active'),
            'cd_company_id' => $request->input('cd_company_id'),
            'cd_branch_id' => $request->input('cd_branch_id'),
        ]);
    
        $mdService->save();
    
        // Create MdServiceDetails
        $serviceDetailsData = [];
        foreach ($request->input('details') as $detail)
         {
            $serviceDetail = new MdServiceDetail([
                'md_service_id' => $mdService->id,
                'service_name' => $detail['service_name'],
                'price' => $detail['price'],
                'description' => $detail['description'] ?? null,
            ]);
    
            // Handle icon files if included
            if (isset($detail['icon']) && is_array($detail['icon'])) 
            {
                foreach ($detail['icon'] as $icon) {
                    if ($icon->isValid()) {
                        $name = date('Y_m_d-H_i_s') . '_' . $this->format_name($icon->getClientOriginalName());
                        $path = 'icon/service_icon/';
                        $iconPath = $icon->storeAs($path, $name, 'public');
                        // Store icon path in an array or another suitable format in your database
                        $serviceDetail->icons()->create(['path' => $iconPath]);
                    }
                }
            }
    
            $serviceDetail->save();
            $serviceDetailsData[] = $serviceDetail;
        }
    
        return response()->json(['success' => 'Service and details created successfully!', 'data' => ['service' => $mdService, 'details' => $serviceDetailsData]]);
    }

// private function handle_files($details, Request $request)
// {
//     foreach ($details as &$detail) {
//         if (isset($detail['icon']) && $detail['icon'] instanceof UploadedFile) {
//             $icon = $detail['icon'];
//             $name = date('Y_m_d-H_i_s') . '_' . $this->format_name($icon->getClientOriginalName());
//             $path = 'icon/service_icon/';
//             $iconPath = $icon->storeAs($path, $name, 'public'); // Store the icon using UploadedFile method
//             $detail['icon'] = $iconPath; // Store the icon path in the detail array
//         }
//     }
//     // Return the modified details array
//     return $details;
// }

    

    /**
     * Show the form for creating a new resource.
     */
    // public function createService(Request $request)
    // {
    //     $validator=Validator::make($request->all(),[

    //         'name'=>['required']
    //     ]);

    //     if($validator->fails()){
    //         return response()->json(['errors'=>$validator->errors()],400);

    //     }

    //     $MdService=new MdService([

    //         'name'=>$request->input('name'),
    //         'price'=>$request->input('price'),
    //         'description'=>$request->input('description'),
    //         'is_active'=>$request->input('is_active'),
    //         'cd_company_id' => $request->input('cd_company_id'),
    //         'cd_branch_id' => $request->input('cd_branch_id'),


    //     ]);

    //     $MdService->save();

    //     return response()->json(['success'=>'Service Create Successfully!','data'=>$MdService]);


    // }
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => ['required'],
    //         'details.*.price' => ['required'],
    //         'details.*.service_name' => ['required'],
    //         // Add validation rules for other fields as needed
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 400);
    //     }
    //     $this->handle_files($request->input('details'));

    //     $mdService = new MdService([
    //         'name' => $request->input('name'),
    //         // 'price' => $request->input('price'),
    //         'description' => $request->input('description'),
    //         'is_active' => $request->input('is_active'),
    //         'cd_company_id' => $request->input('cd_company_id'),
    //         'cd_branch_id' => $request->input('cd_branch_id'),
    //     ]);

    //     $mdService->save();

    //     $serviceDetailsData = [];
    //     foreach ($request->input('details') as $detail) {
    //         $serviceDetail = new MdServiceDetail([
    //             'md_service_id' => $mdService->id,
    //             'service_name' => $detail['service_name'],
    //             'price'=>$detail['price'],
    //             'description' => $detail['description'] ,
    //             'icon' => $detail['icon'] ?? null,
    //         ]);

    //         // if (isset($detail['icon']) && $detail['icon'] instanceof UploadedFile) {
    //         //     $icon = $detail['icon'];
    //         //     $destinationPath = public_path('icon/service_icon/');
    //         //     $iconName = date('YmdHis') . '.' . $icon->getClientOriginalExtension();
    //         //     $icon->move($destinationPath, $iconName);
    //         //     $serviceDetail->icon = $iconName;
    //         // }

    //         $serviceDetail->save();
    //         $serviceDetailsData[] = $serviceDetail;
    //     }

    //     return response()->json(['success' => 'Service and details created successfully!', 'data' => ['service' => $mdService, 'details' => $serviceDetailsData]]);
    // }


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
        $service = MdService::find($id);
        $details = MdServiceDetail::where('md_service_id', $id)->get();

        $mergedData = [
            'service' => $service,
            'details' => $details
        ];

        return response()->json($mergedData);
    }

    public function showBranch($cd_branch_id)
    {
        $services = MdService::where('cd_branch_id', $cd_branch_id)->get();
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
    // {
    //     $validator=Validator::make($request->all(),[
    //         'name'=>['required']
    //     ]);

    //     if($validator->fails()){

    //         return response()->json(['errors'=>$validator->errors()],400);
    //     }

    //     $MdService=MdService::find($id);
    //     $MdService->name=$request->input('name');
    //     $MdService->price=$request->input('price');
    //     $MdService->description=$request->input('description');
    //     $MdService->is_active=$request->input('is_active');
    //     $MdService->cd_company_id = $request->input('cd_company_id');
    //     $MdService->cd_branch_id = $request->input('cd_branch_id');


    //     $MdService->save();

    //     return response()->json(['success'=>'service update successfully','data'=>$MdService]);


    
    // }
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'details.*.price' => ['required'],
            'details.*.service_name' => ['required'],
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update existing service
        $mdService = MdService::find($id);

        $mdService->name = $request->input('name');
        // $mdService->price = $request->input('price');
        $mdService->description = $request->input('description');
        $mdService->is_active = $request->input('is_active');
        $mdService->cd_company_id = $request->input('cd_company_id');
        $mdService->cd_branch_id = $request->input('cd_branch_id');

        $mdService->save();

        // Update associated service details
        foreach ($request->input('details') as $detail) {
            if (isset($detail['id'])) {
                $serviceDetail = MdServiceDetail::find($detail['id']);
            } else {
                $serviceDetail = new MdServiceDetail();
                $serviceDetail->md_service_id = $mdService->id;
            }

            $serviceDetail->service_name = $detail['service_name'];
            $serviceDetail->price=$detail['price'];
            $serviceDetail->description = $detail['description'] ?? null;

            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                $destinationPath = public_path('icon/service_icon/');
                $iconName = date('YmdHis') . '.' . $icon->getClientOriginalExtension();
                $icon->move($destinationPath, $iconName);
                $serviceDetail->icon = $iconName;
            }

            $serviceDetail->save();
        }

        return response()->json(['success' => 'Service and details updated successfully!', 'data' => $mdService->load('details')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
