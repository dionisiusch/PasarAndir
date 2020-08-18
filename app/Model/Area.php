<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'areas';

    protected $fillable = ['floor_id', 'name', 'no', 'price'];
}
