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
        // return view('nos.index', compact('nos')); 
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

        // return redirect('/nos')->with('success', 'No has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\No  $no
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $no = $this->noService->getNoById($id);
        // return view('nos.show', compact('no')); 
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

        // return redirect('/nos')->with('success', 'No has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\No  $no
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->noService->deleteNoById($id);

        // return redirect('/nos')->with('success', 'No has been deleted');
    }
}
