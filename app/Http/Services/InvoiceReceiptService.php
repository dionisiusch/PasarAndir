<?php

namespace App\Http\Services;

use App\Model\InvoiceReceipt;
use DB;

class InvoiceService
{
    public function showAllInvoiceReceipts()
    {
        $invoiceReceipts = InvoiceReceipt::all();

        return $invoiceReceipts;
    }

    public function createInvoiceReceipt($data)
    {
        $invoiceReceipt = new InvoiceReceipt([
            'invoice_id' => $data->get('invoice_id'),
            'receipt_id' => $data->get('receipt_id')
        ]);
        $invoiceReceipt->save();

        return $invoiceReceipt;
    }

    public function showAllInvoiceReceiptsByUserId($userId)
    {
        //
    }

    public function showAllInvoiceReceiptsByStallId($stallId)
    {
        //
    }

    public function deleteInvoiceReceiptByInvoiceId($invoiceId)
    {
        //
    }

    public function deleteInvoiceReceiptByReceiptId($receiptId)
    {
        //
    }

    public function searchInvoiceReceipt($query)
    {
        //
    }
}
