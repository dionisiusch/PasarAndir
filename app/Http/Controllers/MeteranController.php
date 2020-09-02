<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ElectricityService;
use App\Http\Services\StallElectricityService;
use App\Http\Services\StallWaterService;
use App\Http\Services\StallService;
use App\Model\Stall;
use App\Model\stallElectricity;
use App\Model\StallWater;
use App\Model\Electricity;

use DB;


class MeteranController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $electricityService;
    private $stallService;
    private $stallWaterService;
    private $stallElectricityService;

    public function __construct()
    {
        $this->electricityService = app(ElectricityService::class);
        $this->stallElectricityService = app(StallElectricityService::class);
        $this->stallService = app(StallService::class); 
        $this->stallWaterService = app(StallWaterService::class); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('meteran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'stall_id'=>'required',
            'electricity_meter_before'=>'required',
            'electricity_meter_after'=>'required',
            'water_meter_before'=>'required',
            'water_meter_after'=>'required'
        ]);
        
        $stall = $this->stallService->getStallById($request->stall_id);
        $electricity = $this->electricityService->getElectricityById($stall->electricity_id);

        $requestStallElectricity = new Request();
        $requestStallWater = new Request();

        $requestStallElectricity->replace([
            'stall_id' => $request->stall_id,
            'meter_before'=> $request->electricity_meter_before,
            'meter_after'=> $request->electricity_meter_after,
            'kva_price' => $electricity->kva_price,
            'kwh_price' => $electricity->kwh_price
        ]);

        $requestStallWater->replace([
            'stall_id' => $request->stall_id,
            'meter_before'=> $request->water_meter_before,
            'meter_after'=> $request->water_meter_after,
            'price' => 0,
            'fixed_price' => 0
        ]);

        $queryStallElectricity = $this->stallElectricityService->createStallElectricity($requestStallElectricity);
        $queryStallWater = $this->stallWaterService->createStallWater($requestStallWater);

        return redirect('/meteran')->with('success', 'Data Meteran Berhasil Ditambahkan.');       
    }

     public function getElectricityName(Request $request){
        $search = $request->get('id');
        
        $requestStall = $this->stallService->getStallById($search);
        $requestElectricity = $this->electricityService->getElectricityById($requestStall->electricity_id);
        
        $response = array();
        // $preselect = '';
        foreach($requestElectricity as $electricity){
            $response = array(
                "name"=>"[Kode : ".$requestElectricity->name."]"
            );
            // $preselect.='<option value="'.$floor->id.'"> '.$floor->name.'</option>';
        }
        // $response['option'] = $preselect; 
        echo json_encode($response);
   }

}
