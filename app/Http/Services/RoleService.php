<?php

namespace App\Http\Services;

use App\Model\Role;
use DB;

class RoleService
{
    public function showAllRoles()
    {
        $roles = Role::all();

        return $roles;
    }

    public function getRoleById($id)
    {
        $role = Role::find($id);

        return $role;
    }

    public function searchRole($query)
    {
        return DB::table('roles')
            ->where('name', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->get();
    }
}
