<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaNo extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'area_nos';

    protected $fillable = ['area_id', 'no_id'];
}
