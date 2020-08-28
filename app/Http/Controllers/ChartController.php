<?php

namespace App\Http\Controllers;

use App\Model\Stall;
use Illuminate\Http\Request;
use App\Http\Services\StallService;
use GuzzleHttp\Client;
use DB;

class ChartController extends Controller
{
    /** @var CategoryService */
    private $stallService;

    public function __construct()
    {
        $this->stallService = app(StallService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stall()
    {
        $active_arr = $this->stallService->getActive();
        $active = count($active_arr);
        $total_arr =  $this->stallService->showAllStalls();
        $total = count($total_arr);
        $inactive = $total - $active;
        $data = array(
                'active'  => $active,
                'inactive'=> $inactive,
                'total' => $total
            );
        return json_encode($data);
    }   

  
}
