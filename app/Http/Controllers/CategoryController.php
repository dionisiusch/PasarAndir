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
        // return view('master.category.categoryShow');
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
        try {
            $request->validate([
                'name'=>'required'
            ]);
    
            $response = $this->categoryService->createCategory($request);
    
            // return redirect('/master/category')->with('success', 'Data Kategori Kios Berhasil Ditambahkan.');       
        } catch (Exception $e) {
            // return redirect('/master/category')->with('success', 'Data Kategori Kios Gagal Ditambahkan.'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $category = $this->categoryService->getCategoryById($id);
      
            $data = array(
            'name'  => $category->name,
            'id'  => $id
            );
            
            return json_encode($data);
        }
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
        try {
            $request->validate([
                'name'=>'required'
            ]);
    
            $response = $this->categoryService->updateCategoryById($request, $id);
    
            // return redirect('/master/category')->with('success', 'Data Kategori Kios Berhasil Di Update.');       
        } catch (Exception $e) {
            // return redirect('/master/category')->with('success', 'Data Kategori Kios Gagal Di Update.');       
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Kategori Kios Gagal Dihapus.';
        $response = $this->categoryService->deleteCategoryById($id);

        if($response){
            $msg = 'Data Kategori Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->categoryService->searchCategory($query);
            } else {
                $data = DB::table('categories')
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
