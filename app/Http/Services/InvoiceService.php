<?php

namespace App\Http\Services;

use App\Model\Invoice;
use DB;

class InvoiceService
{
    public function showAllInvoices()
    {
        $invoices = Invoice::all();

        return $invoices;
    }

    public function createInvoice($data, $stallElectricityId, $stallWaterId)
    {
        $invoice = new Invoice([
            'stall_id' => $data->get('stall_id'),
            'stall_electricity_id' => $stallElectricityId,
            'stall_water_id' => $stallWaterId,
            'discount' => $data->get('discount') ?  $data->get('discount') : 0,
            'minimal_payment' => $data->get('minimal_payment'),
            'fine' => $data->get('fine') ? $data->get('fine') : 0,
            'month_bill' => $data->get('month_bill'),
            'status' => $data->get('status')
        ]);
        $invoice->save();

        return $invoice;
    }

    public function getInvoiceById($id)
    {
        $invoice = Invoice::find($id);

        return $invoice;
    }

    public function updateInvoiceById($data, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->stall_id = $data->get('stall_id');
        $invoice->discount = $data->get('discount') ? $data->get('discount') : 0;
        $invoice->minimal_payment = $data->get('minimal_payment');
        $invoice->fine = $data->get('fine') ? $data->get('fine') : 0;
        $invoice->month_bill = $data->get('month_bill');
        $invoice->grace_date = $data->get('grace_date');
        $invoice->save();

        return $invoice;
    }

    public function updateInvoiceStatusById($data, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = $data->get('status');
        $invoice->save();

        return $invoice;
    }

    public function deleteInvoiceById($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        return $invoice;
    }

    public function searchInvoice($query)
    {
        $stallId = DB::table('stalls')
            ->where('name', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->pluck('id');

        return DB::table('invoices')
            ->where('discount', 'like', '%'.$query.'%')
            ->orWhere('minimal_payment', 'like', '%'.$query.'%')
            ->orWhere('fine', 'like', '%'.$query.'%')
            ->orWhere('month_bill', 'like', '%'.$query.'%')
            ->orWhere('grace_date', 'like', '%'.$query.'%')
            ->orWhere('status', 'like', '%'.$query.'%')
            ->orWhereIn('stall_id', $stallId)
            ->whereNull('deleted_at')
            ->orderBy('status', 'asc')
            ->get();
    }
}
