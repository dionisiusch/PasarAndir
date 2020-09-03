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

    public function showAllInvoicesByReceiptId($receiptId)
    {
        return DB::table('invoice_receipts')
            ->where('receipt_id', $receiptId)
            ->whereNull('deleted_at')
            ->pluck('invoice_id');
    }

    public function showAllReceiptsByInvoiceId($invoiceId)
    {
        return DB::table('invoice_receipts')
            ->where('invoice_id', $invoiceId)
            ->whereNull('deleted_at')
            ->pluck('receipt_id');
    }

    public function showAllInvoiceReceiptsByReceiptIds($receiptIds)
    {
        return DB::table('invoice_receipts')
            ->whereIn('receipt_id', $receiptIds)
            ->whereNull('deleted_at')
            ->get();
    }

    public function showAllInvoiceReceiptsByInvoiceId($invoiceIds)
    {
        return DB::table('invoice_receipts')
            ->where('invoice_id', $invoiceIds)
            ->whereNull('deleted_at')
            ->get();
    }

    public function deleteInvoiceReceiptByInvoiceId($invoiceId)
    {
        return InvoiceReceipt::where('invoice_id', $invoiceId)->delete();
    }

    public function deleteInvoiceReceiptByReceiptId($receiptId)
    {
        return InvoiceReceipt::where('receipt_id', $receiptId)->delete();
    }

    public function searchInvoiceReceipt($query)
    {
        //
    }
}
