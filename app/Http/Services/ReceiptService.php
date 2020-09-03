<?php

namespace App\Http\Services;

use App\Model\Receipt;
use DB;

class ReceiptService
{
    public function showAllReceipts()
    {
        $receipts = Receipt::all();

        return $receipts;
    }

    public function createReceipt($data)
    {
        $receipt = new Receipt([
            'stall_id' => $data->get('stall_id'),
            'payment' => $data->get('payment')
        ]);
        $receipt->save();

        return $receipt;
    }

    public function getReceiptById($id)
    {
        $receipt = Receipt::find($id);

        return $receipt;
    }

    public function updateReceiptById($data, $id)
    {
        $receipt = Receipt::find($id);
        $receipt->stall_id = $data->get('stall_id');
        $receipt->payment = $data->get('payment');
        $receipt->save();

        return $receipt;
    }

    public function deleteReceiptById($id)
    {
        try {
            $receipt = Receipt::find($id);
            $receipt->delete();

            return $receipt;
        } catch (Exception $e) {
            return null;
        }
    }

    public function searchReceipt($query)
    {
        $stallId = DB::table('stalls')
            ->where('name', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->pluck('id');

        return DB::table('receipts')
            ->where('payment', 'like', '%'.$query.'%')
            ->orWhereIn('stall_id', $stallId)
            ->whereNull('deleted_at')
            ->get();
    }
}
