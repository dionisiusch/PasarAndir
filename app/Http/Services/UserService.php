<?php

namespace App\Http\Services;

use App\User;

class UserService
{
    public function showAllUsers()
    {
        $users = User::all();

        return $users;
    }

    public function getUserById($id)
    {
        return DB::table('users')
            ->where('id', $id)
            ->first();
    }

    public function updatePICUserById($data, $id)
    {
        $user = User::find($id);
        $user->pic_name = $data->get('pic_name');
        $user->pic_phone_number = $data->get('pic_phone_number');
        $user->joined_date = $data->get('joined_date');
        $user->save();

        return $user;
    }

    public function updateAuthUserById($data, $id)
    {
        $user = User::find($id);
        $user->username = $data->get('username');
        $user->password = Hash::make($data->get('password'));
        $user->save();

        return $user;
    }

    public function resetPasswordUserById($id, $password)
    {
        $user = User::find($id);
        $user->password = Hash::make($data->get('password'));
        $user->save();

        return $user;
    }

    public function resetToDefaultUserById($id, $password)
    {
        $user = User::find($id);
        $user->password = Hash::make("PasarAndir"+$id);
        $user->pic_name = null;
        $user->pic_phone_number = null;
        $user->joined_date = null;
        $user->save();

        return $user;
    }

    public function searchUser($query)
    {
        return DB::table('users')
            ->where('pic_name', 'like', '%'.$query.'%')
            ->orWhere('pic_phone_number', 'like', '%'.$query.'%')
            ->orWhere('username', 'like', '%'.$query.'%')
            ->get();
    }
}
