<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Electricity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'electricities';

    protected $fillable = ['name', 'power_meter', 'kva_price', 'kwh_price'];
}
