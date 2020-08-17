<?php

namespace App\Http\Controllers;

use App\Model\Electricity;
use Illuminate\Http\Request;
use App\Http\Services\ElectricityService;
use GuzzleHttp\Client;

class ElectricityController extends Controller
{
    /** @var ElectricityService */
    private $electricityService;

    public function __construct()
    {
        $this->electricityService = app(ElectricityService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $electricities = $this->electricityService->showAllElectricities();

        // return view('master.electricity.electricityShow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'value'=>'required',
            'price'=>'required',
        ]);

        $response = $this->electricityService->createElectricity($request);

        // return redirect('/master/electricity')->with('success', 'Data Listrik PLN Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $electricity = $this->electricityService->getElectricityById($id);
      
            $data = array(
            'price'  => $electricity->price,
            'value'  => $electricity->value,
            'type'  => $electricity->type,
            'name'  => $electricity->name,
            'id'  => $id
            );
            
            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function edit(Electricity $electricity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'value'=>'required',
            'price'=>'required',
        ]);

        $response = $this->electricityService->updateElectricityById($request, $id);

        // return redirect('/master/electricity')->with('success', 'Data Listrik PLN Berhasil Di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Electricity  $electricity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Listrik PLN Gagal Dihapus.';
        $response = $this->electricityService->deleteElectricityById($id);

        if($response){
            $msg = 'Data Listrik PLN Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->electricityService->searchElectricity($query);
            } else {
                $data = DB::table('electricities')
                ->get();
            }
         
            $total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
                    $output .= '
					<tr class="tr-shadow">
						<td>'.$row->code.'</td>
						<td>
						'.$row->name.'
						</td>
						<td>
							<div class="table-data-feature">
							<button class="item edit" data-toggle="modal" data-target="#scrollmodal-update" title="Edit" id="'.$row->id.'">
								<i class="zmdi zmdi-edit"></i>
							</button>
							<button class="item delete" type="submit" data-toggle="tooltip" data-placement="top" title="Delete" id="'.$row->id.'">
								<i class="zmdi zmdi-delete"></i>
							</button>
							</div>
						</td>
					</tr>
					<tr class="spacer"></tr> 
        	        ';
      	        }
            } else {
				$output = '
				<tr class="tr-shadow">
				    <td align="center" colspan="3">Data not found.</td>
				</tr>
				';
			}
			
			$data = array(
				'table_data'  => $output,
				'total_data'  => $total_row
			);
			
   		    return json_encode($data);
 		}
	}
}
