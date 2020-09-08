<?php

namespace App\Http\Services;

use App\Model\Receipt;
use App\Model\Stall;
use DB;

class ReceiptService
{
    public function showAllReceipts()
    {
        $receipts = Receipt::all();

        return $receipts;
    }

    public function createReceipt($data, $payment)
    {
        $receipt = new Receipt([
            'stall_id' => $data->get('stall_id'),
            'payment' => $payment
        ]);
        $receipt->save();

        return $receipt;
    }

    public function getReceiptById($id)
    {
        $receipt = Receipt::find($id);

        return $receipt;
    }

    public function getReceiptIdByStallIds($stallIds)
    {
        $receiptId = Receipt::whereIn('stall_id', $stallIds)->pluck('id');

        return $receiptId;
    }

    public function getReceiptsByStallId($stallId)
    {
        $receipts = Receipts::where('stall_id'. $stallId)->get();

        return $receipts;
    }

    public function updateReceiptById($data, $id, $payment)
    {
        $receipt = Receipt::find($id);
        $receipt->stall_id = $data->get('stall_id');
        $receipt->payment = $payment;
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
        $stallId = Stall::where('name', 'like', '%'.$query.'%')
            ->pluck('id');

        return Receipt::where('payment', 'like', '%'.$query.'%')
            ->orWhereIn('stall_id', $stallId)
            ->get();
    }
}
