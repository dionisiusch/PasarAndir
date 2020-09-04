<?php

namespace App\Http\Controllers;

use App\Model\InvoiceReceipt;
use App\Model\Invoice;
use App\Model\Receipt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\InvoiceReceiptService;
use App\Http\Services\InvoiceService;
use App\Http\Services\ReceiptService;
use App\Http\Services\StallService;
use App\Http\Services\UserService;

class InvoiceReceiptController extends Controller
{
    /** @var InvoiceReceiptService */
    private $invoiceReceiptService;

    /** @var InvoiceService */
    private $invoiceService;

    /** @var ReceiptService */
    private $receiptService;

    /** @var StallService */
    private $stallService;

    /** @var UserService */
    private $userService;

    public function __construct()
    {
        $this->invoiceReceiptService = app(InvoiceReceiptService::class);
        $this->invoiceService = app(InvoiceService::class);
        $this->receiptService = app(ReceiptService::class);
        $this->stallService = app(StallService::class);
        $this->userService = app(UserService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function paymentHistory()
    {
        $stallIds = $this->stallService->getStallByUserId(Auth::guard('web')->user()->id);
        $receiptIds = $this->receiptService->getReceiptIdByStallIds($stallIds);
        $invoiceReceipts = $this->invoiceReceiptService->showAllInvoiceReceiptsByReceiptIds($receiptsIds);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\InvoiceReceipt  $invoiceReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceReceipt $invoiceReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\InvoiceReceipt  $invoiceReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceReceipt $invoiceReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\InvoiceReceipt  $invoiceReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceReceipt $invoiceReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\InvoiceReceipt  $invoiceReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceReceipt $invoiceReceipt)
    {
        //
    }
}
