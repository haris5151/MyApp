<?php

namespace App\Http\Controllers;

use App\Models\MdService;
use App\Models\MdServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $mergedData = [];

        foreach ($services as $service) {
            $details = MdServiceDetail::where('md_service_id', $service->id)->get();
            $mergedData[] = [
                'service' => $service,
                'details' => $details
            ];
        }
        return response()->json($mergedData);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createService(Request $request)
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
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required'],
            'service_name' => ['required'],
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $mdService = new MdService([
            'name' => $request->input('name'),
            // 'price' => $request->input('price'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active'),
            'cd_company_id' => $request->input('cd_company_id'),
            'cd_branch_id' => $request->input('cd_branch_id'),
        ]);

        $mdService->save();

        $serviceDetail = new MdServiceDetail([
            'md_service_id' => $mdService->id,
            'service_name' => $request->input('service_name'),
            'price' => $request->input('price'),
            'description' => $request->input('service_description'),
        ]);

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $destinationPath = public_path('icon/service_icon/');
            $iconName = date('YmdHis') . '.' . $icon->getClientOriginalExtension();
            $icon->move($destinationPath, $iconName);
            $serviceDetail->icon = $iconName;
        }

        $serviceDetail->save();

        return response()->json(['success' => 'Service and details created successfully!', 'data' => ['service' => $mdService, 'details' => $serviceDetail]]);
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
            'price' => ['required'],
            'service_name' => ['required'],
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
        $serviceDetail = MdServiceDetail::where('md_service_id', $mdService->id)->first();
        if (!$serviceDetail) {
            return response()->json(['error' => 'Service details not found!'], 404);
        }

        $serviceDetail->service_name = $request->input('service_name');
        $serviceDetail->description = $request->input('description');
        $mdService->price = $request->input('price');


        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $destinationPath = public_path('icon/service_icon/');
            $iconName = date('YmdHis') . '.' . $icon->getClientOriginalExtension();
            $icon->move($destinationPath, $iconName);
            $serviceDetail->icon = $iconName;
        }

        $serviceDetail->save();

        return response()->json(['success' => 'Service and details updated successfully!', 'data' => ['service' => $mdService, 'details' => $serviceDetail]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
