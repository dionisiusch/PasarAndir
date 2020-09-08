<?php

namespace App\Http\Controllers;

use App\Model\Receipt;
use App\Model\Stall;
use Illuminate\Http\Request;
use App\Http\Services\ReceiptService;
use App\Http\Services\InvoiceService;
use App\Http\Services\InvoiceReceiptService;
use App\Http\Services\StallService;
use GuzzleHttp\Client;
use DB;

class ReceiptController extends Controller
{
    /** @var ReceiptService */
    private $receiptService;

    /** @var InvoiceService */
    private $invoiceService;

    /** @var InvoiceReceiptService */
    private $invoiceReceiptService;

    /** @var StallService */
    private $stallService;

    public function __construct()
    {
        $this->receiptService = app(ReceiptService::class);
        $this->invoiceService = app(InvoiceService::class);
        $this->invoiceReceiptService = app(InvoiceReceiptService::class);
        $this->stallService = app(StallService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = $this->receiptService->showAllReceipts();

        return view('master.receipt.receiptShow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.receipt.receiptCreate');
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
                'invoice_id'=>'required',
                'stall_id'=>'required',
                'payment'=>'required'
            ]);
    
            $receipt = $this->receiptService->createReceipt($request);
            $invoiceReceipt = $this->invoiceReceiptService->createInvoiceReceipt($request->invoice_id, $receipt->id);
    
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Berhasil Ditambahkan.');       
        } catch (Exception $e) {
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Gagal Ditambahkan.'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()) {
            $id = $request->get('id');
            $receipt = $this->receiptService->getReceiptById($id);
            $invoiceIds = $this->invoiceReceiptService->showAllInvoicesByReceiptId($id);
            $invoices = $this->invoiceService->getInvoiceById($invoiceIds);
            $stall = $this->stallService->getStallById($receipt->stall_id);
      
            $data = array(
                'invoices' => $invoices,
                'payment' => $receipt->stall,
                'stall'  => $stall,
                'id'  => $id
            );
            
            return json_encode($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'stall_id'=>'required',
                'payment'=>'required'
            ]);
    
            $response = $this->receiptService->updateReceiptById($request, $id);
    
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Berhasil Di Update.');       
        } catch (Exception $e) {
            return redirect('/master/receipt')->with('success', 'Data Receipt Kios Gagal Di Update.'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'Data Receipt Kios Gagal Dihapus.';
        $response = $this->receiptService->deleteReceiptById($id);

        if($response){
            $msg = 'Data Receipt Kios Berhasil Dihapus.';
        }

        return $msg;
    }

    public function search(Request $request)
    {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = $this->receiptService->searchReceipt($query);
            } else {
                $data = $this->receiptService->showAllReceipts();
            }
         
            $total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
                    $stall = $this->stallService->getStallById($row->stall_id);
                    $output .= '
					<tr class="tr-shadow" id="'.$row->id.'" data-toggle="modal" data-target="#largeModal">
                        <td>'.$stall->name.'</td>
                        <td>'.$row->created_at.'</td>
                        <td>'.parent::rupiah($row->payment).'</td>
						<td>
							<div class="table-data-feature">
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
				    <td align="center" colspan="2">Data not found.</td>
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
