<?php

namespace App\Http\Services;

use App\Role;
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
}
