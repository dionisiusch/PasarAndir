<?php

namespace App\Http\Services;

use App\Model\InvoiceReceipt;
use DB;

class InvoiceReceiptService
{
    public function showAllInvoiceReceipts()
    {
        $invoiceReceipts = InvoiceReceipt::all();

        return $invoiceReceipts;
    }

    public function createInvoiceReceipt($invoiceId, $receiptId, $payment)
    {
        $invoiceReceipt = new InvoiceReceipt([
            'invoice_id' => $invoiceId,
            'receipt_id' => $receiptId,
            'payment' => $payment
        ]);
        $invoiceReceipt->save();

        return $invoiceReceipt;
    }

    public function updateInvoiceReceiptByInvoiceIdAndReceiptId($invoiceId, $receiptId, $payment)
    {
        $invoiceReceipt = InvoiceReceipt::where('invoice_id', $invoiceId)->where('receipt_id', $receiptId)->first();
        $invoiceReceipt->payment = $payment;
        $invoiceReceipt->save();

        return $invoiceReceipt;
    }

    public function sumTotalPaymentByInvoiceId($invoiceId)
    {
        return DB::table('invoice_receipts')
            ->where('invoice_id', $invoiceId)
            ->whereNull('deleted_at')
            ->sum('payment');
    }

    public function showAllInvoicesByReceiptId($receiptId)
    {
        return DB::table('invoice_receipts')
            ->where('receipt_id', $receiptId)
            ->whereNull('deleted_at')
            ->pluck('invoice_id');
    }

    public function getInvoiceByReceiptId($receiptId)
    {
        return InvoiceReceipt::where('receipt_id', $receiptId)
            ->whereNull('deleted_at')
            ->pluck('invoice_id')
            ->first();
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
