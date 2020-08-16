<?php

namespace App\Http\Controllers;

use App\Model\Stall;
use App\Model\AreaNo;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Services\StallService;
use App\Http\Services\AreaNoService;
use App\Http\Services\CategoryService;
use GuzzleHttp\Client;

class StallController extends Controller
{
    /** @var StallService */
    private $stallService;

    /** @var AreaNoService */
    private $areaNoService;

    /** @var CategoryService */
    private $categoryService;

    public function __construct()
    {
        $this->stallService = app(StallService::class);
        $this->areaNoService = app(AreaNoService::class);
        $this->categoryService = app(CategoryService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stalls = $this->stallService->showAllStalls();
        $areaNos = $this->areaNoService->showAllAreaNos();
        $categories = $this->categoryService->showAllCategories();

        // return view('stalls.index', compact('stalls', 'areaNos', 'categories')); 
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
            'user_id'=>'required',
            'area_no_id'=>'required',
            'category_id'=>'required',
            'name'=>'required',
            'length'=>'required',
            'width'=>'required',
            'height'=>'required',
            'status'=>'required'
        ]);

        $response = $this->stallService->createStall($request);

        // return redirect('/stalls')->with('success', 'Stall has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stall = $this->stallService->getStallById($id);

        // return view('stalls.show', compact('stall')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function edit(Stall $stall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'=>'required',
            'area_no_id'=>'required',
            'category_id'=>'required',
            'name'=>'required',
            'length'=>'required',
            'width'=>'required',
            'height'=>'required',
            'status'=>'required'
        ]);

        $response = $this->stallService->updateStallById($request, $id);

        // return redirect('/stalls')->with('success', 'Stall has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->stallService->deleteStallById($id);

        // return redirect('/stalls')->with('success', 'Stall has been deleted');
    }
}
