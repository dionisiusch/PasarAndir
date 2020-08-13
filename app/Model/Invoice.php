<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'invoices';

    protected $fillable = ['stall_id', 'stall_electricity_id', 'stall_water_id', 'discount', 'minimal_payment', 'fine', 'month_bill', 'grace_date', 'status'];
}
