<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Electricity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'electricities';

    protected $fillable = ['name', 'type', 'value', 'price'];
}
