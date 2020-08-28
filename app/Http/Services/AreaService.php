<?php

namespace App\Http\Services;

use App\Model\Area;
use DB;

class AreaService
{
    public function showAllAreas()
    {
        $areas = Area::all();

        return $areas;
    }

    public function createArea($data)
    {
        $area = new Area([
            'floor_id' => $data->get('floor_id'),
            'name' => $data->get('name'),
            'no' => $data->get('no') ? $data->get('no') : null,
            'price' => $data->get('price')
        ]);
        $area->save();

        return $area;
    }

    public function getAreaById($id)
    {
        $area = Area::find($id);
        return $area;
    }

    public function updateAreaById($data, $id)
    {
        $area = Area::find($id);
        $area->floor_id = $data->get('floor_id');
        $area->name = $data->get('name');
        $area->no = $data->get('no') ? $data->get('no') : null;
        $area->price = $data->get('price');
        $area->save();

        return $area;
    }

    public function deleteAreaById($id)
    {
        $area = Area::find($id);
        $area->delete();

        return $area;
    }

    public function searchArea($query)
    {
        return DB::table('areas')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('no', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->get();
    }
}
