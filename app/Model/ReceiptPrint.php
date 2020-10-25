<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReceiptPrint extends Model
{

    protected $table = 'print_receipt';

    protected $fillable = ['receipt_id', 'invoice_id'];
}
