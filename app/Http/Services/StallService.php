<?php

namespace App\Http\Services;

use App\Model\Stall;
use DB;

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
            'electricity_id' => $data->get('electricity_id'),
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
        $stall->electricity_id = $data->get('electricity_id');
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
        $userId = DB::table('users')
            ->where('pic_name', 'like', '%'.$query.'%')
            ->orWhere('pic_phone_number', 'like', '%'.$query.'%')
            ->pluck('id');

        $categoryId = DB::table('categories')
            ->where('name', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->pluck('id');
        
        $floorId = DB::table('floors')
            ->where('code', 'like', '%'.$query.'%')
            ->orWhere('name', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->pluck('id');

        $areaId = DB::table('areas')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('no', 'like', '%'.$query.'%')
            ->orWhere('price', 'like', '%'.$query.'%')
            ->orWhereIn('floor_id', $floorId)
            ->whereNull('deleted_at')
            ->pluck('id');

        return DB::table('stalls')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('length', 'like', '%'.$query.'%')
            ->orWhere('width', 'like', '%'.$query.'%')
            ->orWhere('height', 'like', '%'.$query.'%')
            ->orWhere('status', 'like', '%'.$query.'%')
            ->orWhereIn('user_id', $userId)
            ->orWhereIn('category_id', $categoryId)
            ->orWhereIn('area_id', $areaId)
            ->whereNull('deleted_at')
            ->get();
    }

    public function getActive()
    {
        return DB::table('stalls')
            ->where('status', 'Aktif')
            ->get();
    }
}
