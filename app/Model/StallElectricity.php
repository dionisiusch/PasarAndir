<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StallElectricity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'stall_electricities';

    protected $fillable = ['stall_id', 'electricity_id', 'meter_before', 'meter_after', 'kva_price', 'kwh_price'];
}
