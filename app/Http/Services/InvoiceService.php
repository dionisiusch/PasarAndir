<?php

namespace App\Http\Services;

use App\Model\Invoice;
use App\Model\Stall;
use Carbon\Carbon;
use DB;

class InvoiceService
{
    public function showAllInvoices()
    {
        $invoices = Invoice::all();

        return $invoices;
    }

    public function showAllInvoicesSortByStatus()
    {
        $invoices = Invoice::orderBy('status', 'asc')->get();
        return $invoices;
    }

    public function showAllInvoicesForReceipt()
    {
        $invoices = Invoice::where('status', 'Belum Lunas')->get();

        return $invoices;
    }

    public function totalAllInvoices()
    {
        $invoices = Invoice::count();

        return $invoices;
    }

    public function totalUnpaidInvoices()
    {
        $invoices = Invoice::where('status', 'Belum Lunas')->count();

        return $invoices;
    }

    public function getUnpaidInvoicesThatPassTheGraceDate()
    {
        return Invoice::where('status', 'Belum Lunas')
            ->whereDate('grace_date', '<', Carbon::now('Asia/Jakarta')->toDateString())
            ->get();
    }

    public function createInvoice($data, $stallElectricityId, $stallWaterId, $minimalPayment)
    {
        $invoice = new Invoice([
            'stall_id' => $data->get('stall_id'),
            'stall_electricity_id' => $stallElectricityId,
            'stall_water_id' => $stallWaterId,
            'discount' => $data->get('discount') ?  $data->get('discount') : 0,
            'minimal_payment' => $minimalPayment,
            'fine' => $data->get('fine') ? $data->get('fine') : 0,
            'month_bill' => $data->get('month_bill'),
            'status' => $data->get('status'),
            'grace_date' => $data->get('grace_date')
        ]);
        $invoice->save();

        return $invoice;
    }

    public function getInvoiceById($id)
    {
        $invoice = Invoice::find($id);

        return $invoice;
    }

    public function updateInvoiceById($data, $id, $minimalPayment)
    {
        $invoice = Invoice::find($id);
        $invoice->stall_id = $data->get('stall_id');
        $invoice->discount = $data->get('discount') ? $data->get('discount') : 0;
        $invoice->minimal_payment = $minimalPayment;
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

    public function updateInvoiceStatusPaidOffById($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = "Lunas";
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
        $stallId = Stall::where('name', 'like', '%' . $query . '%')
            ->pluck('id');

        return Invoice::where('discount', 'like', '%' . $query . '%')
            ->orWhere('minimal_payment', 'like', '%' . $query . '%')
            ->orWhere('fine', 'like', '%' . $query . '%')
            ->orWhere('month_bill', 'like', '%' . $query . '%')
            ->orWhere('grace_date', 'like', '%' . $query . '%')
            ->orWhere('status', 'like', '%' . $query . '%')
            ->orWhereIn('stall_id', $stallId)
            ->orderBy('status', 'asc')
            ->get();
    }

    public function searchInvoicesForReceipt($query)
    {
        $stallId = Stall::where('name', 'like', '%' . $query . '%')
            ->pluck('id');

        return Invoice::where('status', 'Belum Lunas')
            ->orWwhere('discount', 'like', '%' . $query . '%')
            ->orWhere('minimal_payment', 'like', '%' . $query . '%')
            ->orWhere('fine', 'like', '%' . $query . '%')
            ->orWhere('month_bill', 'like', '%' . $query . '%')
            ->orWhere('grace_date', 'like', '%' . $query . '%')
            ->orWhereIn('stall_id', $stallId)
            ->orderBy('status', 'asc')
            ->get();
    }
}
