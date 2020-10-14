<?php

namespace App\Http\Services;

use App\Model\StallElectricity;

class StallElectricityService
{
    public function showAllStallElectricities()
    {
        $stallElectricities = StallElectricity::all();

        return $stallElectricities;
    }

    public function createStallElectricity($data)
    {
        $stallElectricity = new StallElectricity([
            'stall_id' => $data->get('stall_id'),
            'meter_before' => $data->get('meter_before'),
            'meter_after' => $data->get('meter_after'),
            'kva_price' => $data->get('kva_price'),
            'kwh_price' => $data->get('kwh_price')
        ]);
        $stallElectricity->save();

        return $stallElectricity;
    }

    public function getNewestStallElectricityById($id, $month)
    {
        $stallElectricity = StallElectricity::where('stall_id', $id)->whereMonth('created_at', $month)->orderBy('created_at', 'DESC')->first();
        
        return $stallElectricity;
    }

    public function getStallElectricityById($id)
    {
        $stallElectricity = StallElectricity::find($id);
        
        return $stallElectricity;
    }

    public function updateStallElectricityById($data, $id)
    {
        $stallElectricity = StallElectricity::find($id);
        $stallElectricity->stall_id = $data->get('stall_id');
        $stallElectricity->meter_before = $data->get('meter_before');
        $stallElectricity->meter_after = $data->get('meter_after');
        $stallElectricity->save();

        return $stallElectricity;
    }

    public function deleteStallElectricityById($id)
    {
        $stallElectricity = StallElectricity::find($id);
        $stallElectricity->delete();

        return $stallElectricity;
    }
}
