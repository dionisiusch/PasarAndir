<?php

namespace App\Http\Services;

use App\Model\Area;

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
        $area->price = $data->get('price');
        $area->save();

        return $area;
    }

    public function deleteAreaById($id)
    {
        try {
            $area = Area::find($id);
            $area->delete();
    
            return $area;
        } catch (Exception $e) {
            console.log($e);
            return null;
        }
    }

    public function searchArea($query)
    {
        return DB::table('areas')
            ->where('name', 'like', '%'.$query.'%')
            ->get();
    }
}
