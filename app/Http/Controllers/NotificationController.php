<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InvoiceService;
use GuzzleHttp\Client;
use DB;

class NotificationController extends Controller
{
    /** @var InvoiceService */
    private $invoiceService;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
    }

    public function getUnpaidInvoicesThatPassTheGraceDate()
    {
        $response = $this->invoiceService->getUnpaidInvoicesThatPassTheGraceDate();
    }
}
