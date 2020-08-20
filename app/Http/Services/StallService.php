<?php

namespace App\Http\Services;

use App\Model\Stall;

class StallService
{
    public function showAllStalls()
    {
        $stalls = Stall::all();

        return $stalls;
    }

    public function createStall($data)
    {
        $stall = new Stall([
            'user_id' => $data->get('user_id'),
            'area_id' => $data->get('area_id'),
            'category_id' => $data->get('category_id'),
            'name' => $data->get('name'),
            'length' => $data->get('length'),
            'width' => $data->get('width'),
            'height' => $data->get('height'),
            'status' => $data->get('status')
        ]);
        $stall->save();

        return $stall;
    }

    public function getStallById($id)
    {
        $stall = Stall::find($id);
        
        return $stall;
    }

    public function updateStallById($data, $id)
    {
        $stall = Stall::find($id);
        $stall->user_id = $data->get('user_id');
        $stall->area_id = $data->get('area_id');
        $stall->category_id = $data->get('category_id');
        $stall->name = $data->get('name');
        $stall->length = $data->get('length');
        $stall->width = $data->get('width');
        $stall->height = $data->get('height');
        $stall->status = $data->get('status');
        $stall->save();

        return $stall;
    }

    public function deleteStallById($id)
    {
        $stall = Stall::find($id);
        $stall->delete();

        return $stall;
    }

    public function searchStall($query)
    {
        return DB::table('stalls')
            ->where('name', 'like', '%'.$query.'%')
            ->get();
    }
}
