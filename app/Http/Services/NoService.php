<?php

namespace App\Http\Services;

use App\Model\No;

class NoService
{
    public function showAllNos()
    {
        $nos = No::all();
        return $nos;
    }

    public function createNo($data)
    {
        $no = new No([
            'no' => $data->get('no')
        ]);
        $no->save();

        return $no;
    }

    public function getNoById($id)
    {
        $no = No::find($id);
        return $no;
    }

    public function updateNoById($data, $id)
    {
        $no = No::find($id);
        $no->no = $data->get('no');
        $no->save();

        return $no;
    }

    public function deleteNoById($id)
    {
        $no = No::find($id);
        $no->delete();

        return $no;
    }

    public function searchNo($query)
    {
        return DB::table('nos')
            ->where('no', 'like', '%'.$query.'%')
            ->get();
    }
}
