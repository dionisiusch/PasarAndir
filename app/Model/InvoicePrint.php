<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoicePrint extends Model
{

    protected $table = 'print_invoice';

    protected $fillable = ['invoice_id'];
}
