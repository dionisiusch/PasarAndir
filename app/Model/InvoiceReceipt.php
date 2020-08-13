<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceReceipt extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'invoice_receipts';

    protected $fillable = ['invoice_id', 'receipt_id'];
}
