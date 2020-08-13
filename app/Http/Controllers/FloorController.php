<?php

namespace App\Http\Controllers;

use App\Model\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::all();
        // return view('floors.index', compact('floors')); 
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

        // return redirect('/floors')->with('success', 'Floor has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $floor = Floor::find($id);
        // return view('floors.show', compact('floor')); 
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

        // return redirect('/floors')->with('success', 'Floor has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $floor = Floor::find($id);
        $floor->delete();

        // return redirect('/floors')->with('success', 'Floor has been deleted');
    }
}
