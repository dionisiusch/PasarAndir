<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stall extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'stalls';

    protected $fillable = ['user_id', 'area_no_id', 'category_id', 'name', 'length', 'width', 'height', 'status'];
}
