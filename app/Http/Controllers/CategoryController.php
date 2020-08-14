<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Services\CategoryService;
use GuzzleHttp\Client;

class CategoryController extends Controller
{
    /** @var CategoryService */
    private $categoryService;

    public function __construct()
    {
        $this->categoryService = app(CategoryService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->showAllCategories();
        // return view('categories.index', compact('categories'));
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
            'name'=>'required'
        ]);

        $response = $this->categoryService->createCategory($request);

        // return redirect('/categories')->with('success', 'Category has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        // return view('categories.show', compact('category')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $response = $this->categoryService->updateCategoryById($request, $id);

        // return redirect('/categories')->with('success', 'Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->categoryService->deleteCategoryById($id);

        // return redirect('/categories')->with('success', 'Category has been deleted');
    }
}
