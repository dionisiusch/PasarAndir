<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InvoiceService;
use App\Http\Services\StallService;
use App\Http\Services\AreaService;
use App\Http\Services\FloorService;
use GuzzleHttp\Client;
use DB;

class NotificationController extends Controller
{
    /** @var InvoiceService */
    private $invoiceService;

    /** @var StallService */
    private $stallService;

    /** @var AreaService */
    private $areaService;

    /** @var FloorService */
    private $floorService;

    public function __construct()
    {
        $this->invoiceService = app(InvoiceService::class);
        $this->stallService = app(StallService::class);
        $this->areaService = app(AreaService::class);
        $this->floorService = app(FloorService::class);
    }

    public function getUnpaidInvoicesThatPassTheGraceDate()
    {
        $responses = $this->invoiceService->getUnpaidInvoicesThatPassTheGraceDate();

        foreach ($responses as $response) {
            $response->stall = $this->stallService->getStallById($response->stall_id);
            $response->stall->area = $this->areaService->getAreaById($response->stall->area_id);
            $response->stall->area->floor = $this->floorService->getFloorById($response->stall->area->floor_id);
        }
        return $responses;
    }
}
