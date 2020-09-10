<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PowerMeter extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'power_meters';

    protected $fillable = ['power_meter', 'kva_price', 'kwh_price'];
}
