<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StallWater extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'stall_waters';

    protected $fillable = ['stall_id', 'meter_before', 'meter_after', 'price'];
}
