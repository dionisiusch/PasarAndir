<?php

namespace App\Http\Services;

use App\Model\StallWater;

class StallWaterService
{
    public function showAllStallWaters()
    {
        $stallWaters = StallWater::all();

        return $stallWaters;
    }

    public function createStallWater($data)
    {
        $stallWater = new StallWater([
            'stall_id' => $data->get('stall_id'),
            'meter_before' => $data->get('meter_before'),
            'meter_after' => $data->get('meter_after'),
            'price' => $data->get('price'),
            'fixed_price' => $data->get('price')
        ]);
        $stallWater->save();

        return $stallWater;
    }

    public function getStallWaterById($id)
    {
        $stallWater = StallWater::find($id);
        
        return $stallWater;
    }

    public function getNewestStallWaterById($id)
    {
        $stallWater = StallWater::where('stall_id', $id)->orderBy('created_at', 'DESC')->first();
        
        return $stallWater;
    }

    public function updateStallWaterById($data, $id)
    {
        $stallWater = StallWater::find($id);
        $stallWater->stall_id = $data->get('stall_id');
        $stallWater->meter_before = $data->get('meter_before');
        $stallWater->meter_after = $data->get('meter_after');
        $stallWater->save();

        return $stallWater;
    }

    public function deleteStallWaterById($id)
    {
        $stallWater = StallWater::find($id);
        $stallWater->delete();

        return $stallWater;
    }
}
