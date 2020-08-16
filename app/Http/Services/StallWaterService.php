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
        $stallWaters = new StallWater([
            'stall_id' => $data->get('stall_id'),
            'meter_before' => $data->get('meter_before'),
            'meter_after' => $data->get('meter_after'),
            'price' => $data->get('price') //HARUSNYA GA GINI, NANTI DIBENERIN KALO UDAH MAU JADI
        ]);
        $stallWaters->save();

        return $stallWaters;
    }

    public function getStallWaterById($id)
    {
        $stallWaters = StallWater::find($id);
        
        return $stallWaters;
    }

    public function updateStallWaterById($data, $id)
    {
        $stallWaters = StallWater::find($id);
        $stallWaters->stall_id = $data->get('stall_id');
        $stallWaters->meter_before = $data->get('meter_before');
        $stallWaters->meter_after = $data->get('meter_after');
        $stallWaters->save();

        return $stallWaters;
    }

    public function deleteStallWaterById($id)
    {
        $stallWaters = StallWater::find($id);
        $stallWaters->delete();

        return $stallWaters;
    }
}
