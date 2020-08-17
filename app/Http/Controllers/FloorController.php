<?php

namespace App\Http\Controllers;

use App\Model\Floor;
use Illuminate\Http\Request;
use DB;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.floor.floorShow'); 
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
            'code'=>'required',
            'name'=>'required'
        ]);

        $floor = new Floor([
            'code' => $request->get('code'),
            'name' => $request->get('name')
        ]);

        $floor->save();

        return redirect('/master/floor')->with('success', 'Data Lantai Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax())
        {
        $id = $request->get('id');
        $floor = Floor::find($id);

        $data = array(
         'code'  => $floor->code,
         'name'  => $floor->name,
         'id'  => $id
        );

        return json_encode($data);
        // return view('floors.show', compact('floor')); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function edit(Floor $floor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required',
            'name'=>'required'
        ]);

        $floor = Floor::find($id);
        $floor->code = $request->get('code');
        $floor->name = $request->get('name');
        $floor->save();

        return redirect('/master/floor')->with('success', 'Data Lantai Berhasil Di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $msg = 'Data Lantai Gagal Dihapus.';
        $floor = Floor::findOrFail($id);
        $floor->delete();

        if($floor){
            $msg = 'Data Lantai Berhasil Dihapus.';
        }
        return $msg;

    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
          $output = '';
          $query = $request->get('query');
          if($query != '')
          {
             $data = DB::table('floors')
             ->where('name', 'like', '%'.$query.'%')
             ->orWhere('code', 'like', '%'.$query.'%')
             ->get();
             
         }
         else
         {
             $data = DB::table('floors')
             ->get();
         }
         $total_row = $data->count();
         if($total_row > 0)
         {
             foreach($data as $row)
             {
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
        }
        else
        {
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

