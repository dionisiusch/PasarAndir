<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class No extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'nos';

    protected $fillable = ['no'];
}