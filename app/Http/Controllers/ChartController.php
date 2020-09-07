<?php

namespace App\Http\Controllers;

use App\Model\Stall;
use Illuminate\Http\Request;
use App\Http\Services\StallService;
use App\Http\Services\InvoiceService;
use GuzzleHttp\Client;
use DB;

class ChartController extends Controller
{
    /** @var StallService */
    private $stallService;

    /** @var InvoiceService */
    private $invoiceService;

    public function __construct()
    {
        $this->stallService = app(StallService::class);
        $this->invoiceService = app(InvoiceService::class);
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

    public function unpaidInvoices()
    {
        return $this->invoiceService->totalUnpaidInvoices();
    }

    public function totalInvoice()
    {
        return $this->invoiceService->totalAllInvoices();
    }
}
