<?php

namespace App\Http\Services;

use App\Model\Floor;
use DB;

class FloorService
{
    public function showAllFloors()
    {
        $floors = Floor::all();
        return $floors;
    }

    public function createFloor($data)
    {
        $floor = new Floor([
            'code' => $data->get('code'),
            'name' => $data->get('name')
        ]);
        $floor->save();

        return $floor;
    }

    public function getFloorById($id)
    {
        $floor = Floor::find($id);
        return $floor;
    }

    public function updateFloorById($data, $id)
    {
        $floor = Floor::find($id);
        $floor->code = $data->get('code');
        $floor->name = $data->get('name');
        $floor->save();

        return $floor;
    }

    public function deleteFloorById($id)
    {
        $floor = Floor::find($id);
        $floor->delete();

        return $floor;
    }

    public function searchCategory($query)
    {
        return DB::table('floors')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('code', 'like', '%'.$query.'%')
            ->get();
    }
}
