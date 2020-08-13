<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'receipts';

    protected $fillable = ['stall_id', 'payment'];
}
