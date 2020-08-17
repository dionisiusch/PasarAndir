<?php

namespace App\Http\Services;

use App\Model\Stall;

class UserService
{
    public function getUserById($id)
    {
        return DB::table('users')
            ->where('id', $id)
            ->first();
    }
}
