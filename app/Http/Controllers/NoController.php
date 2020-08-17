<?php

namespace App\Http\Controllers;

use App\Model\No;
use Illuminate\Http\Request;
use App\Http\Services\NoService;
use GuzzleHttp\Client;

class NoController extends Controller
{
    /** @var NoService */
    private $noService;

    public function __construct()
    {
        $this->noService = app(NoService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nos = $this->noService->showAllNos();
        // return view('master.no.noShow');
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
            'no'=>'required'
        ]);

        $response = $this->noService->createNo($request);

        // return redirect('/master/no')->with('success', 'Data Nomor Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\No  $no
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $no = $this->noService->getNoById($id);
      
            $data = array(
            'no'  => $no->no,
            'id'  => $id
            );
            
            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\No  $no
     * @return \Illuminate\Http\Response
     */
    public function edit(No $no)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\No  $no
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no'=>'required'
        ]);

        $response = $this->noService->updateNoById($request, $id);

        // return redirect('/master/no')->with('success', 'Data Nomor Berhasil Di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\No  $no
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Nomor Gagal Dihapus.';
        $response = $this->noService->deleteNoById($id);

        if($response){
            $msg = 'Data Nomor Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->noService->searchNo($query);
            } else {
                $data = DB::table('nos')
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
